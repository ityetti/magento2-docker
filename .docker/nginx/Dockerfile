FROM centos:7

# Install Nginx

RUN yum update -y && \
    yum install -y epel-release

RUN yum install -y nginx

COPY ./.docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./.docker/nginx/app.conf /etc/nginx/conf.d/app.conf

RUN yum clean all

CMD nginx