<?php

namespace DummyVpos;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->bootPublishes();

        $this->loadRoutesFrom($this->withThisPath('routes/web.php'));
        $this->loadViewsFrom($this->withThisPath('resources/views'), 'dummy-vpos');
    }

    public function register(): void
    {
        $this->registerConfig();
    }

    protected function bootPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/../config/dummy-vpos.php' => $this->app->configPath('dummy-vpos.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/dummy-vpos'),
        ], 'dummy-vpos-public');
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/dummy-vpos.php', 'dummy-vpos');
    }

    protected function withThisPath(string $path): string
    {
        return realpath(__DIR__ . "/../{$path}");
    }
}
