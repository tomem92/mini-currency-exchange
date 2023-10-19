FROM php:8.2-cli

RUN apt update && apt install -y libcurl4-openssl-dev libicu-dev libonig-dev git zip \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install curl intl mbstring pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 9000

WORKDIR /app
