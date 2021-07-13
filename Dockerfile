FROM php:7.2-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    zlib1g-dev \
    libicu-dev \
    g++



# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl intl mysqli

RUN apt-get update && apt-get install -y \
    libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick

RUN apt -qy install $PHPIZE_DEPS && pecl install xdebug && docker-php-ext-enable xdebug

RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www
RUN rm -rf /var/www/configs/main-local.php && \
    rm -rf /var/www/configs/project-local.php && \
    rm -rf /var/www/configs/plugins-local.php && \
    rm -rf /var/www/configs/backend/main-local.php && \
    rm -rf /var/www/configs/frontend/main-local.php && \
    rm -rf /var/www/configs/console/main-local.php && \
    rm -rf /var/www/configs/console/main-local.php && \
    rm -rf /var/www/web/static/assets/* && \
    rm -rf /var/www/web/static/packages/* && \
    rm -rf /var/www/web/static/thumbs/* && \
    rm -rf /var/www/web/static/uploads/* && \
    chown -R www:www /var/www

RUN composer global require "fxp/composer-asset-plugin:^1.2.0" && \
    composer install
# Change current user to www
USER www

# Expose port 9000 and start container
EXPOSE 9000
CMD ["/var/www/docker/app/init"]