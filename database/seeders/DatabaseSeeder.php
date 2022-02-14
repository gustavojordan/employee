<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            UserSeeder::class,
        ];

        if (App::environment(['local', 'testing'])) {
            $seeders[] = EmployeeSeeder::class;
            $seeders[] = EmployeeClockSeeder::class;
        }

        $this->call($seeders);
    }
}
