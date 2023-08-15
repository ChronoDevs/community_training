# Environment construction using laradock
## URL configuration
||localhost→docker IP etc.|
|---|---|
|WEB| http://localhost/ or https://localhost/|
|PHPMyadmin| http://localhost:8081/index.php|
|Maildev| http://localhost:1080/|
|DB| Database→community_training_db<br>default/secret|

## file organization
```
/Works
├── laradock -- (docker files)
└── community_training -- (Work folder laravel is also placed here)
```

## Construction procedure
Documentation here → [laradock.io](http://laradock.io/)

create working directory + clone laradock

```bash
cd /Works
mkdir community_training

git clone https://github.com/Laradock/laradock.git
cd laradock
```

Create environment file for Laradock

```bash
cp env-example .env
```

.env

```diff
- APP_CODE_PATH_HOST=../
+ APP_CODE_PATH_HOST=../community_training

- PHP_FPM_INSTALL_EXIF=false
+ PHP_FPM_INSTALL_EXIF=true

- APACHE_DOCUMENT_ROOT=/var/www/
+ APACHE_DOCUMENT_ROOT=/var/www/public

- MYSQL_VERSION=latest
+ MYSQL_VERSION=5.7
```

Add MySQL settings as follows
mysql/my.cnf
```diff
[mysqld]

+ ngram_token_size=1
+ innodb_ft_enable_stopword = OFF
```

Also add the following to create a test DB
mysql/docker-entrypoint-initdb.d/createdb.sql

```SQL
CREATE DATABASE IF NOT EXISTS `community_training_testing` COLLATE 'utf8_general_ci';

GRANT ALL ON `community_training_testing`.* TO 'default'@'%';
FLUSH PRIVILEGES;
```

---
Start Docker and install laravel

```bash
#Please note that the following command is very long for the first time. It can take up to an hour.
docker-compose up -d apache2 mysql phpmyadmin maildev workspace

#Connect to the started docker
docker-compose exec workspace bash
chmod -R 777 storage/
composer update
```

Laravel's environment file copies .env.example as .env and changes it as
follows.env

```bash
APP_URL=http://localhost

DB_HOST=mysql
DB_DATABASE=default
DB_USERNAME=default
DB_PASSWORD=secret
```
