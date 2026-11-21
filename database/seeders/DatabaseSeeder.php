<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SuperAdminSeeder::class,
            SanggarProfileSeeder::class,
            DemoContentSeeder::class,
        ]);
    }
}
