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
            'name' => 'sisavci',
            'latin_name' => 'Mammalia'
        ]);

        AnimalSystemCategory::create([
            'name' => 'ptice',
            'latin_name' => 'Aves'
        ]);

        AnimalSystemCategory::create([
            'name' => 'gmazovi',
            'latin_name' => 'Reptilia'
        ]);

        AnimalSystemCategory::create([
            'name' => 'vodozemci',
            'latin_name' => 'Amphibia'
        ]);

        AnimalSystemCategory::create([
            'name' => 'ribe',
            'latin_name' => 'Pisces'
        ]);
    }
}
