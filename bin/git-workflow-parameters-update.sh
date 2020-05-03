#!/bin/bash

sed -i 's/DATABASE_URL=mysql:\/\/db_user:db_password@127.0.0.1:3306\/db_name?serverVersion=5.7/DATABASE_URL=mysql:\/\/root:root123@mysql_docker\/auth?serverVersion=5.7/
' .env.local

