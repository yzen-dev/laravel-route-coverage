<?php

declare(strict_types=1);

namespace LaravelRouteCoverage;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class RouterService
{
    /**
     * The router instance.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * Create a new route command instance.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;

        $this->router->flushMiddlewareGroups();
    }

    public function getRoutes()
    {

        return collect($this->router->getRoutes())
            ->filter(fn ($route) => is_string($route->action['uses']) && preg_match('/App\\\/', $route->action['uses']))
            ->map(function ($route) {
                preg_match('/(.*)\\\\(.*)@/m', $route->action['controller'], $controller);
                return [
                    'url' => $route->uri,
                    'methods' => $route->methods,
                    'namespace' => $controller[1],
                    'controller' => $controller[2],
                    'action' => $route->getActionMethod(),
                    'fullAction' => $route->getActionName(),
                ];
            });
    }
}
