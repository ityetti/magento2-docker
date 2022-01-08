FROM nginx:1.8

RUN groupadd -g 2000 magento \
    && useradd -d /home/magento -u 2000 -g 2000 magento

COPY ./nginx.conf /etc/nginx/nginx.conf
COPY ./default.conf /etc/nginx/conf.d/default.conf