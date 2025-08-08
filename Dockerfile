FROM php:8.2-apache

# OS deps
RUN apt-get update && apt-get install -y \
    libicu-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    unzip git curl && rm -rf /var/lib/apt/lists/*

# Apache + PHP extensions
RUN a2enmod rewrite headers expires
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) pdo pdo_mysql mysqli gd zip intl bcmath opcache

# Document root = Laravel public
ARG DOCROOT=/var/www/html/public
ENV APACHE_DOCUMENT_ROOT=${DOCROOT}
RUN sed -ri "s#DocumentRoot /var/www/html#DocumentRoot ${APACHE_DOCUMENT_ROOT}#g" /etc/apache2/sites-available/000-default.conf \
 && sed -ri "s#<Directory /var/www/>#<Directory ${APACHE_DOCUMENT_ROOT}>#g" /etc/apache2/apache2.conf \
 && sed -ri "s#AllowOverride None#AllowOverride All#g" /etc/apache2/apache2.conf

# Workdir and app copy
WORKDIR /var/www/html
COPY . /var/www/html

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# Laravel bootstrap steps (safe to re-run)
RUN php artisan storage:link || true

# Permissions
RUN chown -R www-data:www-data /var/www/html

# Healthcheck
HEALTHCHECK --interval=30s --timeout=5s --retries=5 CMD curl -fsS http://127.0.0.1/ || exit 1

EXPOSE 80

# Run artisan boot tasks at container start, then launch Apache
CMD php artisan config:cache && php artisan route:cache && php artisan view:cache && apache2-foreground
