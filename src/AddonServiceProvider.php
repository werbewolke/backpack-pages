<?php

namespace Werbewolke\Pages;

use Illuminate\Support\ServiceProvider;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'werbewolke';
    protected $packageName = 'pages';
    protected $commands = [];
}
