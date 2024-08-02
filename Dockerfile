# Koristi službeni PHP runtime kao osnovnu sliku
FROM php:8.3-apache

# Postavi radni direktorijum
WORKDIR /var/www/html

# Instaliraj PHP ekstenzije
RUN docker-php-ext-install pdo pdo_mysql

# Kopiraj trenutni direktorijum sadržaja u kontejner na /var/www/html
COPY . /var/www/html

# Instaliraj Composer iz službene Composer slike
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instaliraj projektne zavisnosti
RUN composer install

# Omogući Apache mod_rewrite
RUN a2enmod rewrite

# Postavi Apache konfiguraciju za direktorijum
RUN echo "<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" > /etc/apache2/conf-available/bookstore.conf && \
    a2enconf bookstore

# Postavi odgovarajuće dozvole
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Izloži port 80
EXPOSE 80

# Pokreni Apache server
CMD ["apache2-foreground"]
