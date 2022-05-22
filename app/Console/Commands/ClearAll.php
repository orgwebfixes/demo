<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'srtpl:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Artisan::call('optimize');
        $this->info('Optimize');

        Artisan::call('clear-compiled');
        $this->info('clear-compiled');

//        Artisan::call('debugbar:clear');
        $this->info('debugbar:clear');

        Artisan::call('view:clear');
        $this->info('view:clear');

        Artisan::call('config:cache');
        $this->info('config:cache');

        Artisan::call('config:clear');
        $this->info('config:clear');

        // Artisan::call('migrate');
        // $this->info('migrate');

        Artisan::call('route:clear');
        $this->info('route:clear');

//        Artisan::call('route:cache');
        $this->info('route:cache');
    }
}
