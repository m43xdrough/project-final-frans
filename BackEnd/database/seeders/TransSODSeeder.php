<?php

namespace Database\Seeders;

use App\Models\TransSOD;
use App\Models\TransSOH;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class TransSODSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            \App\Models\TransSOD::factory(1)->create();
        }
    }
}
