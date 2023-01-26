<?php

namespace App\Console\Commands;

use App\Models\Role;
use Illuminate\Console\Command;

class UpdateRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update User Roles';

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
        /*\Schema::disableForeignKeyConstraints();
        Role::truncate();
        \Schema::enableForeignKeyConstraints();*/
        $roles = array(
            ['name' => 'Master', 'slug' => \Str::slug('Master', '-'), 'category' => 'Access Level'],
            ['name' => 'Admin', 'slug' => \Str::slug('Admin', '-'), 'category' => 'Access Level'],
            ['name' => 'Landlord', 'slug' => \Str::slug('Landlord', '-'), 'category' => 'Access Level'],
            ['name' => 'Client', 'slug' => \Str::slug('Client', '-'), 'category' => 'Access Level']
        );

        foreach ($roles as $role) {
            Role::query()->firstOrCreate(
                ['name' => $role['name']],
                $role
            );
        }

        $this->info('Roles successfully updated');
    }
}
