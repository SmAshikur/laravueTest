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
        $this->call(UserSeeder::class);
        //$this->call(PostSeeder::class);
        $this->call(CatSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(FeatureSeeder::class);
        $this->call(CategoryProductSeeder::class);
    }
}
