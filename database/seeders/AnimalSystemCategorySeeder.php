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
            'name' => 'sisavci'
        ]);

        AnimalSystemCategory::create([
            'name' => 'ptice'
        ]);

        AnimalSystemCategory::create([
            'name' => 'gmazovi'
        ]);

        AnimalSystemCategory::create([
            'name' => 'vodozemci'
        ]);
    }
}
