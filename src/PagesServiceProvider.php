<?php

namespace Werbewolke\Pages;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class PagesServiceProvider extends ServiceProvider
{
    protected $vendorName = 'werbewolke';
    protected $packageName = 'pages';
    protected $commands = [
        \Werbewolke\Pages\Console\Commands\Install::class,
    ];

    /**
     * Boot method may be overrided by AddonServiceProvider
     *
     * @return void
     */
    public function boot(): void
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {

        $this->publishes([
            __DIR__.'/../publish' => './',
        ]);

        // Registering package commands.
        if (! empty($this->commands)) {
            $this->commands($this->commands);
        }
    }
}
