FROM alpine:3.20

RUN apk update && apk add \
    bash \
    ca-certificates \
    curl \
    git \
    libcap2 \
    libpng-dev \
    librsvg \
    lsb-release-minimal \
    php83 \
    php83-bz2 \
    php83-curl \
    php83-ctype \
    php83-dev \
    php83-fileinfo \
    php83-intl \
    php83-json \
    php83-mbstring \
    php83-mysqli \
    php83-pdo \
    php83-pdo_mysql \
    php83-phar \
    php83-opcache \
    php83-openssl \
    php83-pecl-apcu \
    php83-pecl-pcov \
    php83-pecl-xdebug \
    php83-session \
    php83-simplexml \
    php83-tokenizer \
    php83-xml \
    php83-zip \
    sudo

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY php.ini /etc/php83/conf.d/99-overrides.ini

WORKDIR /var/www/html

COPY .. .

CMD ["sh", "-c", "php -S 0.0.0.0:${APP_PORT} -t public"]
