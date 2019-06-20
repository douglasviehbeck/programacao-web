FROM php:7.2-cli

RUN apt-get update
RUN apt-get install --no-install-recommends apt-utils -y

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get install libxml2-dev -y
RUN apt-get install zlib1g-dev -y
RUN docker-php-ext-install pdo_mysql dom json zip mbstring

ADD . /var/www

WORKDIR /var/www

RUN cp /var/www/.env.example /var/www/.env
RUN cp /var/www/frontend/resources/js/.env.example.json /var/www/frontend/resources/js/.env.json

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"

RUN curl -sL https://deb.nodesource.com/setup_11.x | bash -

RUN apt-get install nodejs -y

RUN php composer.phar install

WORKDIR /var/www/frontend/resources/js

WORKDIR /var/www/frontend
RUN npm install
RUN npm run dev

WORKDIR /var/www

CMD php artisan serve --host=0.0.0.0 --port=80 & cd frontend; php -S 0.0.0.0:81 public/index.php
