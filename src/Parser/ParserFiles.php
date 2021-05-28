<?php

declare(strict_types=1);

namespace LaravelRouteCoverage\Parser;

class ParserFiles
{
    private const REGEX_MAP = [
        ['regex' => '/json\([\n\s]*\'([a-zA-Z]*)\'[\n\s]*,[\n\s]*\'([\da-zA-Z\/]*)\'/m'],
        ['regex' => '/call\([\n\s]*\'([a-zA-Z]*)\'[\n\s]*,[\n\s]*\'([\da-zA-Z\/]*)\'/m'],
        
        ['regex' => '/(get)\([\n\s]*\'([\da-zA-Z\/]*)\'/m'],
        ['regex' => '/(get)Json\([\n\s]*\'([\da-zA-Z\/]*)\'/m'],
        
        ['regex' => '/(post)\([\n\s]*\'([\da-zA-Z\/]*)\'/m'],
        ['regex' => '/(post)Json\([\n\s]*\'([\da-zA-Z\/]*)\'/m'],
        
        ['regex' => '/(put)\([\n\s]*\'([\da-zA-Z\/]*)\'/m'],
        ['regex' => '/(put)Json\([\n\s]*\'([\da-zA-Z\/]*)\'/m'],
        
        ['regex' => '/(patch)\([\n\s]*\'([\da-zA-Z\/]*)\'/m'],
        ['regex' => '/(patch)Json\([\n\s]*\'([\da-zA-Z\/]*)\'/m'],
        
        ['regex' => '/(delete)\([\n\s]*\'([\da-zA-Z\/]*)\'/m'],
        ['regex' => '/(delete)Json\([\n\s]*\'([\da-zA-Z\/]*)\'/m'],
        
        ['regex' => '/(options)\([\n\s]*\'([\da-zA-Z\/]*)\'/m'],
        ['regex' => '/(options)Json\([\n\s]*\'([\da-zA-Z\/]*)\'/m'],
        
        ['regex' => '/(get)\([\n\s]*\'([\da-zA-Z\/]*)\'/m'],
        ['regex' => '/(get)Json\([\n\s]*\'([\da-zA-Z\/]*)\'/m'],
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
            
            foreach (self::REGEX_MAP as $regex) {
                preg_match_all($regex['regex'], $content, $matches, PREG_SET_ORDER);
                foreach ($matches as $match) {
                    $testedRoutes[] = [
                        'url' => ltrim($match[2],'/'),
                        'method' => strtoupper($match[1]),
                    ];
                }
            }
        }
        
        return $testedRoutes;
    }
    
}
