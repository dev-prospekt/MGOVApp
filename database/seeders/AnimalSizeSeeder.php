<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal\AnimalSize;

class AnimalSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = [
            ['value' => 'male <=0,5 kg'],
            ['value' => 'srednje 0,5 do 2 kg'],
            ['value' => 'velike > 2 kg'],
            ['value' => 'male <=0,5 kg'],
            ['value' => 'srednje 0,5 do 2 kg'],
            ['value' => 'velike > 2 kg'],
            ['value' => 'male duljine <=0,5 m'],
            ['value' => 'srednje duljine 0,5 do 1,5 m'],
            ['value' => 'velike duljine preko 1,5 m'],
            ['value' => 'mali (do 99 g)'],
            ['value' => 'srednji (do 1 kg)'],
            ['value' => 'veliki (iznad 1 kg)'],
            ['value' => 'male duljine <= 70 cm'],
            ['value' => 'velike duljine preko 70 cm'],
            ['value' => 'male <=100 g'],
            ['value' => 'srednje 101-399 g'],
            ['value' => 'velike > = 400 g'],
            ['value' => 'male <=30 g'],
            ['value' => 'srednje 31-299 g'],
            ['value' => 'velike > = 300 g'],
            ['value' => 'male do 1 kg'],
            ['value' => 'velike > 1 kg'],
            ['value' => 'male <=1 kg'],
            ['value' => 'velike > 1 kg'],
            ['value' => 'male <=199 g'],
            ['value' => 'srednje 200 g -2 kg'],
            ['value' => 'velike > = 2 kg'],
            ['value' => 'sve veličine'],
            ['value' => 'mali do 100 g'],
            ['value' => 'veliki iznad 100 g'],
            ['value' => 'mali do 1 kg'],
            ['value' => 'srednji od 1 do 5 kg'],
            ['value' => 'veliki od 5 kg do 20 kg'],
            ['value' => 'vrlo veliki iznad 20 kg'],
            ['value' => 'mali do 1 kg'],
            ['value' => 'srednji od 1 kg do 5 kg'],
            ['value' => 'veliki iznad 5 kg'],
            ['value' => 'male <=1 kg'],
            ['value' => 'srednje od 1 do 10 kg'],
            ['value' => 'velike od 10 kg do 50 kg'],
            ['value' => 'vrlo velike iznad 50 kg'],
            ['value' => 'mali do 2 kg'],
            ['value' => 'srednji od 2 do 15 kg'],
            ['value' => 'veliki iznad 20 kg'],
            ['value' => 'svi'],
            ['value' => 'mali do 50 kg'],
            ['value' => 'veliki iznad 50 kg'],
        ];

        foreach ($sizes as $size) {
            AnimalSize::create($size);
        }
    }
}
