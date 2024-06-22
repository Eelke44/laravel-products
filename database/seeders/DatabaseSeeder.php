<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the database.
     */
    public function run(): void
    {
        $seeders = [
            new UserSeeder(),
        ];

        foreach ($seeders as $seeder) {
            $seeder->run();
        }
    }
}
