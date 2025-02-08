<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogController extends Controller
{
    // Função para adicionar logs manualmente (geralmente chamada ao realizar ações no sistema)
    public static function storeLog($userId, $foliao, $operador, $data)
    {
        // Cria um novo registro de log
        Log::create([
            'id' => $userId,
            'foliao_id' => $foliao,
            'operador_id' => $operador,
            'data_entrega' => $data, // Adicione o IP se necessário
        ]);
    }

}
