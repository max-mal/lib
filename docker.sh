#!/bin/bash
#
set -e

if ! [ -x "$(command -v git)" ]; then
  echo 'Error: git is not installed.' >&2
  exit 1
fi

if ! [ -x "$(command -v docker)" ]; then
  echo 'Error: docker is not installed.' >&2
  echo "Trying to install"
  curl -fsSL https://get.docker.com -o get-docker.sh 
  sudo sh get-docker.sh 
  rm -rf get-docker.sh
fi

if ! [ -x "$(command -v docker-compose)" ]; then
  echo 'Error: docker-compose is not installed.' >&2
  echo "Trying to install"
  sudo curl -L "https://github.com/docker/compose/releases/download/1.26.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose 
  sudo chmod +x /usr/local/bin/docker-compose
  
fi

git reset --hard
docker login -u "gitlab+deploy-token-15" -p "eickgrdaxyaGNAshjs5Q" gitlab.poravinternet.ru:4567
docker-compose up -d

#fix permissions
docker exec -it -u root app bash -c "chown -R www:www /var/www"