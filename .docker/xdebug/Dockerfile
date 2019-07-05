FROM centos:7

ENV XDEBUG_PORT 9000

# Install XDebug
RUN yes | pecl install xdebug && \
    echo "zend_extension=$(find /usr/lib64/php/modules/ -name xdebug.so)" > /etc/php.d/xdebug.iniOLD