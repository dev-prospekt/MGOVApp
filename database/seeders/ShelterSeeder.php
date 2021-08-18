<?php

namespace Database\Seeders;

use App\Models\Shelter;
use Illuminate\Database\Seeder;

class ShelterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shelter::create([
            'name' => 'Aquarium Pula d.o.o.',
            'address' => 'Verudela bb, HR-52100 Pula',
            'oib' => '00972615522',
            'user_id' => 2,
            'animal_unit_id' => 1
        ]);

        Shelter::create([
            'name' => 'AWAP – Udruga za zaštitu divljih životinja',
            'address' => 'Verudela bb, HR-52100 Pula',
            'oib' => '234235',
            'user_id' => 2,
            'animal_unit_id' => 2
        ]);
    }
}
