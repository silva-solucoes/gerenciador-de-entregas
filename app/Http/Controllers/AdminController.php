<?php

namespace App\Http\Controllers;

use App\Models\Foliao;
use App\Models\LogEntrega;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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

    public function exportarEntregasCSV()
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
            ->orderByDesc('logs_entregas.id')
            ->get();

        $fileName = 'entregas_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($entregas) {
            $file = fopen('php://output', 'w');

            // Cabeçalho do CSV
            fputcsv($file, ['ID', 'Entregador', 'Folião', 'CPF', 'Data da Entrega']);

            // Adiciona os dados
            foreach ($entregas as $entrega) {
                fputcsv($file, [
                    $entrega->id,
                    $entrega->entregador,
                    $entrega->foliao,
                    $entrega->cpf,
                    $entrega->data_entrega
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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

    public function showListUsers()
    {
        $usuarios = User::all(); // Busca todos os usuários
        return view('admin.gerenciarUsuarios.listaUser', ['user' => Auth::user(), 'usuarios' => $usuarios]);
    }

    public function showFormUsuario()
    {
        return view('admin.gerenciarUsuarios.addUser', ['user' => Auth::user()]);
    }

    public function cadastrarUser(Request $request)
    {
        // Validação dos campos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:operador,administrador',
            'status' => 'required|in:ativo,inativo',
        ]);

        // Criar usuário com senha padrão
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('Carnaval@2025'), // Senha padrão
            'role' => $request->role ?? 'operador', // Padrão: Operador
            'status' => $request->status ?? 'inativo', // Padrão: Inativo
        ]);

        return redirect()->route('admin.cadastrarUser')
            ->with('success', 'Usuário cadastrado com sucesso!');
    }


    public function showFormEditUsuario($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        $user = User::findOrFail($id);
        return view('admin.gerenciarUsuarios.editUser', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Atualiza os campos, mas só criptografa a senha se ela for informada
        $data = $request->only(['name', 'email', 'role', 'status']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.editarUser', encrypt($user->id))
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function showRelatorio()
    {
        $operadores = User::where('role', 'operador')->get();
        return view('admin.reportPerson', compact('operadores'));
    }

    public function gerarRelatorioEntregas()
    {
        // Buscar todas as entregas
        $entregas = LogEntrega::select(
            'logs_entregas.id',
            'folioes.nome_completo as foliao',
            'folioes.cpf',
            'folioes.abada_entregue as quantidade_kit',
            'users.name as operador',
            'logs_entregas.created_at as data_entrega'
        )
            ->join('users', 'logs_entregas.user_id', '=', 'users.id')
            ->join('folioes', 'logs_entregas.foliao_id', '=', 'folioes.id')
            ->orderBy('logs_entregas.id', 'asc')
            ->get();

        // Contagem total de entregas
        $totalEntregas = $entregas->count();

        // Formatar CPF para exibição segura
        foreach ($entregas as $entrega) {
            $entrega->cpf = '##' . substr($entrega->cpf, 2, 1) . '.' . substr($entrega->cpf, 3, 3) . '.' . substr($entrega->cpf, 6, 3) . '-##';
            $entrega->foliao = strtoupper($entrega->foliao);
        }

        // Criar PDF
        $pdf = PDF::loadView('admin.relatorios.entregas', compact('entregas', 'totalEntregas'))
         ->setPaper('A4', 'portrait')
         ->setOption('footer-right', 'Página [page] de [topage]');

        $nomeArquivo = 'Relatorio_Entregas_Abadas_' . Carbon::now()->format('d-m-Y_H-i-s') . '.pdf';
        // Retornar PDF para visualização no navegador
        return $pdf->stream($nomeArquivo);
    }
}
