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

        $animal1->animalCodes()->attach([1, 2, 3]);

        $animal2 =  Animal::create([
            'animal_category_id' => 2,
            'name' => 'divlja mačka',
            'latin_name' => 'Felis silvestris',
        ]);
        
        $animal2->animalCodes()->attach([1, 2, 3]);


        $animal3 = Animal::create([
            'animal_category_id' => 2,
            'name' => 'ris',
            'latin_name' => 'Lynx lynx',
        ]);

        $animal3->animalCodes()->attach([1, 2, 3]);

        $animal4 = Animal::create([
            'animal_category_id' => 3,
            'name' => 'vidra',
            'latin_name' => 'Lutra lutra',
        ]);

        $animal4->animalCodes()->attach([1, 2, 3]);

        $animal5 = Animal::create([
            'animal_category_id' => 3,
            'name' => 'europska vidrica',
            'latin_name' => 'Mustela lutreola',
        ]);

        $animal5->animalCodes()->attach([1, 2, 3]);

        $animal6 = Animal::create([
            'animal_category_id' => 4,
            'name' => 'sredozemna medvjedica',
            'latin_name' => 'Monachus monachus',
        ]);

        $animal6->animalCodes()->attach([1, 2, 3]);

        $animal7 = Animal::create([
            'animal_category_id' => 5,
            'name' => 'smeđi medvjed',
            'latin_name' => 'Ursus arctos',
        ]);

        $animal7->animalCodes()->attach([1, 2, 3]);

        $animal8 = Animal::create([
            'animal_category_id' => 6,
            'name' => 'veliki sjeverni kit',
            'latin_name' => 'Balaenoptera physalus ',
        ]);

        $animal8->animalCodes()->attach([1, 2, 3]);

        $animal9 = Animal::create([
            'animal_category_id' => 7,
            'name' => 'balkanska divokoza',
            'latin_name' => 'Rupicapra rupicapra balcanica',
        ]);

        $animal9->animalCodes()->attach([1, 2, 3]);

        $animal10 = Animal::create([
            'animal_category_id' => 8,
            'name' => 'obični dupin',
            'latin_name' => 'Delphinus delphis Linnaeus',
        ]);

        $animal10->animalCodes()->attach([1, 2, 3]);

        $animal11 = Animal::create([
            'animal_category_id' => 8,
            'name' => 'bjelogrli dupin',
            'latin_name' => 'Grampus griseus',
        ]);

        $animal11->animalCodes()->attach([1, 2, 3]);

        $animal12 = Animal::create([
            'animal_category_id' => 8,
            'name' => 'glavati dupin',
            'latin_name' => 'Grampus griseus',
        ]);

        $animal12->animalCodes()->attach([1, 2, 3]);
    }
}
