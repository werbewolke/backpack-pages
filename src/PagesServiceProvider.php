<?php

namespace Werbewolke\Pages;

use Illuminate\Support\ServiceProvider;

class PagesServiceProvider extends ServiceProvider
{
    protected $vendorName = 'werbewolke';
    protected $packageName = 'pages';
    protected $commands = [
        \Werbewolke\Pages\Console\Commands\Install::class,
    ];
}
