<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PortalTransparenciaService;

class PortalTransparenciaController extends Controller
{
    protected $portalService;

    public function __construct(PortalTransparenciaService $portalService)
    {
        $this->portalService = $portalService;
    }

    public function index()
    {
        return view('welcome');
    }

    public function buscarPessoa(Request $request)
    {
        $request->validate([
            'cpf' => 'required|string|digits:11', // Valida CPF com 11 dígitos
        ]);

        $cpf = $request->input('cpf');
        $dadosPessoa = $this->portalService->consultarPessoaFisica($cpf);

        return view('welcome', compact('dadosPessoa'));
    }

    public function buscarNome($cpf)
    {
        $dados = $this->portalService->consultarPessoaFisica($cpf);

        if (isset($dados['nome'])) {
            return response()->json(['nome' => $dados['nome']]);
        }

        return response()->json(['error' => 'Nome não encontrado'], 404);
    }
}
