<?php

namespace LaravelRouteCoverage;

/**
 * Class ServiceProvider
 * @package LaravelRouteCoverage
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\GenerateReportCommand::class,
            ]);
        }
    }
}
