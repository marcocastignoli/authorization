![Logo](https://pichoster.net/images/2017/03/27/6070dfe38b6b04afa0504b832eef6c96.th.png)

# authorization
[![Latest Stable Version](https://poser.pugx.org/marcocastignoli/authorization/version)](https://packagist.org/packages/marcocastignoli/authorization)
[![Total Downloads](https://poser.pugx.org/marcocastignoli/authorization/downloads)](https://packagist.org/packages/marcocastignoli/authorization)
[![Latest Unstable Version](https://poser.pugx.org/marcocastignoli/authorization/v/unstable)](//packagist.org/packages/marcocastignoli/authorization)
[![License](https://poser.pugx.org/marcocastignoli/authorization/license)](https://packagist.org/packages/marcocastignoli/authorization)

A package to manage authorization for Lumen

## Dependencies

* PHP >= 7.0
* Lumen >= 5.3

## Installation via Composer

First install Lumen if you don't have it yet:
```bash
$ composer create-project --prefer-dist laravel/lumen lumen-app
```

Then install Lumen Passport (it will fetch Laravel Passport along):

```bash
$ cd lumen-app
$ composer require marcocastignoli/authorization
```

Or if you prefer, edit `composer.json` manually:

```json
{
    "require": {
        "marcocastignoli/authorization": "dev-master"
    }
}
```

### Modify the bootstrap flow (```bootstrap/app.php``` file)

```php
// Enable Facades
$app->withFacades();

// Enable Eloquent
$app->withEloquent();

// Register the service provider
$app->register(marcocastignoli\authorization\AuthorizationProvider::class);
```

### Migrate and seed the database

```bash
# Create new tables
php artisan migrate

# Seed the database
php artisan db:seed --class=marcocastignoli\\authorization\\AuthorizationSeeder
```

## Authentication system
Implement an authentication system, I suggest you to use "passport", for Lumen you can check this: https://github.com/dusterio/lumen-passport/

## Documentation
This package provides a simple way to create permissions for your application.

### Writing permissions

In the _users_ table you have to assign to the user an _auth_ level.

In the _authorizations_ table you can create the permissions.
- **auth**: a permission is referred to the user's auth level.
- **object**: a permission is referred to a Lumen's model.
- **field**: a permission is referred to a field of the object.
- **method**: a permission is referred to the action of the request (get, put, post, del).
- **entity**: a permission is referred to the entity of the request. (For example in "show _all_ users" the entity is "_all_".)


#### Examples
For each sentence you can see its implementation in the authorizations table.

_The user with authorization 0 can see the id of everyone_

| auth | object | field                    | method  | entity |
|------|--------|--------------------------|---------|--------|
| 0    | User   | id	                   | show    | all    |

_The user with authorization 1 can see the email and the username of everyone_

| auth | object | field                    | method  | entity |
|------|--------|--------------------------|---------|--------|
| 1    | User   | email          		   | show    | all    |
| 1    | User   | username         		   | show    | all    |

_The user with authorization 2 can edit every field for his cars_

| auth | object | field                    | method  | entity |
|------|--------|--------------------------|---------|--------|
| 2    | Car    | *                        | post    | my     |

### Using permissions

#### Create a new _Model_
When you create a new model instead of extending _Model_, you have to extend _AuthorizationScopes_.

Inside every model you can user the following scopes to filter your queries.
- **show( $entity )**
- **post( $entity, $arguments )**
- **put( $entity, $arguments )**
- **del( $entity, $id )**

#### Examples
```PHP
// Get information about my user using the permission set in the authorizations table
App\User::show("my")->get();

// Edit all cars where id < 5
App\Cars::where("id", "<", 5)->post("*", [
    "color"=>"red"
]);
```
All the scopes also work with relations, in every _Model_ you have to create a public parameter called _own_. That is the field linked with the user's id.

## License

The MIT License (MIT)
Copyright (c) 2016 Marco Castignoli

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
