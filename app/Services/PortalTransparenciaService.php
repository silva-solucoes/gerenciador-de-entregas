<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PortalTransparenciaService
{
    protected $baseUrl = "https://api.portaldatransparencia.gov.br/api-de-dados/pessoa-fisica";
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('PORTAL_TRANSPARENCIA_API_KEY'); // Pegando a chave da API do .env
    }

    /**
     * Consulta dados de uma pessoa física pelo CPF
     *
     * @param string $cpf
     * @return array
     */
    public function consultarPessoaFisica($cpf)
    {
        $response = Http::withHeaders([
            'accept' => '*/*',
            'chave-api-dados' => $this->apiKey,
        ])->get($this->baseUrl, [
            'cpf' => $cpf,
        ]);

        if ($response->failed()) {
            return [
                'error' => 'Erro ao consultar API: ' . $response->body(),
            ];
        }

        return $response->json();
    }
}
