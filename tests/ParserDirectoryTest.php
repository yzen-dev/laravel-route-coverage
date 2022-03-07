<?php

declare(strict_types=1);

namespace Tests;

use LaravelRouteCoverage\Parser\ParserFiles;
use Tests\Support\ConfigTrait;
use Tests\Support\RouterArray;
use Tests\Support\RouterTrait;
use PHPUnit\Framework\TestCase;

/**
 * Class ParserDirectoryTest
 *
 * @package Tests
 */
class ParserDirectoryTest extends TestCase
{
    use RouterTrait, ConfigTrait;

    private ParserFiles $parser;

    protected function setUp(): void
    {
        $this->parser = new ParserFiles($this->getConfig()->get('route-coverage.test_path'));
    }

    public function testParserTestDir(): void
    {
        $testedRoutes = $this->parser->parse();
        $this->assertCount(count(RouterArray::$routes), $testedRoutes);
    }
}
