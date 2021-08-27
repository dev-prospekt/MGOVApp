<?php

namespace Database\Factories\Shelter;

use App\Models\User;

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Models\Shelter\ShelterUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShelterUnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShelterUnit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'bank_name' => $this->faker->company,
            'iban' => $this->faker->creditCardNumber,
            'telephone' => $this->faker->e164PhoneNumber,
            'mobile' => $this->faker->e164PhoneNumber,
            'fax' => $this->faker->e164PhoneNumber,
            'web_address' => $this->faker->url,
        ];
    }
}
