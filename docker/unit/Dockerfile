FROM maffinca69/nginx-unit-m1:latest

RUN apt update  \
    && apt install -y libpq5 libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/bin \
    && php -r "unlink('composer-setup.php');" \
    && mv /usr/bin/composer.phar /usr/bin/composer
