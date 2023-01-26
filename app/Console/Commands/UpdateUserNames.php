<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateUserNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user names: to split full name into {first and last} name';

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
     * @return void
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            if (is_null($user->last_name)) {
                $names = explode(' ', $user->first_name);
                $user->update(['first_name' => $names[0], 'last_name' => $names[1] ?? NULL]);
            }

        }

        $this->info('Users successfully updated!');
    }
}
