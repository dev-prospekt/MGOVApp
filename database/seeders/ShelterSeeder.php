<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Generator as Faker;
use App\Models\Shelter\Shelter;
use Illuminate\Database\Seeder;

class ShelterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shelter1 = Shelter::create([
            'name' => 'Aquarium Pula d.o.o.',
            'oib' => 972615522,
            'address' => 'Verudela bb, HR-52100 Pula',
            'address_place' => 'Verudela bb',
            'place_zip' => 52100,
            'shelter_code' => 'AP',
            'telephone' => '0976542347',
            'mobile' => '0976542347',
            'fax' => '0976542347',
            'email' => 'email@test.com',
            'web_address' => 'www.test.com',
            'bank_name' => 'bank name',
            'iban' => '0384648297427498',
            'register_date' => Carbon::now(),
            'shelter_code' => 'AQP'
        ]);
        $shelter1->shelterTypes()->attach([1, 2, 3]);
        $shelter1->animalSystemCategory()->attach([1, 3]);
    }
}
