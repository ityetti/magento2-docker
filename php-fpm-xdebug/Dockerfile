FROM arm64v8/php:8.3-fpm as php

ARG MAGENTO_ROOT=/home/magento

ENV PHP_MEMORY_LIMIT 4G
ENV PHP_VALIDATE_TIMESTAMPS 1
ENV DEBUG false
ENV MAGENTO_RUN_MODE default
ENV UPLOAD_MAX_FILESIZE 64M
ENV PHPRC ${MAGENTO_ROOT}/php.ini
ENV PHP_EXTENSIONS bcmath bz2 calendar exif gd gettext intl mysqli opcache pdo_mysql redis soap sockets sodium sysvmsg sysvsem sysvshm xsl zip pcntl

# Configure Node.js version
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash

# Install dependencies
RUN apt-get update \
  && apt-get upgrade -y \
  && apt-get install -y --no-install-recommends \
  apt-utils \
  sendmail-bin \
  sendmail \
  sudo \
  iproute2 \
  git \
  gnupg2 \
  ca-certificates \
  lsb-release \
  software-properties-common \
  libbz2-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  libfreetype6-dev \
  libgmp-dev \
  libgpgme11-dev \
  libicu-dev \
  libldap2-dev \
  libpcre3-dev \
  libpspell-dev \
  libtidy-dev \
  libxslt1-dev \
  libyaml-dev \
  libzip-dev \
  zip \
  && rm -rf /var/lib/apt/lists/*

# Install Mailpit
RUN bash -c "$(curl -sL https://raw.githubusercontent.com/axllent/mailpit/develop/install.sh)"
RUN echo "sendmail_path = /usr/local/bin/mailpit sendmail -S mailpit:1025" >> /usr/local/etc/php/conf.d/sendmail.ini

# Configure the gd library
RUN docker-php-ext-configure \
  gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-configure \
  opcache --enable-opcache

# Install required PHP extensions
RUN docker-php-ext-install -j$(nproc) \
  bcmath \
  bz2 \
  calendar \
  exif \
  gd \
  gettext \
  gmp \
  intl \
  mysqli \
  opcache \
  pdo_mysql \
  pspell \
  shmop \
  soap \
  sockets \
  sysvmsg \
  sysvsem \
  sysvshm \
  tidy \
  xsl \
  zip \
  pcntl

RUN pecl install -o -f \
  gnupg \
  mailparse \
  msgpack \
  oauth \
  pcov \
  raphf \
  redis \
  xdebug-3.4.2 \
  xmlrpc-1.0.0RC3 \
  yaml

# Install Composer
RUN apt-get update
RUN apt-get install -y wget
RUN wget -O composer-setup.php https://getcomposer.org/installer
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN chmod +x /usr/local/bin/composer

# Install n98-magerun2
RUN wget https://files.magerun.net/n98-magerun2.phar \
    && chmod +x n98-magerun2.phar \
    && mv n98-magerun2.phar /usr/local/bin/n98-magerun2

# Install Grunt
RUN apt-get update
RUN apt-get install -y nodejs
RUN npm install -g grunt-cli

COPY etc/php-fpm.ini /usr/local/etc/php/conf.d/magento.ini
COPY etc/php-xdebug.ini /usr/local/etc/php/conf.d/xdebug-settings.ini
COPY etc/php-pcov.ini /usr/local/etc/php/conf.d/pcov-settings.ini
COPY etc/php-fpm.conf /usr/local/etc/
COPY etc/php-gnupg.ini /usr/local/etc/php/conf.d/gnupg.ini

RUN groupadd -g 2000 magento && useradd -g 2000 -u 2000 -d ${MAGENTO_ROOT} -s /bin/bash magento

COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN ["chmod", "+x", "/docker-entrypoint.sh"]

RUN mkdir -p ${MAGENTO_ROOT}

VOLUME ${MAGENTO_ROOT}

RUN chown -R magento:magento /usr/local /var/www /var/log /usr/local/etc/php/conf.d ${MAGENTO_ROOT}

ENTRYPOINT ["/docker-entrypoint.sh"]

WORKDIR ${MAGENTO_ROOT}

USER root

CMD ["php-fpm", "-R"]