<?php

namespace LaravelRouteCoverage;

/**
 * Class ServiceProvider
 *
 * @package LaravelRouteCoverage
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\GenerateReportCommand::class,
            ]);
        }

        $this->publishes(
            [
                __DIR__ . '/config/route-coverage.php' => $this->app->configPath('route-coverage.php'),
            ],
            'config'
        );
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/route-coverage.php', 'route-coverage');
    }
}
