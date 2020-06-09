FROM php:7.4-apache as base


COPY index.php /var/www/html/index.php
COPY site.conf /etc/apache2/sites-enabled/000-default.conf
RUN a2enmod alias

# Log to container stdout
RUN ln -sf /dev/stdout /var/www/html/request.log

FROM base as test

RUN php -l /var/www/html/index.php


FROM base as final

EXPOSE 80
