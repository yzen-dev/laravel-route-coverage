<?php

namespace Tests\Support;

use Illuminate\Routing\Router;

trait RouterTrait
{
    public function getRouter(): Router
    {
        $router = new Router(new FakeDispatcher());
        $i = 0;
        foreach (RouterArray::$routes as $route) {
            $router->addRoute($route['method'], $route['url'], $route['controller']);
        }

        return $router;
    }
}
