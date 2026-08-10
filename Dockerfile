FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev \
    libonig-dev libxml2-dev libpq-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql zip gd bcmath

RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --optimize-autoloader --no-dev --no-interaction
RUN npm install && npm run build

RUN php artisan storage:link || true

EXPOSE 8080

CMD ["bash", "-c", "\
  echo '>> clearing config' && php artisan config:clear && \
  echo '>> running migrations' && php artisan migrate --force && \
  echo '>> caching config' && php artisan config:cache && \
  echo '>> caching routes' && php artisan route:cache && \
  echo '>> caching views' && php artisan view:cache && \
  echo '>> starting server' && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
