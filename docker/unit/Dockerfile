FROM maffinca69/nginx-unit-m1:latest

RUN apt update  \
    && apt install -y libpq5 libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql
