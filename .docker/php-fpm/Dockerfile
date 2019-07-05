FROM centos:7

RUN yum update -y && \
    yum install -y epel-release

RUN yum install -y http://rpms.remirepo.net/enterprise/remi-release-7.rpm && \
    yum install -y yum-utils && \
    yum-config-manager --enable remi-php72 && \
    yum -y update

RUN yum install -y \
    php-fpm \
    php-cli \
    php-opcache\
    php-gd \
    php-xml \
    php-bcmath \
    php-dba \
    php-intl \
    php-mbstring \
    php-mysql \
    php-pdo \
    php-soap \
    php-pecl-apcu \
    php-pecl-imagick \
    php-zip \
    php-pear \
    php-devel

## Install Magento Dependencies
#RUN yum install -y \
#    curl \
#    git \
#    gnupg \
#    vim \
#    wget \
#    lynx \
#    psmisc \
#    unzip \
#    tar \
#    bash-completion

RUN useradd -M -d /opt/app -s /bin/false nginx

RUN mkdir -p /run/php-fpm && \
    chown nginx:nginx /run/php-fpm

RUN mkdir -p /var/lib/php/session && \
    chown nginx:nginx /var/lib/php/session

COPY ./.docker/php-fpm/php-fpm.conf /etc/php-fpm.conf
COPY ./.docker/php-fpm/www.conf /etc/php-fpm.d/www.conf
COPY ./.docker/php-fpm/php.ini /etc/php.ini

RUN yum clean all

CMD php-fpm
