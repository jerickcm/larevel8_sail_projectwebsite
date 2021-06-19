https://levelup.gitconnected.com/setup-a-vm-for-laravel-8-with-ubuntu-20-04-php8-nginx-and-mysql-4b709de88154

# install php 8
https://www.tecmint.com/install-php-8-on-ubuntu/

sudo apt update

sudo apt upgrade

sudo apt install  ca-certificates apt-transport-https software-properties-common

sudo add-apt-repository ppa:ondrej/php

# install php fpm

sudo apt install php8.0-fpm

sudo systemctl status php8.0-fpm

sudo apt install php8.0-snmp php-memcached php8.0-mysql

# install nginx 

sudo apt install nginx

sudo systemctl restart nginx

# install git 

sudo apt install git

git --version


# add backend 

cd /var/www

git clone https://github.com/Jerick-CM/larevel8_sail_projectwebsite.git backend

# create .env file

cd backend 

cp .env.dev .env

# install composer 

sudo apt install wget php-cli php-zip unzip

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

HASH="$(wget -q -O - https://composer.github.io/installer.sig)"

php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# add composer php  dependencies 

sudo apt install openssl php-common php-curl php-json php-mbstring php-mysql php-xml php-zip

composer install 

composer update


# 

mkdir -p /var/www



# php dependencies

apt-get install php8.0-mysql php8.0-mbstring php8.0-xml php8.0-bcmath


# create user

adduser deploy

usermod -aG www-data deploy

chown -R deploy:www-data /var/www/

# create default backeup

cp /etc/nginx/sites-available/default /etc/nginx/sites-available/backup

cp /var/www/html/index.nginx-debian.html /var/www/index.html

sudo nano /etc/nginx/sites-available/default

# redirect to laravel edit default

add

server {

    listen 3001;
    listen [::]:3001;
    root /var/www/backend/public;        
    index index.php;        
    server_name locahost;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }

}

server {
    listen 80;
    ....
}

#test code

nginx -t

service nginx restart


sudo ufw allow 3001

sudo ufw enable


#check browser for 3001 port 

# laravel error fix in storage 

cd /var/www/backend 

chmod -R 775 storage


# install mysql

sudo apt install mysql-server

sudo mysql_secure_installation

sudo mysql

CREATE USER 'username'@'%' IDENTIFIED BY 'password';

GRANT ALL PRIVILEGES ON *.* TO 'username'@'localhost' WITH GRANT OPTION;

sudo ufw allow 3306

sudo ufw enable

sudo mysql -u root -p

GRANT ALL PRIVILEGES ON *.* TO 'user_name'@'localhost' WITH GRANT OPTION;

# add frontend 

cd ~

cd /var/www 

git clone https://github.com/Jerick-CM/nuxt_projectwebsite.git frontend

cd frontend 

cp .env.example .env

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


nvm install v14.17.0
npm install -g npm@6.14.13


#install pm2 
npm install pm2@latest -g


object(Laravel\Socialite\Two\User)#569 (10) { ["token"]=> string(170) "ya29.a0AfH6SMAMX9FRgfzP9fe_JRBnCzQfcSaGRDGMHS1gb8uaklAJLkPn6SYWtyZwF7Br4aylY94K5Gg213fOo8Fniu54yW79lgqsPN5Xt5y4JZH00ijhaBdctp6zlD90EOnTIU9UUXM3jg2vs-wX5a3CAnleIgphwwParDs" ["refreshToken"]=> NULL ["expiresIn"]=> int(3599) ["id"]=> string(21) "102461156521413676658" ["nickname"]=> NULL ["name"]=> NULL ["email"]=> string(19) "jmangaluz@gmail.com" ["avatar"]=> string(89) "https://lh3.googleusercontent.com/a-/AOh14GjXLXeSjQd5gUhng1EoiOFkkRqPFtNByh_lFsTPkg=s96-c" ["user"]=> array(7) { ["sub"]=> string(21) "102461156521413676658" ["picture"]=> string(89) "https://lh3.googleusercontent.com/a-/AOh14GjXLXeSjQd5gUhng1EoiOFkkRqPFtNByh_lFsTPkg=s96-c" ["email"]=> string(19) "jmangaluz@gmail.com" ["email_verified"]=> bool(true) ["id"]=> string(21) "102461156521413676658" ["verified_email"]=> bool(true) ["link"]=> NULL } ["avatar_original"]=> string(89) "https://lh3.googleusercontent.com/a-/AOh14GjXLXeSjQd5gUhng1EoiOFkkRqPFtNByh_lFsTPkg=s96-c" }


102461156521413676658

102461156521413676658
