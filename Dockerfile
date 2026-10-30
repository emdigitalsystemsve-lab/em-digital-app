FROM php:8.2-cli

# Instalar librerías y extensiones de PostgreSQL para PHP
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY . /usr/src/myapp
WORKDIR /usr/src/myapp

EXPOSE 10000
CMD [ "php", "-S", "0.0.0.0:10000" ]
