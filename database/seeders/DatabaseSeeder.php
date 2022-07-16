<?php

namespace Database\Seeders;

use CreateUsersTable;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            CreateUserAdminSeeder::class,
            PermissionTableSeeder::class,
        ]);
    }
}
