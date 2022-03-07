<?php

declare(strict_types=1);

namespace LaravelRouteCoverage\Parser;

use Illuminate\Contracts\Foundation\Application;

class ParserFiles
{
    private const REGEX = [
        '/->(json|call)\(([\s\S]*?)\)/m',
        '/->(get|getJson|post|postJson|put|putJson|patch|patchJson|delete|deleteJson|options|optionsJson)\(([\s\S]*?)\)/m',
    ];

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

    public function getAllPaths($dir): ?array
    {
        if (!is_dir($dir)) {
            return null;
        }

        $items = scandir($dir);

        $files = [];
        $scannedItem = array_diff($items, ['..', '.']);
        foreach ($scannedItem as $item) {
            $path = $dir . DIRECTORY_SEPARATOR . $item;
            if (is_dir($path)) {
                $files = array_merge($files, $this->getAllPaths($path));
                continue;
            }
            $files[] = $path;
        }
        return $files;
    }

    public function parse()
    {
        $files = $this->getAllPaths($this->testPath);
        if ($files === null) {
            return null;
        }

        $testedRoutes = [];

        foreach ($files as $file) {
            $content = file_get_contents($file);

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

                        $url = ltrim($route, '/');
                        $url = trim(preg_replace('/\s+/', ' ', $url));
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
