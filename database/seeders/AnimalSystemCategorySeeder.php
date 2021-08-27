<?php

namespace Database\Seeders;

use App\Models\Animal\AnimalSystemCategory;
use Illuminate\Database\Seeder;

class AnimalSystemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnimalSystemCategory::create([
            'shelter_unit_id' => 1,
            'name' => 'sisavci'
        ]);

        AnimalSystemCategory::create([
            'shelter_unit_id' => 1,
            'name' => 'ptice'
        ]);

        AnimalSystemCategory::create([
            'shelter_unit_id' => 1,
            'name' => 'gmazovi'
        ]);

        AnimalSystemCategory::create([
            'shelter_unit_id' => 1,
            'name' => 'vodozemci'
        ]);
    }
}
