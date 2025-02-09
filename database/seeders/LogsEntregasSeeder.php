<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LogsEntregasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('logs_entregas')->insert([
            [
                'foliao_id' => 1, // ID do folião (exemplo)
                'user_id' => 2, // ID do operador (exemplo)
                'data_entrega' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'foliao_id' => 2,
                'user_id' => 2,
                'data_entrega' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
