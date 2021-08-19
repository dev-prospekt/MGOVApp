<?php

namespace Database\Seeders;

use App\Models\AnimalShelterData;
use Illuminate\Database\Seeder;

class AnimalShelterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnimalShelterData::create([
            'location' => 'Verudela Brijeg',
            'found_desc' => 'Nađena životinja u šmumi nakon dojave',
            'animal_unit_id' => 1,
            'shelter_id' => 1
        ]);

        AnimalShelterData::create([
            'location' => 'Verudela lokacija 2',
            'found_desc' => 'Dostavljena životinja',
            'animal_unit_id' => 2,
            'shelter_id' => 2
        ]);
    }
}
