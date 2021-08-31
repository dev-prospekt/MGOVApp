<?php

namespace Database\Seeders;

use App\Models\Animal\AnimalCategory;
use Illuminate\Database\Seeder;

class AnimalCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnimalCategory::create([
            'animal_system_category_id' => 1,
            'name' => 'psi',
        ]);

        AnimalCategory::create([
            'animal_system_category_id' => 1,
            'name' => 'mačke',
        ]);

        AnimalCategory::create([
            'animal_system_category_id' => 1,
            'name' => 'kune',
        ]);

        AnimalCategory::create([
            'animal_system_category_id' => 1,
            'name' => 'pravi tuljan',
        ]);

        AnimalCategory::create([
            'animal_system_category_id' => 1,
            'name' => 'medvjedi',
        ]);

        AnimalCategory::create([
            'animal_system_category_id' => 1,
            'name' => 'brazdeni kitovi',
        ]);

        AnimalCategory::create([
            'animal_system_category_id' => 1,
            'name' => 'šupljorošci ',
        ]);

        AnimalCategory::create([
            'animal_system_category_id' => 1,
            'name' => 'oceanski dupini',
        ]);
    }
}
