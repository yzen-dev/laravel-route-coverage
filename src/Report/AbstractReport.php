<?php

namespace LaravelRouteCoverage\Report;

use Exception;

class AbstractReport
{
    /** @var string */
    protected string $basePath;

    /**
     * @param string $basePath
     */
    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
        $this->createReportDir();
    }

    /**
     * @param string $fileName
     * @param string $content
     *
     * @return void
     * @throws Exception
     */
    public function saveFile(string $fileName, string $content): void
    {
        $file = fopen($this->basePath . '/public/route-coverage/' . $fileName, 'w');
        if (!$file) {
            throw new Exception('Error opening file');
        }
        fwrite($file, $content);
        fclose($file);
    }

    /**
     * @return void
     */
    public function createReportDir(): void
    {
        if (!file_exists($this->basePath . '/public/route-coverage')) {
            mkdir($this->basePath . '/public/route-coverage', 0755);
        }
    }
}
