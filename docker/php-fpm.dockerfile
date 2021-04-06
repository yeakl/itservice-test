FROM php:7.4-fpm

RUN apt-get update \
&& apt-get install -y libzip-dev unzip \
&& docker-php-ext-install pdo pdo_mysql zip \
&& php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
&& php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
&& php -r "unlink('composer-setup.php');"

WORKDIR /app