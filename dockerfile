FROM php:8.5-cli

RUN apt-get update && apt-get install -y \
    unzip curl git zip libzip-dev libonig-dev nodejs npm \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN mkdir -p database && touch database/database.sqlite

RUN rm -rf public/build
RUN npm install
RUN npm run build

RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

RUN chmod -R 775 storage bootstrap/cache database

EXPOSE 10000

CMD sh -c "mkdir -p database && touch database/database.sqlite && chmod -R 775 database && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"
