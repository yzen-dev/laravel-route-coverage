<?php

declare(strict_types=1);

namespace Tests;

use LaravelRouteCoverage\Report\Junit\Reporter as JunitReporter;
use Tests\Support\ConfigTrait;
use Tests\Support\RouterArray;
use Tests\Support\RouterTrait;
use PHPUnit\Framework\TestCase;
use LaravelRouteCoverage\RouterService;
use LaravelRouteCoverage\RouteCoverage;

/**
 * Class ReportJunitTest
 *
 * @package Tests
 */
class ReportJunitTest extends TestCase
{
    use RouterTrait, ConfigTrait;
    private string $dir;
    
    protected function setUp(): void
    {
        if (!file_exists( __DIR__. '/tmp')) {
            mkdir(__DIR__ . '/tmp', 0755);
        }
        if (!file_exists( __DIR__. '/tmp/public')) {
            mkdir(__DIR__ . '/tmp/public', 0755);
        }
        $this->dir = __DIR__ . '/tmp';
    }

    public function testGetProjectRoutes(): void
    {
        $routerService = new RouterService($this->getRouter());
        $routeCoverage = new RouteCoverage($routerService, $this->getConfig());
        $routeCollection = $routeCoverage->generate();
        (new JunitReporter($this->dir))->generate($routeCollection);
        $this->assertFileExists($this->dir . '/public/route-coverage/junit.xml');
    }
    
    protected function tearDown(): void
    {
        $this->deleteDirectory($this->dir);
        parent::tearDown();
    }

    private function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

        }

        return rmdir($dir);
    }
}
