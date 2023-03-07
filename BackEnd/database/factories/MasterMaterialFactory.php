<?php

namespace Database\Factories;

use App\Helpers\UniqueCodeHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MasterMaterial>
 */
class MasterMaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kdbarang' => UniqueCodeHelper::generateMaterialCode(), //'13000' . fake()->randomNumber(8, true),
            'namabarang' => 'SV' . ' ' . fake()->randomElement(['ILL', 'VIS', 'SP']) . ' ' . fake()->randomElement(['1.5', '1.56', '1.6']) . ' ' . fake()->randomElement(['-00.00', '-00.25', '-00.50', '-00.75', '-01.00']) . ' ' . fake()->randomElement(['-00.00', '-00.25', '-00.50', '-00.75', '-01.00']),
            'harga' => fake()->randomElement([195000, 400000, 500000]),
            'created_at' => NOW(),

        ];
    }
}
