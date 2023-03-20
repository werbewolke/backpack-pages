<?php

namespace Werbewolke\Pages;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class PagesServiceProvider extends ServiceProvider
{
//    use AutomaticServiceProvider;

    protected $vendorName = 'werbewolke';
    protected $packageName = 'pages';
    protected $commands = [
        \Werbewolke\Pages\Console\Commands\Install::class,
    ];

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
