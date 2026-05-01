FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql intl zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN sed -ri -e 's!/var/www/html!/var/www/html/app/public!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf \
    && printf '<Directory /var/www/html/app/public>\n\
        AllowOverride None\n\
        Require all granted\n\
        FallbackResource /index.php\n\
    </Directory>\n' > /etc/apache2/conf-available/symfony.conf \
    && a2enconf symfony

WORKDIR /var/www/html/app