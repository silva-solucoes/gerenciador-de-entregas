<?php

namespace App\Http\Controllers;

use App\Models\Foliao;
use App\Models\LogEntrega;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin'); // Middleware para verificar se o usuário é admin
    }

    public function index()
    {
        $user = Auth::user();
        // Consulta os logs de entrega do usuário logado
        $kitsEntregues = LogEntrega::where('user_id', $user->id)->count();
        $totalKitsEntregues = LogEntrega::count();
        $entregasPorDia = LogEntrega::select(DB::raw('DATE(created_at) as data'), DB::raw('COUNT(*) as total'))
            ->groupBy('data')
            ->orderBy('data')
            ->get();

        return view('admin.index', compact('user', 'kitsEntregues', 'totalKitsEntregues', 'entregasPorDia'));
    }

    public function showListaEntregas()
    {
        $entregas = LogEntrega::select(
            'logs_entregas.id',
            'users.name as entregador',
            'folioes.nome_completo as foliao',
            'folioes.cpf',
            'logs_entregas.created_at as data_entrega'
        )
            ->join('users', 'logs_entregas.user_id', '=', 'users.id')
            ->join('folioes', 'logs_entregas.foliao_id', '=', 'folioes.id')
            ->orderByDesc('logs_entregas.id') // Ordenando pelo ID de forma decrescente
            ->paginate(10);

        return view('admin.listarEntregas', compact('entregas'));
    }

    public function showFormEntrega()
    {
        return view('admin.addEntrega');
    }

    public function cadastrarEntrega(Request $request)
    {
        // Remove a formatação do CPF (deixa apenas os números)
        $cpf = preg_replace('/\D/', '', $request->cpf);

        // Verifica se o CPF já recebeu um abadá
        $foliaoJaRecebeu = LogEntrega::whereHas('foliao', function ($query) use ($cpf) {
            $query->where('cpf', $cpf);
        })->exists();

        if ($foliaoJaRecebeu) {
            return back()->with('error', '<b>Entrega não autorizado:</b> Este CPF <b>' . $request->cpf . '</b> já recebeu um abadá!');
        }

        // Busca o folião pelo CPF
        $foliao = Foliao::where('cpf', $cpf)->first();

        // Se o folião não existir, cadastra automaticamente
        if (!$foliao) {
            $foliao = Foliao::create([
                'nome_completo' => $request->nome_completo,
                'cpf' => $cpf, // Armazena o CPF sem formatação
                'abada_entregue' => $request->quantidade,
            ]);
        }

        // Cadastra a entrega do abadá
        LogEntrega::create([
            'foliao_id' => $foliao->id,
            'user_id' => auth()->id(),
            'created_at' => now(),
        ]);

        return back()->with('success', 'Entrega cadastrada com sucesso!');
    }
}
