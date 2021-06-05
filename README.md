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
