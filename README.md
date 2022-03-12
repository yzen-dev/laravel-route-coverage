# LaravelRouteCoverage
![Packagist Version](https://img.shields.io/packagist/v/yzen.dev/laravel-route-coverage?color=blue&label=version)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/yzen-dev/laravel-route-coverage/Run%20tests?label=tests&logo=github)
[![Coverage](https://codecov.io/gh/yzen-dev/laravel-route-coverage/branch/master/graph/badge.svg?token=QAO8STLPMI)](https://codecov.io/gh/yzen-dev/laravel-route-coverage)
![License](https://img.shields.io/github/license/yzen-dev/laravel-route-coverage)
![Packagist Downloads](https://img.shields.io/packagist/dm/yzen.dev/laravel-route-coverage)
![Packagist Downloads](https://img.shields.io/packagist/dt/yzen.dev/laravel-route-coverage)

Laravel route coverage report.

With this package you can see the percentage of test coverage of your routes. Unless of course you do it through Laravel or PHPUnit tests.
### How it works?
The package will scan all your tests collecting all the http queries that are called in them. After that, it will compare the results with the routes of your application. Routes are taken only by the `App` prefix to exclude vendor routes.

## :scroll: **Installation**
The package can be installed via composer:
```
composer require yzen.dev/laravel-route-coverage --dev
```

## :scroll: **Usage**

Generate report:
```
php artisan route:coverage
```
After executing the command, the result of the report will be displayed in the console in the following form:

<img width="1148" alt="console-all-routes" src="https://user-images.githubusercontent.com/24630195/157137803-d73fe73e-a0fc-49a1-8eb3-aeb3daf43b30.png">

### Possible options:

```bash
php artisan route:coverage --group-by-controller
```

In this case, all the results will be grouped by controllers, displaying how many actions there are in the controller, and how many of them are covered by tests.

<img width="448" alt="console-group-by-controller" src="https://user-images.githubusercontent.com/24630195/157138734-03639864-ea6c-45eb-8819-6dc732da9e3c.png">


```bash
php artisan route:coverage --html
```
Due to the `--html` option, you will also receive a generated report in the html page. The report will be located in the public directory `public/route-coverage`

<img width="1721" alt="html-report" src="https://user-images.githubusercontent.com/24630195/157138963-a6a0d24c-2020-4546-845a-130897cc9545.png">

