![Magento 2](https://cdn.rawgit.com/rafaelstz/magento2-snippets-visualstudio/master/images/icon.png)

#  Magento 2 Docker to Development

### CentOS 7 + Nginx (1.8) + Redis (6.2) + PHP-FPM (8.1) + MySQL (8.0.27) + XDebug (3.1.4) + Node (12.x) + Grunt + Mailhog + RabbitMQ (3.9) + Elasticsearch (7.16.3)

The docker stack is composed of the following containers
- redis
- rabbitmq
- elasticsearch
- mailhog
- php-fpm
- nginx
- mysql

### Container nginx
Builds from the nginx folder. <br>
Mounts the folder magento2 from the project main folder into the container volume `/home/magento`.<br>
Opens local port: `8000`

### Container php-fpm
Builds from the php-fpm folder.<br>
Mounts the folder magento2 from the project main folder into the container volume `/home/magento`.<br>
This container includes all dependencies for magento 2 (Also contain composer, node, grunt, code sniffer, xDebug etc.).<br>

### Container redis:
Starts a redis container.<br>
Opens up port: `6379`

### Container mysql:
Please change or set the mysql environment variables
    
    MYSQL_DATABASE: 'xxxx'
    MYSQL_ROOT_PASSWORD: 'xxxx'
    MYSQL_USER: 'xxxx'
    MYSQL_PASSWORD: 'xxxx'
    MYSQL_ALLOW_EMPTY_PASSWORD: 'xxxxx'

Default values:

    MYSQL_DATABASE: 'magento_db'
    MYSQL_ROOT_PASSWORD: 'root_pass'
    MYSQL_USER: 'magento_user'
    MYSQL_PASSWORD: 'PASSWD#'
    MYSQL_ALLOW_EMPTY_PASSWORD: 'false'

Opens up port: `3306`

Note: On your host, port 3306 might already be in use. So before running docker-compose.yml, under the docker-compose.yml's mysql section change the host's port number to something other than 3306, select any as long as that port is not already being used locally on your machine.

### Container mailhog:
Starts a mailhog container.<br>
Opens up port: `1025` and `8025`

### Container rabbitmq:
Starts a rabbitmq container.<br>
Opens up port: `5672` and `15672`

### Container elasticsearch:
Starts a elasticsearch container.<br>
Opens up port: `9200` and `9300`

## Setup
To start/build the stack.

Use - `docker-compose up` or `docker-compose up -d` to run the container on detached mode. 

Compose will take some time to execute.

After the build has finished you can press the ctrl+c and docker-compose stop all containers.

## Installing Magento

You will need to download the latest version of Magento from link: https://magento.com/tech-resources/download

Make sure you put the install under the `magento2` folder. 

To access your web server's command line, run the following commands on your CLI.

    docker exec -it <web-servers-container-name> bash

## Setting up Magento

To access the magento homepage, go to the following url: http://localhost:8000 or http://ip_of_the_docker_server:8000

## Feature Updates
- v1.0.0 - Stable release
- v1.0.1 - Updated to PHP 7.4.x, added docker-sync for MacOS users
- v1.0.2 - Fix xDebug, add rabbitmq management, fix email sending

## Branches
- master (for magento 2.3.7 and higher)
- php72 (for magento 2.3.0 and higher)
- php81 (for magento 2.4.4 and higher)