# Topupmama simple book API

[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

## Introduction

Topupmama simple book api is implemented using Laravel Lumen stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. 

## Official Documentation

Documentation for the API can be found on the [Topupmama API Documentation website](http://ec2-3-91-209-87.compute-1.amazonaws.com:8000/api/v1/documentation).

## License

The API is an open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Installation

### Server Requirements

If you are not using [Homestead](https://github.com/laravel/homestead), you will need to make sure your server meets the following requirements:

- PHP >= 8.0
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Install Mysql Server 5.7 and above Or Mariadb 10.3 and above

### Installing The API

- Download the [zip file](https://github.com/oduold/topupmama/archive/refs/heads/main.zip) or Clone this project. If you require more information on how you can do this, look into the following documentation on [Cloning a repository](https://docs.github.com/en/repositories/creating-and-managing-repositories/cloning-a-repository). If you prefer GUI based solution look into [Cloning and forking repositories from GitHub Desktop](https://docs.github.com/en/desktop/contributing-and-collaborating-using-github-desktop/adding-and-cloning-repositories/cloning-and-forking-repositories-from-github-desktop). I prefer the command line.

```
git clone git@github.com:oduold/topupmama.git
```

- The REST API is implemented using Laravel lumen. Lumen utilizes [Composer](https://getcomposer.org/) to manage its dependencies. So, before using the REST API, make sure you have [Composer](https://getcomposer.org/) installed on your machine. 

- Change directory to topupmama directory after cloning the project

```
cd topupmama
```

- Run composer update. Verify you have the system requirements mentioned above

```
composer update
```

- Access your mysql server and create a database from the commandline. Make sure your user has sufficient permissions to perform that action in 

```
mysql -uuser -p -e"CREATE DATABASE dbname"
```

- move  __.env.exmple__  file to __.env__


```
mv .env.example .env

```

- update that file and make changes to reflect your database credentials

```
...

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=topupmama
DB_USERNAME=user
DB_PASSWORD=password

...

```

- Intialize database tables creation using the following command


```
php artisan migrate:fresh
```

- output should be similar to

```bash
Dropped all tables successfully.
Migration table created successfully.
Migrating: 2022_03_20_091430_create_books_table
Migrated:  2022_03_20_091430_create_books_table (10.08ms)
Migrating: 2022_03_20_091753_create_comments_table
Migrated:  2022_03_20_091753_create_comments_table (38.79ms)
Migrating: 2022_03_20_144600_create_authors_table
Migrated:  2022_03_20_144600_create_authors_table (8.72ms)
Migrating: 2022_03_20_144743_create_author_book_table
Migrated:  2022_03_20_144743_create_author_book_table (78.02ms)
Migrating: 2022_03_20_161154_create_gender_table
Migrated:  2022_03_20_161154_create_gender_table (14.72ms)
Migrating: 2022_03_21_202934_create_characters_table
Migrated:  2022_03_21_202934_create_characters_table (66.48ms)

```

- You can populate the database with example data via the command

```
php artisan db:seed
```

- At this point you might need to update the  _server.url_  section of the YAML file ``public/swagger/swagger.yaml`` to reflect your localhost.


```
servers:
- url: http://localhost:<port>/
  description: localhost server
```

- Start the php development server 

```
php -S localhost:<port> -t public
```
- You can access the API documentation and try it out via ```http:///<your server ip>:<port>/api/v1/documentation```

### Known issues

The API is meant to show case a simple REST API implementation using Laravel/Lumen framework. It has limited functionality.

