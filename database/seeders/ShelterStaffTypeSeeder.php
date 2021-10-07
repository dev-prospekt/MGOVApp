<?php

namespace Database\Seeders;

use App\Models\Shelter\ShelterStaffType;
use Illuminate\Database\Seeder;

class ShelterStaffTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShelterStaffType::create([
            'name' => 'pravno odgovorna osoba'
        ]);

        ShelterStaffType::create([
            'name' => 'osoba odgovorna za skrb životinja'
        ]);

        ShelterStaffType::create([
            'name' => 'veterinar oporavilišta'
        ]);

        ShelterStaffType::create([
            'name' => 'veterinar - vanjski suradnik'
        ]);
    }
}
