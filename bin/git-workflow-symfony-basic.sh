#!/bin/bash

# Composer Install
composer install

# Cache Clear Dev and Prod
./bin/console cache:clear;
./bin/console cache:clear --env=prod

sleep 30;

cat .env.local

# Database Creation
bin/console doctrine:database:create

# Doctrine Schema Update
./bin/console doctrine:schema:update --dump-sql --force

# Doctrine Cache Clear Result
./bin/console doctrine:cache:clear-result

echo "KERNEL_CLASS='App\Kernel'
APP_SECRET='$ecretf0rt3st'
SYMFONY_DEPRECATIONS_HELPER=999999
PANTHER_APP_ENV=panther
DATABASE_URL=mysql://root:root123@mysql_docker/auth?serverVersion=5.7 " > .env.test


cat .env.test

# PHP Unit Test Running
composer require --dev symfony/phpunit-bridge && ./bin/phpunit