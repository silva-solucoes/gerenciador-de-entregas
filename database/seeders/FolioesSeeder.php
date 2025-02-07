<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FolioesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('folioes')->insert([
            [
                'nome_completo' => 'Carlos da Silva',
                'cpf' => '12345678901',
                'abadá_entregue' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome_completo' => 'Mariana Souza',
                'cpf' => '98765432100',
                'abadá_entregue' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
