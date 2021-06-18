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

![image](https://user-images.githubusercontent.com/24630195/122606099-1369ee00-d081-11eb-9577-a4a1a4a503bb.png)


Also the html report will be saved in the public/route-coverage directory:

![image](https://user-images.githubusercontent.com/24630195/122606142-2250a080-d081-11eb-9950-0ed795d9c7b8.png)


The parser parses most requests, for example, such constructions will definitely be recognized

```php
$this->json('GET', '/api/v1/agents/' . $agent->id . '/auth/token');
$this->json('POST', '/api/v1/bids', [], ['Authorisation' => 'bearer ' . $response['data']['token']]);
$this->json('POST', '/api/v1/agents')->assertForbidden();
$this->json('PUT', '/api/v1/agents/' . $agent->id . '/users/' . $subUser->id . '/blocked')
$this->post('/api/v1/agents')->assertForbidden();
$this->postJson('/api/v1/agents')->assertForbidden();
$this->get('/api/v1/agents/' . $agent->id . '/auth/token')->assertForbidden();
$this->getJson('/api/v1/agents/' . $agent->id . '/auth/token')->assertForbidden();
$this->put('/api/v1/agents/' . $agent->id . '/auth/token')->assertForbidden();
$this->putJson('/api/v1/agents/' . $agent->id . '/auth/token')->assertForbidden();
$this->patch('/api/v1/agents/' . $agent->id . '/auth/token')->assertForbidden();
$this->patchJson('/api/v1/agents/' . $agent->id . '/auth/token')->assertForbidden();
$this->delete('/api/v1/agents/' . $agent->id . '/auth/token')->assertForbidden();
$this->deleteJson('/api/v1/agents/' . $agent->id . '/auth/token')->assertForbidden();
```
