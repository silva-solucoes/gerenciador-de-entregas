<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PortalTransparenciaService
{
    protected $baseUrl = "https://api.portaldatransparencia.gov.br/api-de-dados/contratos";
    protected $apiKey = "a967053c73f5e8f49578ee26c3502596"; // Substitua pela sua chave de API

    public function obterContratos($codigoOrgao, $dataInicial)
    {
        $pagina = 1;
        $dados = [];

        do {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'chave-api-dados' => $this->apiKey
            ])->get($this->baseUrl, [
                'codigoOrgao' => $codigoOrgao,
                'quantidade' => 100,
                'dataInicial' => $dataInicial,
                'pagina' => $pagina
            ]);

            if ($response->failed()) {
                return ['error' => 'Erro ao acessar a API.'];
            }

            $data = $response->json();

            if (empty($data)) {
                break;
            }

            $dados = array_merge($dados, $data);
            $pagina++;

        } while (!empty($data));

        return $dados;
    }
}
