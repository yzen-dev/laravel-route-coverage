<?php

declare(strict_types=1);

namespace LaravelRouteCoverage;

use LaravelRouteCoverage\Parser\ParserFiles;

class RouteCoverage
{
    private $statistic = [];

    private $config = [];

    /**
     * RouteCoverage constructor.
     *
     * @param array $statistic
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function generate()
    {
        $parser = new ParserFiles($this->config);
        $testedRoutes = $parser->parse();

        $routes = RouterService::getAllUri();

        $this->prepareStatistic($testedRoutes, $routes);

    }

    private function prepareStatistic($testedRoutes, $routes)
    {
        $statistic = [
            'routes' => [],
        ];

        $statistic['routes'] = $this->countNumberTests($testedRoutes, $routes);
        $this->sortByCountNumberTests($statistic['routes']);

        $this->statistic = $statistic;
    }

    private function sortByCountNumberTests(&$testedRoutes)
    {
        return usort(
            $testedRoutes, function ($a, $b) {
            if ($a['count'] === $b['count']) {
                return 0;
            }
            return ($a['count'] > $b['count']) ? -1 : 1;
        }
        );
    }

    private function countNumberTests($testedRoutes, $routes)
    {
        $result = [];
        foreach ($routes as $route) {
            $statRoute = $route;
            $statRoute['count'] = 0;
            foreach ($testedRoutes as $testedRoute) {
                $formattedRoute = preg_replace('/{(.*?)}/', '{$val}', $route['url']);
                if ($testedRoute['url'] === $formattedRoute && in_array($testedRoute['method'], $route['methods'])) {
                    $statRoute['count']++;
                }
            }
            $result[] = $statRoute;
        }
        return $result;
    }


    /**
     * @return array
     */
    public function getStatistic(): array
    {
        return $this->statistic;
    }

    /**
     * @return array
     */
    public function getRouteStatistic(): array
    {
        return $this->statistic['routes'];
    }

    public function getCoveragePercent()
    {
        $countRoute = count($this->statistic['routes']);
        $percent = 0;
        $testedRoutes = array_filter(
            $this->statistic['routes'],
            function ($item) {
                return $item['count'] > 0;
            }
        );
        $countTestedRoutes = count($testedRoutes);

        return round($countTestedRoutes / $countRoute * 100, 2);
    }
}
