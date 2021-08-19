<?php

namespace Database\Seeders;

use App\Models\AnimalUnit;
use Illuminate\Database\Seeder;

class AnimalUnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnimalUnit::create([
            'name' => 'ris',
            'latin_name' => 'Lynx lynx',
            'animal_code_id' => 7,
            'shelter_id' => 1
        ]);


        AnimalUnit::create([
            'name' => 'vidra',
            'latin_name' => 'Lutra lutra',
            'animal_code_id' => 10,
            'shelter_id' => 1
        ]);
    }
}
