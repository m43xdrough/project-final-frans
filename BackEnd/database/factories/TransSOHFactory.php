<?php

namespace Database\Factories;

use App\Helpers\UniqueCodeHelper;
use App\Models\TransResep;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Type\Integer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransSOH>
 */
class TransSOHFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'notrans' => UniqueCodeHelper::generateSalesOrderCode(),
            'tgltrans' => now(),
            'resep_id' => fake()->randomElement(TransResep::select('id')->pluck('id')->toarray()),
            'subtotal' => 500000,
            'totdisc' => 0,
            'totppn' => 50000,
            'grandtotal' => 550000,
            'created_at' => NOW(),

        ];
    }
}
