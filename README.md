# optipng-jpegoptim-php-cron
  
Recursively optimize jpg and png images 


## Install image utils (ubuntu)

    sudo apt install jpegoptim
    sudo apt install optipng

set work path in task_optipng_jpegoptim.php for example:

    $path = '/var/www';
    

## Add to cron example
    # At 01:00 on Sunday.
    0 1 * * 0 cd /path/to/script/ && /usr/bin/php task_optipng_jpegoptim.php 2<&1 | /usr/bin/mail -s "Cron Opti images" email@email.be




## Links

[jpegoptim](https://github.com/tjko/jpegoptim)

[optipng](http://optipng.sourceforge.net/)
