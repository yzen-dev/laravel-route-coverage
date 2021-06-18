<?php

namespace LaravelRouteCoverage\Report\Junit;

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
        $noTest = array_filter(
            $result->getRouteStatistic(),
            static function ($item) {
                return $item['count'] === 0;
            }
        );
        $content = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $content .= '<testsuites name="LaravelRouteCoverage" errors="0" failures="' . count($noTest) . '" tests="' . count(
                $result->getRouteStatistic()
            ) . '">' . PHP_EOL;

        foreach ($result->getRouteStatistic() as $route) {
            $content .= '<testsuite name="/builds/tag/assist24/app/Helpers/Helper.php" errors="0" tests="7" failures="7">' . PHP_EOL;
            $content .=
                '<testcase name="' . $route['url'] . '" file="' . $route['controller'] . '@' . $route['action'] . '">
                  <failure type="error" message="No test"/>
                </testcase>' . PHP_EOL;
            $content .= '</testsuite> . PHP_EOL';
        }

        $content .= '</testsuites>';
        if (!file_exists($this->config['app_path'] . '/../public/route-coverage')) {
            mkdir($this->config['app_path'] . '/../public/route-coverage', 0755);
        }
        $myFile = $this->config['app_path'] . '/../public/route-coverage/junit.xml';
        $fh = fopen($myFile, 'w');
        fwrite($fh, $content);
        fclose($fh);
    }
}
