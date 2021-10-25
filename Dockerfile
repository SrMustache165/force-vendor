FROM php:8.0.10-fpm-alpine3.13 as builder

COPY --from=composer:2.0.11 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

FROM builder as build

COPY . .

#RUN apk add postgresql-dev && docker-php-ext-install pdo pdo_pgsql

RUN docker-php-ext-install pdo

RUN apk add gnupg

#Download the desired package(s)
RUN curl -O https://download.microsoft.com/download/e/4/e/e4e67866-dffd-428c-aac7-8d28ddafb39b/msodbcsql17_17.8.1.1-1_amd64.apk
RUN curl -O https://download.microsoft.com/download/e/4/e/e4e67866-dffd-428c-aac7-8d28ddafb39b/mssql-tools_17.8.1.1-1_amd64.apk


#(Optional) Verify signature, if 'gpg' is missing install it using 'apk add gnupg':
RUN curl -O https://download.microsoft.com/download/e/4/e/e4e67866-dffd-428c-aac7-8d28ddafb39b/msodbcsql17_17.8.1.1-1_amd64.sig
RUN curl -O https://download.microsoft.com/download/e/4/e/e4e67866-dffd-428c-aac7-8d28ddafb39b/mssql-tools_17.8.1.1-1_amd64.sig

RUN curl https://packages.microsoft.com/keys/microsoft.asc  | gpg --import -
RUN gpg --verify msodbcsql17_17.8.1.1-1_amd64.sig msodbcsql17_17.8.1.1-1_amd64.apk
RUN gpg --verify mssql-tools_17.8.1.1-1_amd64.sig mssql-tools_17.8.1.1-1_amd64.apk

#Install the package(s)
RUN apk add --allow-untrusted msodbcsql17_17.8.1.1-1_amd64.apk
RUN apk add --allow-untrusted mssql-tools_17.8.1.1-1_amd64.apk

RUN set -xe \
    && apk add --no-cache --virtual .persistent-deps \
        freetds \
        unixodbc \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        unixodbc-dev \
        freetds-dev \
    && docker-php-source extract \
    && docker-php-ext-install pdo_dblib \
    && pecl install \
        sqlsrv \
        pdo_sqlsrv \
    && docker-php-source delete \
    && apk del .build-deps

RUN echo extension=pdo_sqlsrv.so >> `php --ini | grep "Scan for additional .ini files" | sed -e "s|.*:\s*||"`/10_pdo_sqlsrv.ini
RUN echo extension=sqlsrv.so >> `php --ini | grep "Scan for additional .ini files" | sed -e "s|.*:\s*||"`/00_sqlsrv.ini

RUN apk add nginx supervisor

COPY build/nginx.conf /etc/nginx/nginx.conf
COPY build/forcevendorcore.internal.conf /etc/nginx/conf.d/default.conf
COPY build/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

CMD [ "supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf", "-n" ]

FROM build as prod

RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs

FROM build as dev

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-3.0.3 \
    && docker-php-ext-enable xdebug

ENV XDEBUG_SESSION=VSCODE

COPY build/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN touch /var/log/xdebug_remote.log
RUN chmod 777 /var/log/xdebug_remote.log

RUN composer install