# laravel-products

## Installation

All instructions below work for Ubuntu 24.04 on June 21st 2024. For installation on different platforms, use the corresponding package manager or look up installation instructions.

### Installing PHP

The programming language used. For this project, v8.3.6 was used.

```bash
sudo apt install php-cli php-cgi
sudo apt install php8.3-xml
```

### Installing a DBMS

Since this is a small project, SQLite will do as a database management system. Laravel [provides first-party support for SQLite](https://laravel.com/docs/11.x/database#Introduction). For this project, SQLite v3.45.3 was used.

```bash
sudo apt install sqlite3
```

Adding the SQLite extension to PHP:

```bash
sudo apt-get install php-sqlite3
```

### Installing Composer

A dependency manager for PHP. For this project, v2.7.7 was used.

Please find installation instructions [here](https://getcomposer.org/download/).

Composer can be used to install Laravel. For this project, Laravel v11.1.1 was used.

## Running

To start a local development server at the default port 8000, run:

```bash
php artisan serve
```
