FROM php:8.4-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev \
    libonig-dev libxml2-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring \
       tokenizer xml ctype bcmath fileinfo zip gd opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Node.js 22
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction
RUN npm install && npm run build

# Laravel setup
RUN cp .env.example .env 2>/dev/null || true
RUN php artisan config:clear

EXPOSE 8080

CMD php artisan migrate --force \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan serve --host=0.0.0.0 --port=$PORT