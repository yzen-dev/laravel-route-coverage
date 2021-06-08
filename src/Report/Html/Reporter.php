<?php

namespace LaravelRouteCoverage\Report\Html;

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
        $content = '<html><title>Route coverage report</title><link rel="stylesheet" href="css/style.css"><body>';
        $content .= '<h2>Coverage ' . $result->getCoveragePercent() . '% </h2>';

        $content .= '<table>';
        $content .= '<thead><td>URL</td><td>Methods</td><td>Controller</td><td>Action</td><td>Count</td></thead>';
        $content .= '<tbody>';
        foreach ($result->getRouteStatistic() as $route) {
            if ($route['count'] > 3) {
                $class = 'success';
            } elseif ($route['count'] > 0) {
                $class = 'warning';
            } else {
                $class = 'error';
            }


            $content .= '<tr class="' . $class . '">';
            $content .= '<td>' . $route['url'] . ' </td>';
            $content .= '<td class="methods">' . implode(', ', $route['methods']) . ' </td>';
            $content .= '<td>' . $route['controller'] . ' </td>';
            $content .= '<td>' . $route['action'] . ' </td>';
            $content .= '<td class="count">' . $route['count'] . ' </td>';
            $content .= '</tr>';
        }
        $content .= '</tbody></table>';

        $content .= '</body></html>';

        if (!file_exists($this->config['app_path'] . '/../public/route-coverage')) {
            mkdir($this->config['app_path'] . '/../public/route-coverage', 0755);
        }
        if (!file_exists($this->config['app_path'] . '/../public/route-coverage/css')) {
            mkdir($this->config['app_path'] . '/../public/route-coverage/css', 0755);
        }
        copy(__DIR__ . '/../../../template/html/style.css', $this->config['app_path'] . '/../public/route-coverage/css/style.css');

        $myFile = $this->config['app_path'] . '/../public/route-coverage/report.html';
        $fh = fopen($myFile, 'w');
        fwrite($fh, $content);
        fclose($fh);
    }
}
