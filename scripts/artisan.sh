#!/usr/bin/env bash

set -eu

APP_DIR="/var/www/"

cd $APP_DIR && php artisan key:generate && php artisan config:clear
