# optipng-jpegoptim-php-cron
  
Recursively optimize jpg and png images 


## Install image utils (ubuntu)

    sudo apt install jpegoptim
    sudo apt install optipng

set work path in task_optipng_jpegoptim.php for example:

    $path = '/var/www';
    

## Add to cron daily (ubuntu)
  chmod +x task_optipng_jpegoptim.php && ln -s $_ /etc/cron.daily/. 



## Links

[jpegoptim](https://github.com/tjko/jpegoptim)

[optipng](http://optipng.sourceforge.net/)
