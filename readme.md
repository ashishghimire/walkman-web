# Walkman-web

This repository is for the server sided  api and admin cms for our android appilcation - walkman.

Walkman is a distance tracker app, that tracks distance covered by its users during their cycling/hike and rewards the daily top contributors with exciting gift hampers.

## How to install
This project was written in laravel 5.4. To run this project on your server, you need to have following tools pre-installed:
- Composer
- MySql >=5.7
- PHP >= 5.6.4
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

##### After you clone this repository, do the following:
  - Firstly, you'll need to install the project dependencies. So, in the terminal, type
```sh
$ composer install
```
  - Create a database for the project in MySql. 
  - Create a **.env** file and copy all the contents of **.env.example** file to **.env**.
  - In the **.env** file add your values to DB_DATABASE, DB_USERNAME & DB_PASSWORD. If you are willing to use test the api, you'll need to set a value for APP_SECRET and use that value for the key app_secret in the header of your api call.
  - You'll need to generate application key so in the terminal, type:
```sh
$ php artisan key:generate
``` 
 - Now you'll need to migrate the tables to your database. **Remember, you'll need mysql >=5.7 to be able to do so.** In the terminal, type:
```sh
$ php artisan migrate
``` 
- The cms can only be accessed by either admin, or sponsors. Sponsors can only be created by admins. So, initially, you'll need to create admin account. For that, go to **.env** file and set your values for ADMIN_NAME, ADMIN_EMAIL and ADMIN_PASSWORD. Next, you'll need to seed your values. For that, go to the terminal and type:
```sh
$ php artisan db:seed
``` 
- If you have PHP installed locally and you would like to use PHP's built-in development server to serve your application, you may use the serve Artisan command. This command will start a development server at http://localhost:8000:
```sh
$ php artisan serve
``` 
- Now, login as admin using the email and password you provided in the .env file.
- If you want to use the api, request access to the api document at this url: https://docs.google.com/document/d/1-aJPhmCobAaapq3MlFLfKJxFoG343tUybJARGXwyGPE
