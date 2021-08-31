<?php

use Illuminate\Database\Seeder;
use Database\Seeders\AnimalSeeder;
use Database\Seeders\ShelterTypeSeeder;
use Database\Seeders\ShelterSeeder;

use Database\Seeders\AnimalCategorySeeder;
use Database\Seeders\AnimalCodeSeeder;
use Database\Seeders\PermissionsDemoSeeder;
use Database\Seeders\AnimalSystemCategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(PermissionsDemoSeeder::class);
        $this->call(ShelterSeeder::class);
        $this->call(ShelterTypeSeeder::class);
        $this->call(AnimalSystemCategorySeeder::class);
        $this->call(AnimalCategorySeeder::class);
        $this->call(AnimalSeeder::class);
        $this->call(AnimalCodeSeeder::class);
    }
}
