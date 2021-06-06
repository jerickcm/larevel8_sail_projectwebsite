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


git pull gitrepo frontend


# install docker


https://phoenixnap.com/kb/how-to-install-docker-on-ubuntu-18-04


sudo apt-get update
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
