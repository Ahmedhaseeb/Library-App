# Library App

# Admin Side Functionalities

    Add, View, Update, Delete Books
    Add, View, Update, Delete Authors
    Assign Authors To Book
    Issue Book To Student
    Report
    View All Books
    View Available Books
    View All Issued Books


# User Side Functionalities
  
    Can View List of All Books
    Can View Books That Issued to him


# How To Make It Work
 Clone the repo
 
# Setup Database

Open .env file put the database details.<br>
Default DB Configuration Details Are Below:

    * DB_CONNECTION=mysql
    * DB_HOST=127.0.0.1
    * DB_PORT=3306
    * DB_DATABASE=library_app
    * DB_USERNAME=root
    * DB_PASSWORD=

Create a blank Database With Any Name and Update the database variables in the .env file

# Server Requirenments
    * PHP >= 7.2.0 i recommend 7.4.1
    * BCMath PHP Extension
    * Ctype PHP Extension
    * JSON PHP Extension
    * Mbstring PHP Extension
    * OpenSSL PHP Extension
    * PDO PHP Extension
    * Tokenizer PHP Extension
    * XML PHP Extensio

# Run Artisan Commands

Clear The Cache

    php artisan cache:clear
    php artisan route:clear
    php artisan config:clear
    php artisan view:clear

Do the database migration

`php artisan make:migration`

Put the Dummy Data

`php artisan db:seed`


Make Sure Your Domain Directly Point the Public Directory Of App<br>
If domain is example.com then it must be executing code from the Library App `public` directory.

For installation at local server I recommend you to create a virtual host that points to `public` directory of app.

Thats It<br>
Thanks
