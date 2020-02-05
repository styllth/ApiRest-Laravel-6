# ApiRest-Laravel-6

Base for API REST Laravel 6 with Passport

## Install

    $ composer install
    $ cp .env.example .env
    $ php artisan key:generate
    $ php artisan migrate
    $ php artisan passport:install

## Basic Routes

    Verb    ||      URI     ||  Action
    GET 	||/users        || 	index
    POST 	||/users        || 	store
    GET 	||/users/{id}   ||  show

PUT/PATCH ||/users/{id} || update
DELETE ||/users/{id} || destroy
