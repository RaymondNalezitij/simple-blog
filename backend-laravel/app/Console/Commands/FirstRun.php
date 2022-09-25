<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class firstRun extends Command
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
    protected $description = 'Create the first admin user and basic categories';

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
            'password' => Hash::make('admin')
        ]);
        $adminUser->user_type = 'Admin';
        $adminUser->save();


        (new Category(['name' => 'general']))->save();
        (new Category(['name' => 'sports']))->save();
        (new Category(['name' => 'science']))->save();
        (new Category(['name' => 'technology']))->save();
        (new Category(['name' => 'politics']))->save();
        (new Category(['name' => 'economy']))->save();
        (new Category(['name' => 'business']))->save();

        return 0;
    }
}
