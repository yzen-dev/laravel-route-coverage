<?php

declare(strict_types=1);

namespace LaravelRouteCoverage;

use Illuminate\Routing\Router;
use Illuminate\Support\Collection;

/**
 *
 */
class RouterService
{
    /**
     * The router instance.
     *
     * @var Router
     */
    protected $router;

    /**
     * Create a new route command instance.
     *
     * @param Router $router
     *
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;

        $this->router->flushMiddlewareGroups();
    }

    /**
     * @return array<mixed>
     */
    public function getRoutes(): array
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
            })
            ->toArray();
    }
}
