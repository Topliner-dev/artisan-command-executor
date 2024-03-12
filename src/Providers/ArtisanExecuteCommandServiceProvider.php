<?php

declare(strict_types=1);

namespace Topliner\ArtisanCommandExecutor\Providers;

use Illuminate\Support\ServiceProvider;

class ArtisanExecuteCommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/artisan-command-executor.php' => config_path('artisan-command-executor.php'),
            ]);

            $this->loadRoutesFrom(__DIR__ . '/../../routes/tools.php');
        }
    }
}