<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal\ItemDocumentationStateType;
use App\Models\Animal\AnimalItemDocumentationStateType;

class AnimalItemDocumentationStateTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnimalItemDocumentationStateType::create(['name' => 'iscrpljena/dehidrirana-bez vanjskih ozljeda']);
        AnimalItemDocumentationStateType::create(['name' => 'ozlijeđena/ranjena']);
        AnimalItemDocumentationStateType::create(['name' => 'otrovana']);
        AnimalItemDocumentationStateType::create(['name' => 'bolesna']);
        AnimalItemDocumentationStateType::create(['name' => 'uginula']);
        AnimalItemDocumentationStateType::create(['name' => 'ostalo']);
    }
}
