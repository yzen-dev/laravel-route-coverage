<?php

declare(strict_types=1);

namespace LaravelRouteCoverage;

use Illuminate\Config\Repository as Config;
use LaravelRouteCoverage\Parser\ParserFiles;

class RouteCoverage
{
    private $statistic = [];
    private ParserFiles $parser;
    private RouteCollection $collection;
    private RouterService $router;

    /**
     * RouteCoverage constructor.
     *
     * @param array $statistic
     */
    public function __construct(RouterService $routerService, Config $config)
    {
        $this->parser = new ParserFiles($config->get('route-coverage.test_path'));
        $this->router = $routerService;
    }

    public function generate(): RouteCollection
    {
        $testedRoutes = $this->parser->parse();
        $routes = $this->combineData($testedRoutes, $this->router->getRoutes());
        return new RouteCollection($routes);
    }

    private function combineData($testedRoutes, $routes)
    {
        $result = [];
        foreach ($routes as $route) {
            $statRoute = $route;
            $statRoute['count'] = 0;
            foreach ($testedRoutes as $testedRoute) {
                $formattedRoute = preg_replace('/{(.*?)}/', '{$val}', $route['url']);
                if ($testedRoute['url'] === $formattedRoute && in_array($testedRoute['method'], $route['methods'])) {
                    $statRoute['files'] [] = $testedRoute['file'];
                    $statRoute['count']++;
                }
            }
            $result[] = $statRoute;
        }

        return $result;
    }
}
