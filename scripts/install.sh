#!/usr/bin/env bash

set -eu

url="local.kado.com"

echo "Creating application configuration..."

# check if previous .env file already exists, delete if so
if [[ -f ".env" ]]; then
    rm -f ".env"
fi

if [[ -f ".env.local" ]]; then
    cp ".env.local" ".env"
else
    echo "Local application configuration file (.env.local) missing. Please create it before running this script again!"
    exit 1
fi

echo "===> Finished: creating application configuration"

# Firing up Docker containers
echo "===> Starting up Docker containers"
docker-compose up -d
echo "===> Docker containers started"

# Running Provisioning script
echo "===> Running provisioning script"
sh ./scripts/provision.sh
echo "===> Provisioning finished"

# Setting Hosts
if grep -q "${url}" /etc/hosts; then
    echo "===> ${url} already set in hosts file. Skipping..."
else
    echo "===> Add domain to hosts file"
    sudo -- sh -c "echo '127.0.0.1 ${url}' >> /etc/hosts"
fi

# Open Site in browser
open https://"${url}"/admin/login

echo "===> Local installation successfully finished!"
