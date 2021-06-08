# LaravelRouteCoverage

Laravel route coverage report.

With this package you can see the percentage of test coverage of your endpoint's. Unless of course you do it through Laravel or PHPUnit tests.
How it works?
First, we scan the entire directory where the tests are stored, and look for all the http calls there. After that, we take all the routes of the project and combine it into a single report. 

## :scroll: **Installation**
The package can be installed via composer:
```
composer require yzen.dev/laravel-route-coverage
```

## :scroll: **Usage**

Generate report:
```
php artisan route:coverage
```
After executing the command, the result of the report will be displayed in the console in the following form:

![image](https://user-images.githubusercontent.com/24630195/121243805-d181c080-c8a6-11eb-9752-b27355a7c26e.png)


Also the html report will be saved in the public/route-coverage directory:

![image](https://user-images.githubusercontent.com/24630195/121243718-b747e280-c8a6-11eb-902d-6be093ec0cf8.png)
