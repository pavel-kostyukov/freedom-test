ARG PHP_VERSION=8.1.3

FROM php:${PHP_VERSION}-fpm-alpine

ENV USER=www-data
ENV UID=1000
ENV GID=1000

RUN deluser www-data
RUN addgroup --gid "$GID" "$USER"
RUN adduser \
    --disabled-password \
    --gecos "" \
    --home "$(pwd)"\
    --ingroup "$USER" \
    --no-create-home \
    --uid "$UID" \
    "$USER"

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
 && chmod 755 /usr/bin/composer

RUN set -eux; \
    apk add --no-cache \
        gnu-libiconv=1.15-r3 --update-cache --repository http://dl-cdn.alpinelinux.org/alpine/v3.13/community/ --allow-untrusted \
        freetype \
        libpng \
        libjpeg-turbo \
        freetype-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        php8-mbstring \
        php8-xml \
        php8-xmlreader \
        libxml2-dev \
        oniguruma-dev \
        zlib-dev \
        libzip-dev \
    ; \
    \
    docker-php-ext-install -j$(nproc) \
        bcmath \
        pdo \
        pdo_mysql \
        xml \
        pcntl \
        mbstring \
        zip \
        exif \
        gd \
    ;

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so

WORKDIR /var/www/app

USER $USER
