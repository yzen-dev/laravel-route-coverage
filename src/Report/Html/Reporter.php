<?php

namespace LaravelRouteCoverage\Report\Html;

use Hal\Application\Config\Config;
use Hal\Metric\Consolidated;
use Hal\Metric\Group\Group;
use Hal\Metric\Metrics;
use LaravelRouteCoverage\RouteCoverage;

class Reporter
{
    /** @var array */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }


    public function generate(RouteCoverage $result)
    {
        //;
        $content = '<html><head></head> <body>';
        $content .= '<h2>Covarage ' . $result->getCoveragePercent() . '% </h2>';

        $content .= '<table>';
        $content .= '<thead><td>URL</td><td>Methods</td><td>Controller</td><td>Action</td><td>Count</td></thead>';
        $content .= '<tbody>';
        foreach ($result->getRouteStatistic() as $route){
            $content .= '<tr>';
            $content .= '<td>' . $route['url'] . ' </td>';
            $content .= '<td>' . implode(', ', $route['methods']) . ' </td>';
            $content .= '<td>' . $route['controller'] . ' </td>';
            $content .= '<td>' . $route['action'] . ' </td>';
            $content .= '<td>' . $route['count'] . ' </td>';
            $content .= '</tr>';
        }
        $content .= '</tbody></table>';

        $content .= '</body></html>';

        $myFile = $this->config['app_path'] . '/../public/route-coverage/report.html';
        $fh = fopen($myFile, 'w'); 
        fwrite($fh, $content);
        fclose($fh);
    }
}
