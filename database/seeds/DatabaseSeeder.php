<?php

use Illuminate\Database\Seeder;
use App\Models\AnimalShelterData;
use Database\Seeders\ShelterSeeder;
use Database\Seeders\AnimalCodesSeeder;
use Database\Seeders\AnimalUnitsSeeder;
use Database\Seeders\PermissionsDemoSeeder;
use Database\Seeders\AnimalShelterDataSeeder;

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
        $this->call(AnimalCodesSeeder::class);
        $this->call(AnimalUnitsSeeder::class);
        $this->call(AnimalShelterDataSeeder::class);


        // DB::table('users')->insert([
        //     'name' => 'Pero',
        //     'email' => 'pero@gmail.com',
        //     'password' => Hash::make('Pero123'),
        // ]);
    }
}
