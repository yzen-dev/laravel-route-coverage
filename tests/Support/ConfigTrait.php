<?php

namespace Tests\Support;

use Illuminate\Config\Repository;
use Illuminate\Routing\Router;

trait ConfigTrait
{
    public function getConfig(): Repository
    {
        return new Repository([
            'route-coverage' => [
                'test_path' => dirname(__DIR__) . '/FakeTest',
                'percent_approval' => 0,
            ]
        ]);
    }
}