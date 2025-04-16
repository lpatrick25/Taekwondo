<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RegionsTableSeeder::class);
        $this->call(ProvincesTableSeeder::class);
        $this->call(MunicipalitiesTableSeeder::class);
        $this->call(BrgysTableSeeder::class);
        $this->call(AdminUserSeeder::class);
    }
}
