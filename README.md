![Magento 2](https://cdn.rawgit.com/rafaelstz/magento2-snippets-visualstudio/master/images/icon.png)

#  Magento 2 Docker to Development (For Apple Silicon)

### Nginx (1.8) + Redis (6.2) + PHP-FPM (8.1) + MySQL (8.0.27) + XDebug (3.1.5) + Mailhog + RabbitMQ (3.9) + Elasticsearch (7.16.3)

The docker stack is composed of the following containers
- redis
- rabbitmq
- elasticsearch
- mailhog
- php-fpm
- nginx
- mysql
- nginx-proxy

### Container nginx
Builds from the nginx folder. <br>
Mounts the folder magento2 from the project main folder into the container volume `/home/magento`.<br>

### Container nginx-proxy
Starts a nginx-proxy container for use VIRTUAL_HOST.<br>
Opens local port: `80`

### Container php-fpm
Builds from the php-fpm folder.<br>
Mounts the folder magento2 from the project main folder into the container volume `/home/magento`.<br>
This container includes all dependencies for magento 2 (Also contain composer, code sniffer, xDebug etc.).<br>

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
Edit your `.env` file in root folder, change `PROJECT_NAME` and `PROJECT_VIRTUAL_HOST`:<br>
`PROJECT_NAME` - help you to create simple and clear container names.<br>
`PROJECT_VIRTUAL_HOST` - it is your main url address.<br>
For example:

    PROJECT_NAME=magento2
    PROJECT_VIRTUAL_HOST=magento2.test

Edit your `/etc/hosts` and add next line:<br>
`127.0.0.1 magento2.test mail.magento2.test elastic.magento2.test rabbit.magento2.test`<br>

To start/build the stack.<br>
Use - `docker-compose up` or `docker-compose up -d` to run the container on detached mode.<br>
Compose will take some time to execute.<br>
After the build has finished you can press the ctrl+c and docker-compose stop all containers.

## Installing Magento
You will check the latest version of Magento from link: https://magento.com/tech-resources/download <br>
To the run installation process use next commands.<br>
Create new project:

    ./scripts/composer create-project --repository-url=https://repo.magento.com/ magento/project-community-edition=2.4.4 /home/magento
Install project:

    ./scripts/magento setup:install --base-url=http://magento2.test/ --db-host=mysql --db-name=magento_db --db-user=magento_user --db-password="PASSWD#" --admin-firstname=admin --admin-lastname=admin --admin-email=admin@admin.test --admin-user=admin --admin-password=admin1! --language=en_US --currency=USD --timezone=America/Chicago --use-rewrites=1 --elasticsearch-host=elasticsearch --elasticsearch-port=9200

## Setting up Magento
To access the magento homepage, go to the following url: http://magento2.test<br>

Also, you can open:<br>
http://mail.magento2.test - **Mailhog**<br>
http://elastic.magento2.test - **Elasicsearch**<br>
http://rabbit.magento2.test - **RabbitMQ** (guest/guest for aceess)<br>

## Feature Updates
- v1.0.0 - Stable release
- v1.0.1 - Updated to PHP 7.4.x, added docker-sync for MacOS users
- v1.0.2 - Fix xDebug, add rabbitmq management, fix email sending
- v1.0.3 - Updated to PHP 8.1.x
- v1.0.4 - Fix xDebug for stable work

## Branches
- master (for magento 2.4.4 and higher)