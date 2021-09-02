<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shelter\ShelterType;

class ShelterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShelterType::create([
            'name' => 'Oporavak strogo zaštićenih vrsta iz prirode RH',
            'code' => 'OSZV'
        ]);

        ShelterType::create([
            'name' => 'Zaplijenjene jedinke',
            'code' => 'ZJ'
        ]);
    }
}