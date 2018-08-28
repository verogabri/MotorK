# MotorK PHP Assignment

## Assignment

You have to port the old web page located at [http://localhost:8888/legacy.php](http://localhost:8888/legacy.php) and create a new application. 

 * The page [http://localhost:8888](http://localhost:8888) should contain the list of cars
 * Each car should have a Detail page located at [http://localhost:8888/detail/{carId}](http://localhost:8888/detail/{carId})
 * Each Detail page should contain a form, to be able to save the lead for that particular car
 * Every Detail page should feature a "Similar cars widget" that show cars similar to the one requested.  
 
We've already stubbed the structure of the application, here's a rundown of the various folders:

 * `api` contains the code to power the simple API that's the data source for this assignment
 * `data` contains the cars' data
 * `db` contains the migrations and the database
 * `src` contains all the source code (you should spend most of your time here)
 * `tests` contains unit test. Use PHPUnit to write these.
 * `views` contains the views, `index` for the list of cars, `detail` for the car's detail.
 * `web` is the public folder. `index.php` is the front router script, while `legacy.php` represents your starting point.
 
Minimal UI and CSS is provided and it will not be part of the evaluation, so focus on the domain modeling and business logic.
But if you have spare time, you could try to improve the provided UI.  

## Usage

Before starting run `composer install` to install all the required dependencies.

### Server

We are using the PHP builtin server to serve the application. You can run it with this command:

```
$ composer run server --timeout 0
```

By default, the server will be listening on the 8888 port [http://localhost:8888/](http://localhost:8888/)

The old application is located at [http://localhost:8888/legacy.php](http://localhost:8888/legacy.php)


### API

Cars’ data is provided and must be fetched through an API (already implemented).

To start the API run this command:

```
$ composer run api --timeout 0
```

The API will be listening from this URL `http://localhost:8889/api.php`.

The API has two endpoints:

1: `/search` (Example [http://localhost:8889/api.php/search](http://localhost:8889/api.php/search))

This will return the list of all cars available.

2: `/detail/{detailID}` (Example [http://localhost:8889/api.php/detail/616](http://localhost:8889/api.php/detail/616))


### Tests
phpUnit documentation [https://phpunit.de/manual/6.5/en/writing-tests-for-phpunit.html] (https://phpunit.de/manual/6.5/en/writing-tests-for-phpunit.html)
To run the tests use this command:

```
$ composer run test 
$ ./vendor/bin/phpunit --bootstrap vendor/autoload.php --testdox tests
```

### Database and Migrations

Use a SQLite database to create the _Leads_ table and store the data. 
We have already setup the infrastructure to run migrations with [Phinx](http://docs.phinx.org/en/latest/), but you can
do it manually if you want.

The database should be named `motork_dev_test` and saved in the `data` folder.

Migrations can be found in this folder `db/migrations` and can be run using this command:

```
$ ./vendor/bin/phinx migrate
```


