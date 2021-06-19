
mkdir /var/www/nuxt

mkdir /var/www/laravel

sudo nano /etc/nginx/sites-available/default

laravel

nano /etc/nginx/sites-available/laravel.conf 

server{
    listen 80;
    listen [::]:80;
    root /var/www/backend/public;
    index index.php;
    server_name  backend.inhinyeru.com;
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

nginx -t

sudo ln -s /etc/nginx/sites-available/laravel.conf /etc/nginx/sites-enabled/laravel.conf

service nginx restart


https://gist.github.com/cecilemuller/a26737699a7e70a7093d4dc115915de8

now setup frontend


nuxt

nano /etc/nginx/sites-available/nuxt.conf 


server {
    listen 80;
    server_name  www.inhinyeru.com;
    location / {
        proxy_set_header   X-Forwarded-For $remote_addr;
        proxy_set_header   Host $http_host;
        proxy_pass         http://localhost:3000;
    }
}

sudo ln -s /etc/nginx/sites-available/nuxt.conf /etc/nginx/sites-enabled/nuxt.conf

service nginx restart


 nano  /etc/letsencrypt/live/www.inhinyeru.com/fullchain.pem; # managed by Certbot
 
    ssl_certificate_key /etc/letsencrypt/live/www.inhinyeru.com/privkey.pem; # managed by Certbot

 nano  /etc/letsencrypt/live/www.inhinyeru.com/fullchain.pem; # managed by Certbot
 
    ssl_certificate_key /etc/letsencrypt/live/www.inhinyeru.com/privkey.pem; # managed by Certbot

    #steps


sudo apt-get update
sudo apt-get install software-properties-common
sudo add-apt-repository universe
sudo add-apt-repository ppa:certbot/certbot
sudo apt-get update
sudo apt-get install certbot python-certbot-nginx

sudo certbot --nginx

