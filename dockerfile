FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    unzip curl git zip libzip-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Node (para Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

# FRONTEND BUILD (ESSENCIAL)
RUN rm -rf public/build

RUN npm install
RUN npm run build

RUN php artisan config:clear || true

RUN chmod -R 777 storage bootstrap/cache

EXPOSE 10000

CMD php -S 0.0.0.0:10000 -t public
