<?php

namespace LaravelRouteCoverage\Commands;

use Illuminate\Console\Command;
use LaravelRouteCoverage\RouteCoverage;
use LaravelRouteCoverage\RouterService;
use LaravelRouteCoverage\RouteCollection;
use LaravelRouteCoverage\Report\Html\Reporter as HtmlReporter;
use LaravelRouteCoverage\Report\Junit\Reporter as JUnitReporter;

/**
 * Class StatusCommand
 *
 * @package LaravelRouteCoverage\Commands
 */
class GenerateReportCommand extends Command
{
    /** @var string The console command name. */
    protected $signature = 'route:coverage {--html} {--junit} {--group-by-controller}';

    /** @var string The console command description. */
    protected $description = 'Generate endpoints coverage report ';

    private RouterService $routerService;
    private RouteCoverage $routeCoverage;
    private RouteCollection $routeCollection;

    public function __construct(RouterService $router, RouteCoverage $routerService)
    {
        parent::__construct();
        $this->routerService = $router;
        $this->routeCoverage = $routerService;
    }

    /** @return mixed Execute the console command. */
    public function handle()
    {
        if (empty($routes = $this->routerService->getRoutes())) {
            return $this->error("Your application doesn't have any routes matching the given criteria.");
        }
        $this->routeCollection = $this->routeCoverage->generate();

        $this->info('All routes ' . $this->routeCollection->count());
        $this->info('Tested routes ' . $this->routeCollection->getTestedRouteStatistic()->count());
        $this->warn('Coverage ' . $this->routeCollection->getCoveragePercent() . '%');

        if ($this->option('group-by-controller')) {
            $this->printControllers();
        } else {
            $this->printEndpoints();
        }
        if ($this->option('html')) {
            (new HtmlReporter(['app_path' => app_path()]))->generate($this->routeCollection);
        }
        if ($this->option('json')) {
            (new JSONReporter(['app_path' => app_path()]))->generate($this->routeCollection);
        }
        if ($this->option('junit')) {
            (new JUnitReporter(['app_path' => app_path()]))->generate($this->routeCollection);
        }

        if ($this->routeCollection->getCoveragePercent() < app()['config']['route-coverage']['percent_approval']) {
            exit(1);
        }
        exit(0);
    }

    private function printEndpoints()
    {
        $prepareRowTable = static function ($route) {
            return [
                'url' => $route['url'],
                'methods' => implode(', ', $route['methods']),
                'controller' => $route['controller'],
                'action' => $route['action'],
                'count' => $route['count'],
            ];
        };
        $data = array_map($prepareRowTable, $this->parser->getRouteStatistic());

        $header = ['Route', 'Methods', 'Controller', 'Action', 'Count'];
        $this->table(
            $header,
            $data,
            'box-double'
        );
    }

    private function printControllers()
    {
        $prepareRowTable = static function ($route) {
            return [
                'controller' => $route['controller'],
                'actions' => $route['testedActions'] . ' / ' . $route['countActions'],
                'coverage' => round($route['testedActions'] / $route['countActions'] * 100, 2)
            ];
        };

        $data = array_map($prepareRowTable, $this->routeCollection->groupByController()->get());

        $header = ['Controller', 'Tested', 'Coverage'];
        $this->table(
            $header,
            $data,
            'box-double'
        );
    }
}
