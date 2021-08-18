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
        $animals = [
            '0' => [
                'name' => 'ris',
                'latin-name' => 'Lynx lynx',
                'animal_code_id' => 7

            ],
            '1' => [
                'name' => 'vidra',
                'latin-name' => 'Lutra lutra',
                'animal_code_id' => 10
            ]
        ];

        foreach ($animals as $key => $value) {
            AnimalUnit::create($value);
        }
    }
}
