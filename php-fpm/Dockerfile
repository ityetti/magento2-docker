FROM centos:latest

RUN groupadd -g 2000 magento \
    && useradd -d /home/magento -u 2000 -g 2000 magento

RUN yum clean all \
    && yum -y install yum-utils \
    && yum makecache \
    && yum -y install epel-release \
    && rpm -ihv https://mirror.webtatic.com/yum/el7/webtatic-release.rpm \
    && yum -y update \
    && yum -y install epel-release

RUN yum -y install php72w php72w-{dba,bcmath,cli,common,devel,fpm,gd,interbase,intl,mbstring,mcrypt,mysqlnd,opcache,pear,pdo,process,soap,tidy,xml,zip,xsl,} php72w-pecl-{mongodb,redis}

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
    bash-completion

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=bin && mv /usr/bin/composer.phar /usr/bin/composer && chmod +x /usr/bin/composer

# Install Node, NVM, NPM and Grunt
RUN yum install -y gcc-c++ make \
    && curl -sL https://rpm.nodesource.com/setup_12.x | bash - \
    && yum install -y nodejs \
    && npm install -y -g grunt

# Install Code Sniffer
RUN git clone https://github.com/magento/marketplace-eqp.git ~/.composer/vendor/magento/marketplace-eqp
RUN cd ~/.composer/vendor/magento/marketplace-eqp && composer install
RUN ln -s ~/.composer/vendor/magento/marketplace-eqp/vendor/bin/phpcs /usr/local/bin;

# Install XDebug
ENV XDEBUG_PORT 9000
ENV XDEBUG_IDKEY PHPSTORM
RUN yes | pecl install xdebug && \
    echo "zend_extension=$(find /usr/lib64/php/modules/ -name xdebug.so)" > /etc/php.d/xdebug.ini

# Add config
ADD www.conf /etc/php-fpm.d/www.conf

EXPOSE 9000

ENTRYPOINT ["/usr/sbin/php-fpm", "-F"]
