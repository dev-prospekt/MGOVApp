<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal\Animal;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $animal1 = Animal::create([
            'animal_category_id' => 1,
            'name' => 'vuk',
            'latin_name' => 'Canis lupus',
        ]);

        $animal2 =  Animal::create([
            'animal_category_id' => 2,
            'name' => 'divlja mačka',
            'latin_name' => 'Felis silvestris',
        ]);

        $animal3 = Animal::create([
            'animal_category_id' => 2,
            'name' => 'ris',
            'latin_name' => 'Lynx lynx',
        ]);

        $animal4 = Animal::create([
            'animal_category_id' => 3,
            'name' => 'vidra',
            'latin_name' => 'Lutra lutra',
        ]);

        $animal5 = Animal::create([
            'animal_category_id' => 3,
            'name' => 'europska vidrica',
            'latin_name' => 'Mustela lutreola',
        ]);

        $animal6 = Animal::create([
            'animal_category_id' => 4,
            'name' => 'sredozemna medvjedica',
            'latin_name' => 'Monachus monachus',
        ]);

        $animal7 = Animal::create([
            'animal_category_id' => 5,
            'name' => 'smeđi medvjed',
            'latin_name' => 'Ursus arctos',
        ]);

        $animal8 = Animal::create([
            'animal_category_id' => 6,
            'name' => 'veliki sjeverni kit',
            'latin_name' => 'Balaenoptera physalus ',
        ]);

        $animal9 = Animal::create([
            'animal_category_id' => 7,
            'name' => 'balkanska divokoza',
            'latin_name' => 'Rupicapra rupicapra balcanica',
        ]);

        $animal10 = Animal::create([
            'animal_category_id' => 8,
            'name' => 'obični dupin',
            'latin_name' => 'Delphinus delphis Linnaeus',
        ]);

        $animal11 = Animal::create([
            'animal_category_id' => 8,
            'name' => 'bjelogrli dupin',
            'latin_name' => 'Grampus griseus',
        ]);

        $animal12 = Animal::create([
            'animal_category_id' => 8,
            'name' => 'glavati dupin',
            'latin_name' => 'Grampus griseus',
        ]);
    }
}
