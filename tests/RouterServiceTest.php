<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\ConfigTrait;
use Tests\Support\RouterArray;
use Tests\Support\RouterTrait;
use PHPUnit\Framework\TestCase;
use LaravelRouteCoverage\RouterService;
use LaravelRouteCoverage\RouteCoverage;

/**
 * Class RouterServiceTest
 *
 * @package Tests
 */
class RouterServiceTest extends TestCase
{
    use RouterTrait, ConfigTrait;

    private RouterService $routerService;

    protected function setUp(): void
    {
        $this->routerService = new RouterService($this->getRouter());
    }

    public function testGetProjectRoutes(): void
    {
        $projectRoutes = $this->routerService->getRoutes();
        $testedRoutes = collect(RouterArray::$routes)->unique('url');
        
        $this->assertCount(count($testedRoutes), $projectRoutes);
    }
}
