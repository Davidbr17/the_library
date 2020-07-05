<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

This is an application made in laravel with vuejs for the front end, everything works in a single page.
The functionalities are as follows:


- Show a paginated list/table with all the books
- Filter the list/table mentioned above
- Create a book
- Edit a book
- Delete a Book
- Be able to know if a user borrowed a book or if it is still available
- Be able to change the status from available to not available


## Instalation

-Install composer dependencies "composer install"

-Create application key "php artisan key:generate"

-Create a empty database and configure it in the .env.

-Make migrations "php artisan migrate".

-Eject starter seeder to have data for test. "php artisan db:seed"

-Install npm dependecies for vuejs. "npm install"

-Finally run "npm run dev"

