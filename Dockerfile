FROM php:8.4-alpine

WORKDIR /app

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

COPY . .

RUN apk update && apk upgrade && apk add bash && chmod +x /usr/local/bin/install-php-extensions && sync \
    && install-php-extensions @composer-2.8.8 && install-php-extensions xdebug