<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal\AnimalItemDocumentationType;

class AnimalItemDocumentationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnimalItemDocumentationType::create([
            'name' => 'iscrpljena/dehidrirana-bez vanjskih ozljeda',
        ]);
        AnimalItemDocumentationType::create([
            'name' => 'ozlijeđena/ranjena',
        ]);
        AnimalItemDocumentationType::create([
            'name' => 'otrovana',
        ]);
        AnimalItemDocumentationType::create([
            'name' => 'bolesna',
        ]);
        AnimalItemDocumentationType::create([
            'name' => 'uginula',
        ]);
        AnimalItemDocumentationType::create([
            'name' => 'ostalo',
        ]);
    }
}
