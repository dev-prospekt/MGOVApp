<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal\AnimalDob;

class AnimalDobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnimalDob::create(['name' => 'M(mužjak)']);
        AnimalDob::create(['name' => 'Ž/F(ženka)']);
        AnimalDob::create(['name' => 'N(nije moguće odrediti)']);
    }
}
