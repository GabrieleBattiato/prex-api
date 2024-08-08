FROM php:8.2.5-apache

WORKDIR /var/www/html

ARG WWWGROUP

RUN apt-get update && \
    apt-get install -y \
    git \
    libzip-dev \
    libpng-dev \
    libicu-dev \
    libpq-dev \
    libmagickwand-dev

RUN docker-php-ext-install pdo_mysql zip exif pcntl bcmath gd
RUN a2enmod rewrite

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

CMD ["apache2-foreground"]