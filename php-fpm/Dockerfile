FROM centos:7

RUN groupadd -g 2000 magento \
    && useradd -d /home/magento -u 2000 -g 2000 magento

RUN yum clean all \
    && yum -y install yum-utils \
    && yum makecache \
    && yum -y install epel-release \
    && rpm -ihv https://mirror.webtatic.com/yum/el7/webtatic-release.rpm \
    && yum -y update \
    && yum -y install epel-release

RUN yum -y install https://rpms.remirepo.net/enterprise/remi-release-7.rpm
RUN yum -y install yum-utils
RUN yum-config-manager --disable 'remi-php*'
RUN yum-config-manager --enable remi-php74
RUN yum repolist
RUN yum -y install php php-{zip,cli,fpm,mysqlnd,xml,pear,opcache,redis,memcache,dba,common,mcrypt,pdo,process,tidy,bcmath,ctype,curl,dom,fileinfo,gd,hash,iconv,intl,json,libxml,mbstring,openssl,pcre,pdo_mysql,simplexml,soap,sockets,sodium,xmlwriter,xsl,devel}
RUN yum -y install wget
RUN wget http://pear.php.net/go-pear.phar
RUN php go-pear.phar

# Install Magento Dependencies
RUN yum install -y \
    curl \
    git \
    gnupg \
    vim \
    wget \
    lynx \
    psmisc \
    unzip \
    tar \
    bash-completion \
    lib-libxml \
    lib-openssl

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=bin && mv /usr/bin/composer.phar /usr/bin/composer && chmod +x /usr/bin/composer

# Install Node, NVM, NPM and Grunt
RUN yum install -y gcc-c++ make \
    && curl -sL https://rpm.nodesource.com/setup_12.x | bash - \
    && yum install -y nodejs \
    && npm install -y -g grunt

# Required for xDebug compilation
RUN yum -y install make

# Install xDebug
RUN pecl install xdebug-2.9.8

# Add xDebug to PHP configuration
ENV XDEBUG_PORT 9000
ENV XDEBUG_IDKEY PHPSTORM
RUN echo "" > /etc/php.d/xdebug.ini \
 && echo "[xdebug]" > /etc/php.d/xdebug.ini \
 && echo "zend_extension = /usr/lib64/php/modules/xdebug.so" > /etc/php.d/xdebug.ini \
 && echo "xdebug.remote_enable = 1" >> /etc/php.d/xdebug.ini \
 && echo "xdebug.remote_autostart = 1" >> /etc/php.d/xdebug.ini \
 && echo "xdebug.remote_host = host.docker.internal" >> /etc/php.d/xdebug.ini

# Add zip to PHP
RUN yum -y install php-pecl-zip

# Add mailhog configuration for PHP
RUN rm -rf /var/lib/apt/lists/*
RUN curl -Lsf 'https://storage.googleapis.com/golang/go1.8.3.linux-amd64.tar.gz' | tar -C '/usr/local' -xvzf -
ENV PATH /usr/local/go/bin:$PATH
RUN go get github.com/mailhog/mhsendmail
RUN cp /root/go/bin/mhsendmail /usr/bin/mhsendmail

# Add config
RUN mkdir -p /var/run/php-fpm
ADD www.conf /etc/php-fpm.d/www.conf

EXPOSE 9000
EXPOSE 15672

ENTRYPOINT ["/usr/sbin/php-fpm", "-F"]
