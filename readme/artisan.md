php sail artisan make:migration create_AdminUserLogs_table --create="AdminUserLogs"
php sail migrate
php sail artisan migrate:rollback --step=1
