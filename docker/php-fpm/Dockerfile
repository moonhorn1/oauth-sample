FROM phpdockerio/php72-fpm:latest
WORKDIR "/app/server"

## Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install php7.2-mysql php7.2-intl \
    && apt-get install -y openssl \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY --from=composer /usr/bin/composer /usr/bin/composer

CMD mkdir -p var/key/ && openssl genrsa -out /app/server/var/key/private.key 2048  \
    && openssl rsa -in /app/server/var/key/private.key -pubout -out /app/server/var/key/public.key  \
    && chmod 600 /app/server/var/key/private.key && chmod 600  /app/server/var/key/public.key ; \
    composer install ; php-fpm
