#login as root 

sudo -i 
passwd

# install git 

https://www.digitalocean.com/community/tutorials/how-to-install-git-on-ubuntu-18-04-quickstart

sudo apt update
sudo apt install git
git --version

# install node.js
https://www.digitalocean.com/community/tutorials/how-to-install-node-js-on-ubuntu-18-04


sudo apt update
sudo apt install nodejs
sudo apt install npm

nodejs -v

cd ~
curl -sL https://deb.nodesource.com/setup_10.x -o nodesource_setup.sh

nano nodesource_setup.sh

sudo bash nodesource_setup.sh

sudo apt install nodejs

sudo apt install build-essential

# install nvm 

curl -sL https://raw.githubusercontent.com/creationix/nvm/v0.35.3/install.sh -o install_nvm.sh

nano install_nvm.sh

bash install_nvm.sh
source ~/.profile
nvm ls-remote

note: nvm install 12.18.3 choose version
nvm install v16.3.0
npm install -g npm@7.16.0

cd var

mkdir www
cd www

git clone https://github.com/Jerick-CM/nuxt_projectwebsite.git frontend 

cp .env.example .env 

npm install

npm audit fix

npm run dev


# install docker


https://phoenixnap.com/kb/how-to-install-docker-on-ubuntu-18-04


sudo apt install git

sudo apt-get remove docker docker-engine docker.io

sudo apt install docker.io

sudo systemctl start docker

# install docker compose
https://phoenixnap.com/kb/install-docker-compose-ubuntu

sudo apt-get update

sudo apt-get upgrade

sudo apt install curl

sudo curl -L "https://github.com/docker/compose/releases/download/1.24.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose


apt-get install docker-compose


# set up root password 
sudo -i 
passwd

sudo usermod -aG docker ${USER}
su - ${USER}
id -nG

sudo usermod -aG docker username

sudo usermod -aG docker root

## install backend 

# install php

sudo apt update

sudo apt upgrade

sudo apt install  ca-certificates apt-transport-https software-properties-common

sudo add-apt-repository ppa:ondrej/php


sudo apt update

sudo apt install php8.0 

X sudo apt install php8.0 libapache2-mod-php8.0 


#stop apache 


sudo /etc/init.d/apache2 stop
sudo  /etc/init.d/apache2 start

#remove apache 

sudo apt-get purge libapache2-mod-php8.0
sudo apt-get autoremove
whereis apache2
sudo rm -rf /etc/apache2

# install composer
https://linuxize.com/post/how-to-install-and-use-composer-on-ubuntu-18-04/


sudo apt update

sudo apt install wget php-cli php-zip unzip

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

HASH="$(wget -q -O - https://composer.github.io/installer.sig)"

php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# install php cli

sudo apt update && sudo apt install wget php-cli php-zip unzip curl

curl -sS https://getcomposer.org/installer |php

# install backend git repo

git clone https://github.com/Jerick-CM/larevel8_sail_projectwebsite.git backend

cd backend

#add needed php extenstion 

sudo apt install openssl php-common php-curl php-json php-mbstring php-mysql php-xml php-zip


composer install 
composer update


composer install
# impement sail install


./vendor/bin/sail up 


./vendor/bin/sail up -d -build


#fix laravel storage
chmod -R 777 storage 
chmod -R 775 storage


# on login

 "message": "Session store not set on request.",
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan key:generate 

test@test.com
secret
