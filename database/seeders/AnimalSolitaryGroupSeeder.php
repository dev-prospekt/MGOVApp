<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal\AnimalSolitaryGroup;

class AnimalSolitaryGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnimalSolitaryGroup::create(['name' => 'Solitarno']);
        AnimalSolitaryGroup::create(['name' => 'Grupa']);
    }
}
