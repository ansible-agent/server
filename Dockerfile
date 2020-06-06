FROM php:7.4-apache


COPY index.php /var/www/html/index.php
COPY site.conf /etc/apache2/sites-enabled/000-default.conf
RUN a2enmod alias

EXPOSE 80
