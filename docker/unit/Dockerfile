FROM arm64v8/unit:1.31.0-php8.2

RUN apt update  \
    && apt install -y libpq5 libpq-dev git zip unzip \
    && docker-php-ext-install pdo pdo_pgsql bcmath \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/bin \
    && php -r "unlink('composer-setup.php');" \
    && mv /usr/bin/composer.phar /usr/bin/composer
