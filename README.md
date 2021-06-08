# laravel-backend app

## Description

```bash

    laravel 8 
    php 8 
    docker 
    sail

```
## Commnds

```bash

    alias sail='bash vendor/bin/sail'


     copy .env.dev .env
    # Use command to run docker sail
    APP_PORT=3001 vendor/bin/sail up
    
```
## Fix docker containers 

```bash

    # Use command to run docker sail
    APP_PORT=3001 vendor/bin/sail down -volumes
    vendor/bin/sail up -build
    
```

## add image storage 

```bash

    # Use command to run docker sail
    php artisan storage:link
    
```
## add image storage 

```bash
#use mariadb
DB_CONNECTION=mysql
DB_HOST=mariadb
    
```


## implement faster sail

```bash
run docker and move repo code of laravel to linux engine like below
\\wsl$\Ubuntu-20.04\home\{user}\laravelfolder
```


## fix laravel storage 

sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache

chmod -R 775 storage
chmod -R 775 bootstrap/cache

sudo chmod -R 777 storage :

http://35.223.238.193:3001/storage/upload_ckeditor/nuxt_1623175284.jpg


php artisan storage:link 
