#!/bin/bash

PM="unknown"
INSTALL_DIR="/srv/gitpf"

if [ -x "$(command -v apt)" ]; then
  PM="apt"
fi

if [ -x "$(command -v yum)" ]; then
  PM="yum"
fi

echo "$PM package manager detected"

if [ $PM = "unknown" ]; then
  echo "Unknown package manager. Exiting..."
  exit 1
fi

if [ $PM = "yum" ]; then
	yum check-update
else
	apt update
fi

$PM install -y unzip wget git curl

mkdir -p $INSTALL_DIR
cd $INSTALL_DIR

wget "https://gitpf.poravinternet.ru/static/packages/gitpf-$1.zip"
unzip ./gitpf-*.zip

rm -rf ./gitpf-*.zip

MEMORY=$(free -m |  grep -o [0-9]*)

MEMORY=(${MEMORY[@]})
echo "You have ${MEMORY[0]}mb RAM"
MEMORY_MB="${MEMORY[0]}"

if [ $MEMORY_MB -lt 1024 ]; then
  echo "You have less than 1024Mb RAM. Create SWAP file? (yes/no)"
  read SWAP
  if [ $SWAP = "yes" ]; then
  	set -e
  	echo "Creating swap file" 
    fallocate -l 1G /swapfile
    chmod 600 /swapfile
    mkswap /swapfile
    swapon /swapfile
    echo "/swapfile swap swap defaults 0 0" >> /etc/fstab
    set +e
    echo "Swap file created and activated successfully"    
  fi
fi

echo "Do you want to use docker? (yes/no)"
read DOCKER

if [ $DOCKER = "yes" ]; then
	echo "Using docker"
	if [ $PM = "yum" ]; then
		echo "Installing docker for CentOS"
		yum install -y yum-utils

		yum-config-manager \
		    --add-repo \
		    https://download.docker.com/linux/centos/docker-ce.repo

		yum install docker-ce docker-ce-cli containerd.io

		systemctl start docker
		
	fi
	if [ $PM = "apt" ]; then
		source /etc/os-release
		if [ $ID = "ubuntu" ]; then
			echo "Installing docker for ubuntu"
			apt-get update
			apt-get install -y \
			    apt-transport-https \
			    ca-certificates \
			    curl \
			    gnupg-agent \
			    software-properties-common
			curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -

			add-apt-repository \
			   "deb [arch=amd64] https://download.docker.com/linux/ubuntu \
			   $(lsb_release -cs) \
			   stable"

			   apt-get update
			   apt-get install -y docker-ce docker-ce-cli containerd.io

			   systemctl start docker
		else
			echo "Installing docker for debian"
			apt-get update
			apt-get install -y \
			    apt-transport-https \
			    ca-certificates \
			    curl \
			    gnupg-agent \
			    software-properties-common

			curl -fsSL https://download.docker.com/linux/debian/gpg | sudo apt-key add -

			add-apt-repository \
			   "deb [arch=amd64] https://download.docker.com/linux/debian \
			   $(lsb_release -cs) \
			   stable"

			apt-get update
 			apt-get install -y docker-ce docker-ce-cli containerd.io

 			systemctl start docker
		fi
	fi
	echo "Launching application..."
	echo "Enter new database name: "
	read DBNAME

	if ! [ -n $DBNAME ]; then
		echo "Will use gitpf as DBNAME"
		DBNAME="gitpf"
	fi

	echo "Enter new mysql root password: "
	read DBPASS

	if ! [ -n $DBNAME ]; then
		echo "Will use gitpf as DBPASS"
		DBPASS="gitpf"
	fi

	echo "===================="
	echo "MYSQL settings:"
	echo "server: db"
	echo "database: $DBNAME"
	echo "username: root"
	echo "password: $DBPASS"
	echo "===================="

	echo "MYSQL_DATABASE=$DBNAME" > .env
	echo "MYSQL_ROOT_PASSWORD=$DBPASS" >> .env
	bash ./docker.sh
	exit 0

fi
# echo "Not implemented yet. Please use docker";
# exit 1;

echo "Using nginx - php-fpm installation"

if [ $PM = "yum" ]; then

	echo "Not supported on CentOS yet!"
	exit 1
fi

apt install -y nginx php-fpm php-mysql php-pdo php-mbstring php-dom php-gd php-curl php-imagick php-intl php-xdebug php-zip

rm /etc/nginx/sites-enabled/default 

echo "Enter domain or ip: "
read DOMAIN

ESCAPED_DOMAIN=$(printf '%s\n' "$DOMAIN" | sed -e 's/[]\/$*.^[]/\\&/g');
cp ./configs/server/nginx.conf.sample /etc/nginx/conf.d/gitpf.conf

sed -i "s/gitpf\.poravinternet\.ru/$ESCAPED_DOMAIN/g" /etc/nginx/conf.d/gitpf.conf


systemctl enable nginx
systemctl start nginx

systemctl enable nginx

systemctl start $(basename /lib/systemd/system/php7.*-fpm.service)
systemctl enable $(basename /lib/systemd/system/php7.*-fpm.service)

SOCKET="unix:$(ls /run/php/php7.*-fpm.sock)"

ESCAPED_SOCKET=$(printf '%s\n' "$SOCKET" | sed -e 's/[]\/$*.^[]/\\&/g');

sed -i "s/127\.0\.0\.1/$ESCAPED_SOCKET/g" /etc/nginx/conf.d/gitpf.conf

systemctl restart nginx

apt install -y mariadb-server

echo "Enter new database name: "
read DBNAME

if ! [ -n $DBNAME ]; then
	echo "Will use gitpf as DBNAME"
	DBNAME="gitpf"
fi

echo "Enter new mysql password: "
read DBPASS

if ! [ -n $DBNAME ]; then
	echo "Will use gitpf as DBPASS"
	DBPASS="gitpf"
fi
echo "===================="
echo "MYSQL settings:"
echo "server: localhost"
echo "database: $DBNAME"
echo "username: gitpf"
echo "password: $DBPASS"
echo "===================="

echo "CREATE USER gitpf@'%' identified by '$DBPASS';" | mysql
echo "CREATE DATABASE $DBNAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" | mysql
echo "GRANT ALL PRIVILEGES ON $DBNAME.* TO gitpf@'%';" | mysql
echo "FLUSH PRIVILEGES;" | mysql

chown -R www-data:www-data .

cp configs/systemd/gitpf_queue.service.example /lib/systemd/system/gitpf_queue@.service
systemctl daemon-reload
systemctl enable gitpf_queue@1 gitpf_queue@2
systemctl start gitpf_queue@1 gitpf_queue@2


crontab -l -u www-data > mycron
#echo new cron into cron file
echo "* * * * * php /srv/gitpf/yii schedule/run" >> mycron
#install new cron file
crontab -u www-data mycron
rm mycron

echo "Done. Proceed to http://$DOMAIN/setup"
