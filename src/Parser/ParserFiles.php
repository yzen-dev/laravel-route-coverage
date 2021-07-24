<?php

declare(strict_types=1);

namespace LaravelRouteCoverage\Parser;

class ParserFiles
{
    private const REGEX = [
        '/->(json|call)\(([\s\S]*?)\)/m',
        '/->(get|getJson|post|postJson|put|putJson|patch|patchJson|delete|deleteJson|options|optionsJson)\(([\s\S]*?)\)/m',
    ];

    /**
     * RouteCoverage constructor.
     *
     * @param array $statistic
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getAllPaths($dir): array
    {
        $items = scandir($dir);
        $files = [];
        $scannedItem = array_diff($items, ['..', '.']);
        foreach ($scannedItem as $item) {
            if (in_array($item, ['.', '..'])) {
                continue;
            }
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
        $dir = $this->config['app_path'] . '/../tests';
        if (is_dir($dir)) {
            $files = $this->getAllPaths($dir);
        }
        $testedRoutes = [];

        foreach ($files as $file) {
            $content = file_get_contents($file);

            foreach (self::REGEX as $regex) {
                preg_match_all($regex, $content, $matches, PREG_SET_ORDER);
                if (empty($matches)) continue;

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

                        $url = ltrim($route, '/');
                        $url = trim(preg_replace('/\s+/', ' ', $url));
                        $testedRoutes[] = [
                            'url' => $url,
                            'method' => strtoupper($method),
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
