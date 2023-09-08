#!/usr/bin/php

<?php
$path = '.';
$debug = [
	'enable' => true,
	'total_imgs' => 0,
	'optimized' => 0
];

function colorLog($str, $type = 'i'){
    switch ($type) {
        case 'e': //error
            echo "\033[31m$str \033[0m\n";
        break;
        case 's': //success
            echo "\033[32m$str \033[0m\n";
        break;
        case 'w': //warning
            echo "\033[33m$str \033[0m\n";
        break;  
        case 'i': //info
            echo "\033[36m$str \033[0m\n";
        break;      
        default:
        # code...
        break;
    }
}

$Directory = new RecursiveDirectoryIterator($path);
$Iterator = new RecursiveIteratorIterator($Directory);
$Regex_jpg = new RegexIterator($Iterator, '/^.+(.jpe?g)$/i', RecursiveRegexIterator::GET_MATCH);
$Regex_png = new RegexIterator($Iterator, '/^.+(.png)$/i', RecursiveRegexIterator::GET_MATCH);
foreach($Regex_jpg as $name => $Regex){
	
	$output = shell_exec ( 'jpegoptim --strip-all -n -m80 -t -p \''.$name.'\'');

	$compression_persentage = explode('Average compression (1 files):', $output);
	if (isset($compression_persentage[1])) {
	    $compression_persentage = explode('%', $compression_persentage[1])[0];
	    
	    
	    if ($compression_persentage > 20) {
		    shell_exec ( 'jpegoptim --strip-all -m80 -t -p \''.$name.'\''); 
	    	if ($debug['enable']){
	    		$debug['optimized']++;
	    		colorLog("$name: Optimized !($compression_persentage)\n", "s");	
	    	} 
	    }else{
			if ($debug['enable']) colorLog("$name: Already Optimized ! ($compression_persentage)\n", "w") ;
	    }
	    
	    if ($debug['enable']) {	
			$debug['total_imgs']++;
		}	

    }   
    
}

foreach($Regex_png as $name => $Regex){
	$output = '';
    exec ( 'optipng  -verbose -o1 -preserve \''.$name.'\' 2>&1', $output);
 	
 	if ($debug['enable']){

	 	$debug['total_imgs']++;

	 	$txt_search = 'is already optimized';
	 	$png_already_opti = array_filter($output, function($element) use ($txt_search) {
    		return stripos($element, $txt_search) !== false;
		});

		if (empty($png_already_opti)) {
			$debug['optimized']++;
			colorLog($output[0].": Optimized ! \n", "s");
		}else{
			colorLog($output[0].": Already optimized ! \n", "w");
		}
	 
 	} 
}

if ($debug['enable']) {
	print_r($debug);
}
