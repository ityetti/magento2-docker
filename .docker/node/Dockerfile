FROM centos:7

# Install Node, NVM, NPM and Grunt
RUN yum install -y gcc-c++ make \
    && curl -sL https://rpm.nodesource.com/setup_12.x | bash - \
    && yum install -y nodejs \
    && npm install -y -g grunt