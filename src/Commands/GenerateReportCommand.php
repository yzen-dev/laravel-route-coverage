<?php

namespace LaravelRouteCoverage\Commands;

use Illuminate\Console\Command;
use LaravelRouteCoverage\RouteCoverage;
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
    protected $signature = 'route:coverage';

    /** @var string The console command description. */
    protected $description = 'Generate endpoints coverage report ';

    /** @return mixed Execute the console command. */
    public function handle()
    {
        $parser = new RouteCoverage(['app_path' => base_path('app')]);
        $parser->generate();
        $this->warn('Covarage ' . $parser->getCoveragePercent() . '%');
        $prepareRowTable = static function ($route) {
            return [
                'url' => $route['url'],
                'methods' => implode(', ', $route['methods']),
                'controller' => $route['controller'],
                'action' => $route['action'],
                'count' => $route['count'],
            ];
        };
        $data = array_map($prepareRowTable, $parser->getRouteStatistic());

        $header = ['Route', 'Methods', 'Controller', 'Action', 'Count'];
        $this->table(
            $header,
            $data,
            'box-double'
        );
        (new HtmlReporter(['app_path' => app_path()]))->generate($parser);
        (new JUnitReporter(['app_path' => app_path()]))->generate($parser);

        if ($parser->getCoveragePercent() < app()['config']['route-coverage']['percent_approval']) {
            exit(1);
        }
        exit(0);
    }
}
