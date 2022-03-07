<?php

namespace LaravelRouteCoverage\Commands;

use Illuminate\Console\Command;
use LaravelRouteCoverage\RouteCoverage;
use LaravelRouteCoverage\RouterService;
use LaravelRouteCoverage\RouteCollection;
use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Foundation\Application;
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

    /**
     * @var Application
     */
    private Application $app;
    
    /**
     * @var RouterService
     */
    private RouterService $routerService;
    
    /**
     * @var RouteCoverage
     */
    private RouteCoverage $routeCoverage;
    
    /**
     * @var Config
     */
    private Config $config;
    
    /**
     * @var RouteCollection
     */
    private RouteCollection $routeCollection;

    /**
     * @param RouterService $router
     * @param RouteCoverage $routerService
     * @param Application $app
     * @param Config $config
     */
    public function __construct(RouterService $router, RouteCoverage $routerService, Application $app, Config $config)
    {
        parent::__construct();
        $this->app = $app;
        $this->routerService = $router;
        $this->config = $config;
        $this->routeCoverage = $routerService;
    }

    /** @return mixed Execute the console command. */
    public function handle()
    {
        if (empty($routes = $this->routerService->getRoutes())) {
            $this->error("Your application doesn't have any routes matching the given criteria.");
            return 0;
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
            (new HtmlReporter($this->app->basePath()))->generate($this->routeCollection);
        }
        if ($this->option('junit')) {
            (new JUnitReporter($this->app->basePath()))->generate($this->routeCollection);
        }

        if ($this->routeCollection->getCoveragePercent() < $this->config->get('route-coverage.percent_approval')) {
            exit(1);
        }
        exit(0);
    }

    /**
     * @return void
     */
    private function printEndpoints(): void
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
        $data = array_map($prepareRowTable, $this->routeCollection->get());

        $header = ['Route', 'Methods', 'Controller', 'Action', 'Count'];
        $this->table(
            $header,
            $data,
            'box-double'
        );
    }

    /**
     * @return void
     */
    private function printControllers(): void
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
