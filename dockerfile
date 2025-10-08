# Dockerfile (simple, runs php artisan serve)
FROM php:8.2-cli

# set working dir
WORKDIR /var/www/html

# install system deps
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev libonig-dev libpq-dev

# install php extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd

# install composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# copy app
COPY . /var/www/html

# install composer deps (no dev in production)
RUN composer install --no-dev --optimize-autoloader --prefer-dist

# set permissions (storage + cache)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# expose port (Railway uses $PORT env)
EXPOSE 8000

# entrypoint: migrate then serve
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
