<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal\AnimalCode;

class AnimalCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $codes = [
            ['name' => 'DP'],
            ['name' => 'DS4'],
            ['name' => 'BA2'],
            ['name' => 'BE1'],
            ['name' => 'BE2'],
            ['name' => 'BO1'],
            ['name' => 'CR'],
            ['name' => 'EN'],
            ['name' => 'VU'],
            ['name' => 'DD'],
        ];

        foreach ($codes as $code) {
            AnimalCode::create($code);
        }
    }
}
