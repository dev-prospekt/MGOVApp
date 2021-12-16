<?php

namespace Database\Seeders;

use App\Models\Animal\AnimalItemCareEndType;
use Illuminate\Database\Seeder;

class AnimalItemCareEndTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnimalItemCareEndType::create(['name' => 'Puštanje nazad u prirodu']);
        AnimalItemCareEndType::create(['name' => 'Trajni boravak izvan oporavilišta']);
        AnimalItemCareEndType::create(['name' => 'Usmrćivanje']);
        AnimalItemCareEndType::create(['name' => 'Ostalo']);
    }
}
