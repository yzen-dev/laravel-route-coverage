<?php

namespace LaravelRouteCoverage\Report\Junit;

use LaravelRouteCoverage\RouteCollection;

/**
 *
 */
class Reporter
{
    /** @var string */
    private $basePath;

    /**
     * @param string $basePath
     */
    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @param RouteCollection $routeCollection
     *
     * @return void
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
        if (!file_exists($this->basePath . '/public/route-coverage')) {
            mkdir($this->basePath . '/public/route-coverage', 0755);
        }
        $myFile = $this->basePath . '/public/route-coverage/junit.xml';
        $fh = fopen($myFile, 'w');
        fwrite($fh, $content);
        fclose($fh);
    }
}
