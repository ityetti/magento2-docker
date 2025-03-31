FROM arm64v8/nginx:1.26

RUN groupadd -g 2000 magento \
    && useradd -d /home/magento -u 2000 -g 2000 magento

COPY ./default.conf /etc/nginx/conf.d/default.conf