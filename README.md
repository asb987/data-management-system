### Data management system

## Command to run the server
- Composer:
    compose update

- Run server:
    php artisan serve

- Migrate Table:
    php artisan migrate

- Remigrate database:
    php artisan migrate:refresh

- Fack data creation:
    php artisan db:seed

## Project Roles and Responsibility
- Roles:
    Super admin: Have all the right.
    Admin user: Only can create/update/delete user's.
    Sales user: Sales user can create/update/delete Category and Product.

- Super admin login credientials:
    Username: superadmin@gmail.com
    Password: 12345678

- Admin user login credientials:
    Username: admin@gmail.com
    Password: 12345678

- Sales user login credientials:
    Username: sales@gmail.com
    Password: 12345678

## Mail server
- Details:
    SMTP Server Hostname : smtp.freesmtpservers.com
    Port : 25
    Auth : None
    Website: https://www.wpoven.com/tools/free-smtp-server-for-testing

## Database
- Database name: data_manager
- Database user name: user
- Database password: user