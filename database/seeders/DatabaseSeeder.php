<?php

use Database\Seeders\AnimalCategorySeeder;
use Database\Seeders\AnimalItemSeeder;
use Database\Seeders\AnimalSystemCategorySeeder;
use Illuminate\Database\Seeder;

use Database\Seeders\PermissionsDemoSeeder;
use Database\Seeders\ShelterTypeSeeder;
use Database\Seeders\ShelterUnitSeeder;

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
        $this->call(ShelterUnitSeeder::class);
        $this->call(ShelterTypeSeeder::class);
        $this->call(AnimalSystemCategorySeeder::class);
        $this->call(AnimalCategorySeeder::class);
        $this->call(AnimalItemSeeder::class);
    }
}
