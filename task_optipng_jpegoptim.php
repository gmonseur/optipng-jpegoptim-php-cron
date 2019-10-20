#!/usr/bin/php

<?php
$path = '.';
$debug[
	'enable' = true,
	'total_imgs' => 0,
	'optimized' => 0
];
$Directory = new RecursiveDirectoryIterator($path);
$Iterator = new RecursiveIteratorIterator($Directory);
$Regex_jpg = new RegexIterator($Iterator, '/^.+(.jpe?g)$/i', RecursiveRegexIterator::GET_MATCH);
$Regex_png = new RegexIterator($Iterator, '/^.+(.png)$/i', RecursiveRegexIterator::GET_MATCH);
foreach($Regex_jpg as $name => $Regex){
	if ($debug['enable']) $debug['total_imgs']++;
    $output = shell_exec ( 'jpegoptim --strip-all -n -m80 -t -p \''.$name.'\'');
    $compression_persentage = explode('Average compression (1 files):', $output);
    if (isset($compression_persentage[1])) {
	    $compression_persentage = explode('%', $compression_persentage[1])[0];
	    if ($debug['enable']) echo "$name: $compression_persentage\n";
	    if ($compression_persentage > 20) {
		    shell_exec ( 'jpegoptim --strip-all -m80 -t -p \''.$name.'\'');
			$debug['optimized']++;
	    	if ($debug['enable']) echo "debug['optimized']: $debug['optimized'], compression_persentage: $compression_persentage\n\n";
	    }
    }
}
foreach($Regex_png as $name => $Regex){
    $output = shell_exec ( 'optipng  -f2 -zc9 -zm9 -zs3 -nz -nx -np -nc -nb \''.$name.'\'');
 	if ($debug['enable']){
	 	$debug['total_imgs']++;
	    echo $output;
 	} 
}

if ($debug['enable']) {
	print_r($debug);
}

?>
