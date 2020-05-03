#!/bin/bash

# Composer Install
composer install

# Cache Clear Dev and Prod
./bin/console cache:clear;
./bin/console cache:clear --env=prod

cat .env.local

# Database Creation
bin/console doctrine:database:create

# Doctrine Schema Update
./bin/console doctrine:schema:update --dump-sql --force

# Doctrine Cache Clear Result
./bin/console doctrine:cache:clear-result

# PHP Unit Test Running
composer require --dev symfony/phpunit-bridge && sed -i 's/DATABASE_URL=mysql:\/\/db_user:db_password@127.0.0.1:3306\/db_name?serverVersion=5.7/DATABASE_URL=mysql:\/\/root:root123@mysql_docker\/auth?serverVersion=5.7/
' .env.test && cat .env.test && ./bin/phpunit