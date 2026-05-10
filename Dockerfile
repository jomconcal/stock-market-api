FROM php:8.4-fpm

# -----------------------------
# System dependencies (incluye herramientas para compilar extensiones)
# -----------------------------
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libxml2-dev \
    zip \
    autoconf \
    gcc \
    make \
    && rm -rf /var/lib/apt/lists/*

# -----------------------------
# PHP extensions (las que ya tenías)
# -----------------------------
RUN docker-php-ext-install \
    pdo_mysql \
    intl \
    zip \
    opcache

# -----------------------------
# Xdebug (DEV ONLY)
# -----------------------------
RUN pecl install xdebug-3.5.1 \
    && docker-php-ext-enable xdebug

# -----------------------------
# Configuración extra de Xdebug (opcional, también podrías usar ENV)
# -----------------------------
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# -----------------------------
# Composer
# -----------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# -----------------------------
# Copiar dependencias primero (caché)
# -----------------------------
COPY composer.json composer.lock ./

# -----------------------------
# Copiar el resto del código
# -----------------------------
COPY . .
RUN composer install --no-interaction --prefer-dist

# -----------------------------
# Permisos para Symfony
# -----------------------------
RUN chown -R www-data:www-data var

EXPOSE 9000

CMD ["php-fpm"]
