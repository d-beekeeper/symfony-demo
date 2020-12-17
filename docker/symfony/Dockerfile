FROM php:7.4

RUN apt-get update
RUN apt-get install -y git
RUN apt-get install -y ssh
RUN apt-get install -y unzip
RUN apt-get install -y libxml2-dev
RUN apt-get install -y libicu-dev
RUN apt-get install -y libcurl4-gnutls-dev
RUN apt-get install -y libfreetype6-dev
RUN apt-get install -y libjpeg62-turbo-dev
RUN apt-get install -y libpng-dev
RUN apt-get install -y libxrender1
RUN apt-get install -y libfontconfig
RUN apt-get install -y libssl-dev
RUN apt-get install -y libpq-dev
RUN apt-get install -y libnghttp2-dev
RUN apt-get install -y libzip-dev
RUN apt-get install -y libssl-dev
RUN apt-get install -y librabbitmq-dev
RUN apt-get install -y libonig-dev
RUN apt-get install -y mc
RUN apt-get install -y iproute2
RUN apt-get install -y iputils-ping
RUN apt-get install -y wget
RUN apt-get install -y gnupg
RUN apt-get install -y sqlite3
RUN apt-get install -y libsqlite3-dev
# Install PHP extensions.
RUN docker-php-ext-install pdo
RUN docker-php-ext-install ctype
RUN docker-php-ext-install json
RUN docker-php-ext-install pdo_sqlite
RUN docker-php-ext-install intl
RUN docker-php-ext-install xml
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install curl
RUN docker-php-ext-install gd
RUN docker-php-ext-install opcache
RUN docker-php-ext-install zip
RUN docker-php-ext-install pcntl
# Install Composer.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#Install Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Fix PHP memory limit.
RUN echo "memory_limit=-1" > $PHP_INI_DIR/conf.d/memory-limit.ini \
    && echo "realpath_cache_size=4M" >> $PHP_INI_DIR/conf.d/memory-limit.ini \
    && echo "post_max_size=100M" > $PHP_INI_DIR/conf.d/post-size.ini \
    && echo "upload_max_filesize=99M" >> $PHP_INI_DIR/conf.d/post-size.ini

# Configure xdebug
RUN pecl install -o -f xdebug-2.9.8
RUN echo "zend_extension=xdebug.so" > $PHP_INI_DIR/conf.d/xdebug.ini

WORKDIR /var/www/backend
