<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class first_run extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:first-run';

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
     * @return int
     */
    public function handle()
    {
        $adminUser = new User([
            'name' => 'admin',
            'email' => 'admin@host.com',
            'password' => bcrypt('admin')
        ]);
        $adminUser->user_type = 'Admin';
        $adminUser->save();

        return 0;
    }
}
