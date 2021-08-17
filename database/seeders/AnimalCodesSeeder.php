<?php

namespace Database\Seeders;

use App\Models\AnimalCode;
use Illuminate\Database\Seeder;

class AnimalCodesSeeder extends Seeder
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
        ];
        foreach ($codes as $code) {
            AnimalCode::create($code);
        }
    }
}
