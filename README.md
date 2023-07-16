# Pha Manager App

A simple web application to manage stocks and hotel.

## Prerequisites

To run this project, you need php 8.1 or latest and MySQL >= 5.7 or MariaDB >= 10.4 .

## Installation

1. Install the database

Database schema is located in `config/schema/db-script.sql`. Create a database in DBMS (Database Management System) and use it to import this schema.

## Configurations 

Configurations are available in `config` directory. 

1. Edit `config/app.php` to configure datasource and sessions.
2. Set path `BASE_URL` in file `config/paths.php` to set the base URL
```php
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost:80/');
}
```

## Run

From the command line, run following command in the root directory
```bash
php -S localhost:80
```
Then navigate to `localhost:80` in your browser.

## Example

- Create database and import schema:
```bash
mysql > create database premium_hotel;
mysql > source config/schema/premium_hotel.sql;
```
- Edit datasource config in file `config/app.php`:
```php
'DataSource' => [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'premium_hotel',
],
```
- Set the base url in file `config/paths.php`:
```php
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost:80/');
}
```
- Start the server:

```bash
php -S localhost:80
```
- Open your browser and type `localhost:80` in the url bar.