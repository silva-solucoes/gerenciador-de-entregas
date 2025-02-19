<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('estoque_abadas', function (Blueprint $table) {
            $table->id();
            $table->enum('tamanho', ['M', 'G', 'GG']);
            $table->integer('quantidade');
            $table->timestamps();
        });

        // Inserindo os 1.500 abadás iniciais
        DB::table('estoque_abadas')->insert([
            ['tamanho' => 'M', 'quantidade' => 500, 'created_at' => now(), 'updated_at' => now()],
            ['tamanho' => 'G', 'quantidade' => 500, 'created_at' => now(), 'updated_at' => now()],
            ['tamanho' => 'GG', 'quantidade' => 500, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('estoque_abadas');
    }
};
