#!/bin/bash
sudo chown -R ec2-user:ec2-user /usr/share/nginx/html/game-server
sudo find /usr/share/nginx/html/game-server -type d -exec chmod 755 {} +
sudo find /usr/share/nginx/html/game-server -type f -exec chmod 644 {} +
sudo chmod -R 777 /usr/share/nginx/html/game-server/storage

sudo /usr/local/bin/composer self-update --1
composer install -d /usr/share/nginx/html/game-server --no-interaction --no-dev --optimize-autoloader
sudo /usr/local/bin/composer self-update --rollback