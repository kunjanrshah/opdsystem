#!/bin/bash

# Deployment Script

apt update

apt install curl php-cli php-mbstring git unzip

curl -sS https://getcomposer.org/installer | php 

sudo mv composer.phar /usr/local/bin/composer 

chmod +x /usr/local/bin/composer

composer install

PROD_FILE=production
if [ -f "$PROD_FILE" ]; then
    BRANCH="master"
fi

DEV_FILE=development
if [ -f "$DEV_FILE" ]; then
    BRANCH="develop"
fi

DEV_FILE=qa
if [ -f "$DEV_FILE" ]; then
    BRANCH="develop"
fi

if [ -n "$BRANCH" ]; then
    git fetch
    git pull origin $BRANCH
    RUNTIME_FOLDER=/protected/runtime
    if [ -d "$RUNTIME_FOLDER" ]; then
        mkdir "$RUNTIME_FOLDER"
        chmod -R 777 "$RUNTIME_FOLDER"
    fi
    ASSETS_FOLDER=/protected/assets
    if [ -d "$ASSETS_FOLDER" ]; then
        mkdir "$ASSETS_FOLDER"
        chmod -R 777 "$ASSETS_FOLDER"
    fi
else
  echo "No enviroment specified."
fi
