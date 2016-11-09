ip=`hostname -I | grep -Eo [0-9.]+`
php -c /etc/php/7.0/cli/php.ini -S $ip:80
