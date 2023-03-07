<?php

namespace Database\Factories;

use App\Helpers\UniqueCodeHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MasterMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode' => UniqueCodeHelper::generateCustomerCode(),
            'nama' => fake()->name(),
            'email' => fake()->email(),
            'no_hp' => '+62' . fake()->randomElement($array = array('856', '812', '815')) . fake()->randomNumber(8, true), //fake()->e164PhoneNumber(),
            'tgllahir' => fake()->date(),
            'jnskelamin' => fake()->randomElement(['P', 'L']),
            'xpassword' => fake()->lexify('????????'),
            'alamat' => fake()->randomElement($array = ['Jl Kasuari', 'Jl Kenanga', 'Jl Anggrek', 'Jl KS Tubun', 'Jl Hasanudin', 'Jl Tentara Pelajar']),
            'kota' => fake()->randomElement(['Grobogan', 'Depok', 'Kediri', 'Jakarta Barat', 'Jakarta Timur', 'Jakarta Utara', 'Jakarta Selatan',]),
            'provinsi' => fake()->randomElement(['JAWA BARAT', 'JAKARTA', 'JAWA TIMUR', 'JAWA TENGAH']),
            'created_at' => NOW(),

        ];
    }
}
