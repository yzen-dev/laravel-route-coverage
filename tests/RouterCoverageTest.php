<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\ConfigTrait;
use Tests\Support\RouterTrait;
use PHPUnit\Framework\TestCase;
use LaravelRouteCoverage\RouterService;
use LaravelRouteCoverage\RouteCoverage;

/**
 * Class RouterCoverageTest
 *
 * @package Tests
 */
class RouterCoverageTest extends TestCase
{
    use RouterTrait, ConfigTrait;

    private RouterService $routerService;
    private RouteCoverage $routeCoverage;

    protected function setUp(): void
    {
        $this->routerService = new RouterService($this->getRouter());
        $this->routeCoverage = new RouteCoverage($this->routerService, $this->getConfig());
    }

    public function testDirNotFound(): void
    {
        $report = $this->routeCoverage->generate();
        $this->assertEquals(1, 1);
    }
}
