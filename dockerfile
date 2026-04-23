FROM php:8.5-cli

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    unzip curl git zip libzip-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Node (Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# Instala dependências PHP
RUN composer install --no-dev --optimize-autoloader

# 🔥 CRIA SQLITE (se você continuar usando)
RUN mkdir -p database && touch database/database.sqlite

# 🔥 FRONTEND BUILD
RUN rm -rf public/build
RUN npm install
RUN npm run build

# 🔥 Laravel setup produção
RUN php artisan key:generate --force || true
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# 🔥 Migrations (importante)
RUN php artisan migrate --force || true

# Permissões (menos agressivo que 777)
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD php -S 0.0.0.0:10000 -t public
