<?php

declare(strict_types=1);

namespace LaravelRouteCoverage;

/**
 *
 */
final class RouteCollection
{
    /**
     * The items contained in the collection.
     *
     * @var array<mixed>
     */
    protected array $items = [];

    /**
     * Create a new collection.
     *
     * @param array<mixed> $items
     *
     * @return void
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @return self
     */
    public function sortRotesByTests(): self
    {
        $routes = $this->items;
        usort(
            $routes,
            function ($a, $b) {
                if ($a['count'] === $b['count']) {
                    return 0;
                }
                return ($a['count'] > $b['count']) ? -1 : 1;
            }
        );
        return new self($routes);
    }

    /**
     * @return self
     */
    public function sortControllerByTests(): self
    {
        $controllers = $this->items;
        usort($controllers, function ($a, $b) {
            if ($a['testedActions'] === $b['testedActions']) {
                return 0;
            }
            return ($a['testedActions'] > $b['testedActions']) ? -1 : 1;
        });
        return new self($controllers);
    }

    /**
     * @return array<mixed>
     */
    public function get(): array
    {
        return $this->items;
    }


    /**
     * @return self
     */
    public function getTestedRouteStatistic(): self
    {
        return new self(
            array_filter(
                $this->items,
                function ($item) {
                    return $item['count'] > 0;
                }
            )
        );
    }

    /**
     * Get coverage percent
     *
     * @return float
     */
    public function getCoveragePercent(): float
    {
        $countRoute = $this->count();
        $countTestedRoutes = $this->getTestedRouteStatistic()->count();

        return round($countTestedRoutes / $countRoute * 100, 2);
    }

    /**
     * Count the number of items in the collection.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return self
     */
    public function groupByController(): self
    {
        $controllers = [];
        foreach ($this->get() as $item) {
            if (!isset($controllers [$item['controller']])) {
                $controllers [$item['controller']] = [
                    'controller' => $item['controller'],
                    'namespace' => $item['namespace'],
                    'countActions' => 1,
                    'testedActions' => $item['count'] > 0 ? 1 : 0,
                    'actions' => [$item['action'] => $item],
                ];
                continue;
            }
            if (!isset($controllers[$item['controller']]['actions'][$item['action']])) {
                $controllers[$item['controller']]['actions'][$item['action']] = $item;
                $controllers[$item['controller']]['countActions']++;
                if ($item['count']) {
                    $controllers[$item['controller']]['testedActions']++;
                }
            }
        }
        return new self($controllers);
    }
}
