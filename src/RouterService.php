<?php

declare(strict_types=1);

namespace LaravelRouteCoverage;

use Illuminate\Support\Facades\Route;

class RouterService
{
    public static function getAllUri()
    {
        $clearRoutes = [];
        $laravelRoutes = Route::getRoutes()->getRoutes();
        foreach ($laravelRoutes as $route) {
            if (is_string($route->action['uses']) && preg_match('/App\\\/', $route->action['uses'])) {
                $action = explode('@', $route->action['controller']);
                $clearRoutes[] = [
                    'url' => $route->uri,
                    'methods' => $route->methods,
                    'controller' => array_shift($action),
                    'action' => array_shift($action),
                ];
            }
        }
        return $clearRoutes;
    }
}
