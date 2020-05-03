#!/bin/bash

# Composer Install
composer install

# Cache Clear Dev and Prod
./bin/console cache:clear;
./bin/console cache:clear --env=prod

# Database Creation
bin/console doctrine:database:create

# Doctrine Schema Update
./bin/console doctrine:schema:update --dump-sql --force

# Doctrine Cache Clear Result
./bin/console doctrine:cache:clear-result

# PHP Unit Test Running
composer require --dev symfony/phpunit-bridge && ./bin/phpunit