<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        \App\Models\User::truncate();
        \Artisan::call('roles:update');
        $admin = \App\Models\User::create([
            'surname' => 'Demo',
            'first_name' => 'Admin',
            'last_name' => 'Account',
            'email' => 'admin@demo.dev',
            'email_verified_at' => now(),
            'password' => bcrypt('pass_12345')
        ]);
        $admin->giveRoles('admin');

        $landlord = \App\Models\User::create([
            'surname' => 'Demo',
            'first_name' => 'Landlord',
            'last_name' => 'Account',
            'email' => 'landlord@demo.dev',
            'email_verified_at' => now(),
            'password' => bcrypt('pass_12345')
        ]);
        $landlord->giveRoles('landlord');

        $client = \App\Models\User::create([
            'surname' => 'Demo',
            'first_name' => 'Client',
            'last_name' => 'Account',
            'email' => 'client@demo.dev',
            'email_verified_at' => now(),
            'password' => bcrypt('pass_12345')
        ]);
        $client->giveRoles('client');

        \App\Models\Property::truncate();
        \App\Models\Property::factory(10)->create();
        Schema::enableForeignKeyConstraints();
    }
}
