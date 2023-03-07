<?php

namespace Database\Factories;

use App\Helpers\UniqueCodeHelper;
use App\Models\MasterMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransResep>
 */
class TransResepFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //dd(MasterMember::select('id')->pluck('id')->toarray());
        return [
            'noresep' => UniqueCodeHelper::generateReceiptCode(),
            'tglresep' => now(),
            'member_id' => fake()->randomElement(MasterMember::select('id')->pluck('id')->toarray()),
            'chspherisr' => fake()->randomElement(['-00.00', '-00.25', '-00.50', '-00.75', '-01.00']),
            'chspherisl' => fake()->randomElement(['-00.00', '-00.25', '-00.50', '-00.75', '-01.00']),
            'chcylinderr' => fake()->randomElement(['-00.00', '-00.25', '-00.50', '-00.75', '-01.00']),
            'chcylinderl' => fake()->randomElement(['-00.00', '-00.25', '-00.50', '-00.75', '-01.00']),
            'chadditionr' => fake()->randomElement(['', '00.00', '00.25', '00.50', '00.75', '01.00']),
            'chadditionl' => fake()->randomElement(['', '00.00', '00.25', '00.50', '00.75', '01.00']),
            'chaxisr' => fake()->randomElement(['0', '150', '115', '170', '180']),
            'chaxisl' => fake()->randomElement(['0', '150', '115', '170', '180']),
            'created_at' => NOW(),

        ];
    }
}
