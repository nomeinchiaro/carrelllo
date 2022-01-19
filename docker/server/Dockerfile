FROM php:8.1-apache

ENV NVM_VERSION=0.39.1
ENV NODE_VERSION=16.13.1

RUN apt-get update && apt-get install -y vim curl qrencode zbar-tools libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*

RUN printf "\n" | pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install bcmath \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY ./default.conf /etc/apache2/sites-available/000-default.conf
COPY ./xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Install openapi-generator-cli
RUN apt install -y curl
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v${NVM_VERSION}/install.sh | bash
ENV NVM_DIR=/root/.nvm
RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"
RUN npm install @openapitools/openapi-generator-cli -g

# Install OpenJDK
RUN apt-get update && \
    apt-get install -y openjdk-11-jdk && \
    apt-get install -y ant && \
    apt-get clean;
    
# Fix certificate issues
RUN apt-get update && \
    apt-get install ca-certificates-java && \
    apt-get clean && \
    update-ca-certificates -f;

# Setup JAVA_HOME -- useful for docker commandline
ENV JAVA_HOME /usr/lib/jvm/java-11-openjdk-amd64/
RUN export JAVA_HOME

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git

RUN echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | tee /etc/apt/sources.list.d/symfony-cli.list && \
    apt update && \ 
    apt install -y symfony-cli

# Enable apache modules !!!IMPORTANT!!!
RUN a2enmod rewrite headers

COPY ./ /var/www/html/

