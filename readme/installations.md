apt-cache search libgd
sudo apt-get update
sudo apt-get install php8.0-gd

composer require phpoffice/phpspreadsheet

composer require maatwebsite/excel


php artisan make:export UsersExport --model=User

##

php artisan event:generate

php artisan make:event UserLogsEvent
php artisan make:listener UserLogsListener --event=UserLogsEvent

php sail artisan make:model AdminUsersLogs
