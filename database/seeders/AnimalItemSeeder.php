<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal\AnimalItem;

class AnimalItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $animal1 = AnimalItem::create([
            'animal_category_id' => 1,
            'name' => 'vuk',
            'latin_name' => 'Canis lupus'
        ]);

        $animal1->shelterUnits()->attach([1, 2, 3]);


        $animal2 =  AnimalItem::create([
            'animal_category_id' => 2,
            'name' => 'divlja mačka',
            'latin_name' => 'Felis silvestris'
        ]);

        $animal2->shelterUnits()->attach([1, 2, 3]);


        $animal3 = AnimalItem::create([
            'animal_category_id' => 2,
            'name' => 'ris',
            'latin_name' => 'Lynx lynx'
        ]);

        $animal3->shelterUnits()->attach([1, 2, 3]);

        $animal4 = AnimalItem::create([
            'animal_category_id' => 3,
            'name' => 'vidra',
            'latin_name' => 'Lutra lutra'
        ]);

        $animal4->shelterUnits()->attach([1, 2]);

        $animal5 = AnimalItem::create([
            'animal_category_id' => 3,
            'name' => 'europska vidrica',
            'latin_name' => 'Mustela lutreola'
        ]);

        $animal5->shelterUnits()->attach([1, 3]);

        $animal6 = AnimalItem::create([
            'animal_category_id' => 4,
            'name' => 'sredozemna medvjedica',
            'latin_name' => 'Monachus monachus'
        ]);

        $animal6->shelterUnits()->attach([2, 3]);

        $animal7 = AnimalItem::create([
            'animal_category_id' => 5,
            'name' => 'smeđi medvjed',
            'latin_name' => 'Ursus arctos'
        ]);

        $animal7->shelterUnits()->attach([1, 2]);

        $animal8 = AnimalItem::create([
            'animal_category_id' => 6,
            'name' => 'veliki sjeverni kit',
            'latin_name' => 'Balaenoptera physalus '
        ]);

        $animal8->shelterUnits()->attach([1]);

        $animal9 = AnimalItem::create([
            'animal_category_id' => 7,
            'name' => 'balkanska divokoza',
            'latin_name' => 'Rupicapra rupicapra balcanica'
        ]);

        $animal9->shelterUnits()->attach([1, 2, 3]);

        $animal10 = AnimalItem::create([
            'animal_category_id' => 8,
            'name' => 'obični dupin',
            'latin_name' => 'Delphinus delphis Linnaeus'
        ]);

        $animal10->shelterUnits()->attach([1]);

        $animal11 = AnimalItem::create([
            'animal_category_id' => 8,
            'name' => 'bjelogrli dupin',
            'latin_name' => 'Grampus griseus'
        ]);

        $animal11->shelterUnits()->attach([3]);

        $animal12 = AnimalItem::create([
            'animal_category_id' => 8,
            'name' => 'glavati dupin',
            'latin_name' => 'Grampus griseus'
        ]);

        $animal12->shelterUnits()->attach([1, 2, 3]);
    }
}
