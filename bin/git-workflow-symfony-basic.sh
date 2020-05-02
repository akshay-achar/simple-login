#!/bin/bash

composer install

./bin/console cache:clear;
./bin/console cache:clear --env=prod

bin/console doctrine:database:create

./bin/console doctrine:schema:update --dump-sql --force

./bin/console doctrine:cache:clear-result