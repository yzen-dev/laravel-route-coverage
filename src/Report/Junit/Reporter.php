<?php

namespace LaravelRouteCoverage\Report\Junit;

use LaravelRouteCoverage\Report\AbstractReport;
use LaravelRouteCoverage\RouteCollection;

/**
 *
 */
class Reporter extends AbstractReport
{
    /**
     * @param RouteCollection $routeCollection
     *
     * @return void
     * @throws \Exception
     */
    public function generate(RouteCollection $routeCollection)
    {
        $noTest = array_filter(
            $routeCollection->get(),
            static function ($item) {
                return $item['count'] === 0;
            }
        );
        $content = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $content .= '<testsuites name="LaravelRouteCoverage" errors="0" failures="' . count($noTest) . '" tests="' . count(
            $routeCollection->get()
        ) . '">' . PHP_EOL;

        foreach ($routeCollection->get() as $route) {
            $content .= '<testsuite name="/builds/tag/assist24/app/Helpers/Helper.php" errors="0" tests="7" failures="7">' . PHP_EOL;
            $content .=
                '<testcase name="' . $route['url'] . '" file="' . $route['controller'] . '@' . $route['action'] . '">
                  <failure type="error" message="No test"/>
                </testcase>' . PHP_EOL;
            $content .= '</testsuite> . PHP_EOL';
        }

        $content .= '</testsuites>';

        $this->saveFile('junit.xml', $content);
    }
}
