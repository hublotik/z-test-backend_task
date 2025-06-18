#!/usr/bin/env sh
set -e

FILE=/var/www/html/.env
if [ ! -f "$FILE" ]; then
    set > $FILE
fi

sed -i "s/'/\"/g" $FILE

if [ ! -d "vendor" ]; then composer install; fi;

#service supervisor start

#/usr/sbin/cron -f
#tail -f /dev/null
php-fpm -D
echo "start nginx"
nginx -g 'daemon off;'
