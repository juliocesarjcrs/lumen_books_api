FROM php:7.4.1-apache

USER root

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
   libpng-dev \
   zlib1g-dev \
   libxml2-dev \
   libzip-dev \
   libonig-dev \
   zip \
   curl \
   unzip \
   && docker-php-ext-configure gd \
   && docker-php-ext-install -j$(nproc) gd \
   && docker-php-ext-install pdo_mysql \
   && docker-php-ext-install mysqli \
   && docker-php-ext-install zip \
   && docker-php-source delete

# Install xdebug for development
# RUN    pecl install xdebug \
#     && docker-php-ext-enable xdebug
# # Copy the configuration file into xdebug, if running phpinfo() you see the loaded file is not this one, change the path accordingly. 
# COPY xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN pecl install -f xdebug \
&& echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini;

COPY . /var/www/html
COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chown -R www-data:www-data /var/www/html \
   && a2enmod rewrite
# RUN pwd
# hasta aqui funciona
RUN composer install
# RUN chmod 777 -R  storage/ /var/www/html
# RUN chmod -R 775 storage bootstrap/cache /var/www/html