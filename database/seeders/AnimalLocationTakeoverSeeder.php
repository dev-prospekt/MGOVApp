<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal\AnimalLocationTakeover;

class AnimalLocationTakeoverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnimalLocationTakeover::create(['name' => 'U oporavilistu']);
        AnimalLocationTakeover::create(['name' => 'Izvan oporavilista']);
        AnimalLocationTakeover::create(['name' => 'Preuzeli djelatnici oporavilista']);
        AnimalLocationTakeover::create(['name' => 'Preuzela druga sluzba']);
    }
}
