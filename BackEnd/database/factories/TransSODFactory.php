<?php

namespace Database\Factories;

use App\Models\MasterMaterial;
use App\Models\TransSOD;
use App\Models\TransSOH;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransSOD>
 */
class TransSODFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /*$SOH = TransSOH::select('*')
            ->where('created_at', '=', now())
            ->get();
        $dataHdr = 0;
        foreach ($SOH as $DataHdr) {
            $data = TransSOD::select('*')
                ->where('tsoh_id', '=', $DataHdr->id)
                ->get();
            if (empty($data)) {
                $dataHdr = $DataHdr->id;
                break;
            }
        }
        Log::info('DataHdr' . $dataHdr);
        error_log('Some message here.');
        error_log('DataHdr' . $dataHdr);*/

        return [
            'tsoh_id' => fake()->randomElement(TransSOH::select('id')->pluck('id')->toarray()),
            'nourut' => 1,
            'material_id' => fake()->randomElement(MasterMaterial::select('id')->pluck('id')->toarray()),
            'qty' => 1,
            'harga' => 500000,
            'disc' => 0,
            'ndisc' => 0,
            'ppn' => 10,
            'nppn' => 50000,
            'total' => 550000,
            'created_at' => NOW(),
        ];
    }
}
