# Use the latest Composer image as a builder
FROM php:8.2-fpm AS build

# Set the working directory to /app
WORKDIR /var/www/html

# Install Linux Library
RUN apt-get update && apt-get install -y \
    libicu-dev \
    unzip \
    zip

# Install PHP and necessary extensions
RUN apt-get update && apt-get install -y \
    build-essential \
    openssl \
    nginx \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libicu-dev \
    libwebp-dev \
    zlib1g-dev \
    libzip-dev \
    gcc \
    g++ \
    make \
    vim \
    unzip \
    curl \
    git \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    locales \
    libonig-dev \
    nodejs

# Install PHP extensions
RUN docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) \
    gd \
    gmp \
    pdo_mysql \
    mbstring \
    intl \
    sockets \
    pcntl \
    bcmath \
    zip \
    # Clean up
    && apt-get autoclean -y \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /tmp/pear/


# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Run Laravel specific commands
RUN php artisan key:generate \
    && php artisan config:clear \
    && php artisan config:cache \
    && php artisan storage:link
