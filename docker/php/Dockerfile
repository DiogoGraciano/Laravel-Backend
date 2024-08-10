FROM php:8.3-fpm

RUN apt-get update -y && apt-get install -y openssl zip unzip git curl libpng-dev libonig-dev libxml2-dev zip unzip

RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd sockets

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

WORKDIR /var/www

RUN chown -R "$(id -u):$(id -g)" /var/www

# Expor o serviço na porta 9000
EXPOSE 8000

