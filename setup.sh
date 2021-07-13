#!/bin/bash
set -e

#composer global require "fxp/composer-asset-plugin:^1.2.0"
#composer install --prefer-dist

#php init

bash ./migrations.sh

php yii user/create admin@a.b admin password
php yii user/role/assign admin admin@a.b

echo "Создан пользователь:"
echo "Username: admin"
echo "Email: admin@a.b"
echo "Password: password"