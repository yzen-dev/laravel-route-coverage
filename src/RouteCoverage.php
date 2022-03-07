<?php

declare(strict_types=1);

namespace LaravelRouteCoverage;

use Illuminate\Config\Repository as Config;
use Illuminate\Support\Collection;
use LaravelRouteCoverage\Parser\ParserFiles;

/**
 *
 */
class RouteCoverage
{
    /**
     * @var ParserFiles
     */
    private ParserFiles $parser;
    
    /**
     * @var RouterService
     */
    private RouterService $router;

    /**
     * RouteCoverage constructor.
     *
     * @param RouterService $routerService
     * @param Config $config
     */
    public function __construct(RouterService $routerService, Config $config)
    {
        $this->parser = new ParserFiles($config->get('route-coverage.test_path'));
        $this->router = $routerService;
    }

    /**
     * @return RouteCollection
     */
    public function generate(): RouteCollection
    {
        $testedRoutes = $this->parser->parse();
        $routes = $this->combineData($testedRoutes, $this->router->getRoutes());
        return new RouteCollection($routes);
    }

    /**
     * @param array<mixed> $testedRoutes
     * @param array<mixed> $routes
     *
     * @return array<mixed>
     */
    private function combineData(array $testedRoutes, array $routes): array
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
