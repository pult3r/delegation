<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DelegationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'userid' => md5( time() ),
            'startdatetime' => $this->faker->dateTime() ,
            'enddatetime' => $this->faker->dateTime() ,
            'countrycode'=> $this->faker->randomDigitNotNull
        ];
    }
}
