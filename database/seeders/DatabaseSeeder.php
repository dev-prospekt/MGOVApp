<?php

use App\Models\AnimalShelterData;
use Illuminate\Database\Seeder;
use Database\Seeders\AnimalCodesSeeder;
use Database\Seeders\AnimalUnitsSeeder;
use Database\Seeders\PermissionsDemoSeeder;
use Database\Seeders\ShelterSeeder;

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
        $this->call(AnimalShelterData::class);


        // DB::table('users')->insert([
        //     'name' => 'Pero',
        //     'email' => 'pero@gmail.com',
        //     'password' => Hash::make('Pero123'),
        // ]);
    }
}
