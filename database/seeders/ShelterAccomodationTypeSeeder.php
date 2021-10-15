<?php

namespace Database\Seeders;

use App\Models\Shelter\ShelterAccomodationType;
use Illuminate\Database\Seeder;

class ShelterAccomodationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShelterAccomodationType::create([
            'name' => 'Kavez',
            'type' => 'nastamba-kavez'
        ]);

        ShelterAccomodationType::create([
            'name' => 'Boks',
            'type' => 'nastamba-boks'
        ]);

        ShelterAccomodationType::create([
            'name' => 'Letnica',
            'type' => 'nastamba-letnica'
        ]);

        ShelterAccomodationType::create([
            'name' => 'Terarij',
            'type' => 'nastamba-terarij'
        ]);

        ShelterAccomodationType::create([
            'name' => 'Akvarij',
            'type' => 'nastamba-akvarij'
        ]);

        ShelterAccomodationType::create([
            'name' => 'Bazen',
            'type' => 'nastamba-bazen'
        ]);

        ShelterAccomodationType::create([
            'name' => 'Prostor',
            'type' => 'prostor-skrb, intenzivno liječenje'
        ]);

        ShelterAccomodationType::create([
            'name' => 'Prostor',
            'type' => 'prostor-povratak u prirodu, samostalni život'
        ]);

        ShelterAccomodationType::create([
            'name' => 'Prostor',
            'type' => 'prostor-mjere za sprječavanje uznemiravanja'
        ]);

        ShelterAccomodationType::create([
            'name' => 'Prostor',
            'type' => 'prostor-priprema za povratak u prirodu'
        ]);

        ShelterAccomodationType::create([
            'name' => 'Prostor',
            'type' => 'prostor-odvajanje, označavanje zaplijenjenih životinja'
        ]);
    }
}
