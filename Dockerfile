## If you need to change PHP version for the 7.2, then you can change like this "php:7.2-apache"
FROM php:7.0.27-apache

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    autoconf \
    curl \
    git \
    subversion \
    libmcrypt-dev \
    libpng-dev \
    libxslt-dev \
    libbz2-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libldb-dev \
    libldap2-dev \
    make \
    unzip \
    wget && \
    docker-php-ext-install bcmath mcrypt bz2 zip mbstring pcntl xsl && \
    apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false; \
    rm -rf /var/lib/apt/lists/*

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ && \
    ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

WORKDIR /var/www/html/

RUN composer require facebook/webdriver
RUN mv -f ./* ../
COPY ./html/ ./

CMD ["apache2-foreground"]
