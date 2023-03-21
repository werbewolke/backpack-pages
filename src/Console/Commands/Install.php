<?php

namespace Werbewolke\Pages\Console\Commands;

use Backpack\CRUD\app\Console\Commands\Traits\PrettyCommandOutput;
use Backpack\CRUD\BackpackServiceProvider;
use Illuminate\Console\Command;

class Install extends Command
{
    use PrettyCommandOutput;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'werbewolke:pages:install
                                {--debug} : Show process output or not. Useful for debugging.';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Werbewolke\Pages for Backpack.';

    /**
     * Execute the console command.
     *
     * @return mixed Command-line output
     */
    public function handle()
    {
        $this->newLine();

        $this->executeArtisanProcess('vendor:publish', [
            '--provider' => 'Werbewolke\Pages\PagesServiceProvider',
        ]);
        $this->progressBlock('Copied CRUD files in app folder', 'done', 'green');
        $this->newLine();
        $this->progressBlock('Copied migration', 'done', 'green');
        $this->newLine();
        $this->progressBlock('Copied pages.js to public folder', 'done', 'green');
        $this->newLine(2);

        $this->call('backpack:add-custom-route', [
            'code' => "Route::crud('page', 'PageCrudController');",
        ]);

        $this->executeArtisanProcess('backpack:add-sidebar-content', [
            'code' => '<li class="nav-item"><a class="nav-link" href="{{ backpack_url(\'page\') }}"><i class="nav-icon la la la-copy"></i> <span>Seiten</span></a></li>', ]);

        $this->progressBlock('Adding item to <fg=blue>resources/views/vendor/backpack/base/inc/sidebar_content.blade.php</>', 'done', 'green');
        $this->newLine(2);
    }
}
