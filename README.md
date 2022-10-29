<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Project setup

```
composer install
```

- Copy/rename `.env.example` file to `.env` on the root folder.

- Open your `.env` file and change the database name (DB_DATABASE) to `overtimekeldo`, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your MySQL configuration.

- run `php artisan key:generate` in CMD on the root folder of this project.

- run `php artisan migrate` in CMD on the root folder of this project.

- run `php artisan db:seed` in CMD on the root folder of this project.

```
php artisan serve
```

- Go to url [http://localhost:8000/](http://localhost:8000/) on the browser

## Swagger
- Go to url [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation) on the browser

There are list of APIs documentation, such as :
![Swagger project](https://user-images.githubusercontent.com/34403070/198817861-29be03c8-8c64-4eaa-9f17-746f99ba00eb.png)

And also included body or parameters request example 

## PHPUnit

Run the command below in CMD on the root folder of this project.
```
.\vendor\bin\phpunit
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
