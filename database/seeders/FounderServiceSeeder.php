<?php

namespace Database\Seeders;

use App\Models\FounderService;
use Illuminate\Database\Seeder;

class FounderServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FounderService::create(['name' => 'Državni inspektorat-inspekcija zaštite prirode']);
        FounderService::create(['name' => 'Državni inspektorat-veterinarska inspekcija']);
        FounderService::create(['name' => 'Ministarstvo unutarnjih poslova']);
        FounderService::create(['name' => 'Ministarstvo financija, Carinska uprava']);
        FounderService::create(['name' => 'fizička/pravna osoba']);
        FounderService::create(['name' => 'komunalna služba-lokalna i regionalna samouprava']);
        FounderService::create(['name' => 'nepoznato']);
        FounderService::create(['name' => 'djelatnici Javnih ustanova NP/PP ili županija']);
        FounderService::create(['name' => 'vlasnik životinje']);
        FounderService::create(['name' => 'ostalo-navesti:']);
    }
}
