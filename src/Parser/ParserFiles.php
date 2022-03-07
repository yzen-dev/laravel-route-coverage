<?php

declare(strict_types=1);

namespace LaravelRouteCoverage\Parser;

/**
 *
 */
class ParserFiles
{
    /** @const array */
    private const REGEX = [
        '/->(json|call)\(([\s\S]*?)\)/m',
        '/->(get|getJson|post|postJson|put|putJson|patch|patchJson|delete|deleteJson|options|optionsJson)\(([\s\S]*?)\)/m',
    ];

    /**
     * @var string
     */
    private string $testPath;

    /**
     * RouteCoverage constructor.
     *
     * @param string $testPath
     */
    public function __construct(string $testPath)
    {
        $this->testPath = $testPath;
    }

    /**
     * Get all files in directory
     *
     * @param string $dir
     *
     * @return null|array<string>
     */
    public function getAllPaths(string $dir): ?array
    {
        if (!is_dir($dir)) {
            return null;
        }

        $items = scandir($dir);

        if (!$items) {
            return null;
        }

        $files = [];
        $scannedItem = array_diff($items, ['..', '.']);
        foreach ($scannedItem as $item) {
            $path = $dir . DIRECTORY_SEPARATOR . $item;
            if (!is_dir($path)) {
                $files[] = $path;
            }
            $scanFiles = $this->getAllPaths($path);
            if ($scanFiles !== null) {
                $files = array_merge($files, $scanFiles);
            }
        }
        return $files;
    }

    /**
     * Get all test-files
     *
     * @return null|array<int,array>
     */
    public function parse(): ?array
    {
        $files = $this->getAllPaths($this->testPath);
        if ($files === null) {
            return null;
        }

        $testedRoutes = [];

        foreach ($files as $file) {
            $content = file_get_contents($file);
            if (!$content) {
                continue;
            }

            foreach (self::REGEX as $regex) {
                preg_match_all($regex, $content, $matches, PREG_SET_ORDER);
                if (empty($matches)) {
                    continue;
                }

                foreach ($matches as $match) {
                    try {
                        if ($match[1] === 'json') {
                            preg_match('/[\n\s]*\'([a-zA-Z]*)\'[\n\s]*,[\n\s]*\'(.*)/m', $match[2], $action);
                            $method = $action[1];
                            preg_match('/.*?,(.*)/m', $action[2], $checkHeader);
                            if (!empty($checkHeader)) {
                                preg_match('/(.*?)\'[\n\s]*,/m', $action[2], $route);
                                $route = $route[1];
                            } else {
                                $route = $action[2];
                            }
                        } else {
                            preg_match('/([a-zA-Z]*)\(([\s\S]*?)(,|\))/m', $match[0], $action);
                            $method = preg_replace('/json/i', '', $action[1]);
                            $route = $action[2];
                        }

                        $route = preg_replace('/([\'"][\n\s]*\.[\n\s]*\$(.*?)[\n\s]*\.[\n\s]*[\'"])/', '{$val}', $route);
                        $route = preg_replace('/([\'"][\n\s]*\.[\n\s]*\$(.*))[\'"]*/', '{$val}', $route);
                        $route = preg_replace('/([\'"])/', '', $route);
                        $route = preg_replace('/\?(.*)/', '', $route);
                        if (is_string($route)) {
                            $url = ltrim($route, '/');
                            $url = trim(preg_replace('/\s+/', ' ', $url));
                        } else {
                            continue;
                        }
                        $testedRoutes[] = [
                            'url' => $url,
                            'method' => strtoupper($method),
                            'file' => realpath($file),
                        ];
                    } catch (\Throwable $exception) {
                        echo 'error: ' . json_encode($match) . PHP_EOL;
                    }
                }
            }
        }
        return $testedRoutes;
    }
}
