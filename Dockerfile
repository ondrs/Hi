FROM php:7.2-cli

# basic deps
RUN apt-get update && \
    apt-get install -y \
    git \
    zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
