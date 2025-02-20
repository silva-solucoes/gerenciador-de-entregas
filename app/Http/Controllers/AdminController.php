<?php

namespace App\Http\Controllers;

use App\Models\EstoqueAbada;
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
        // Consulta os estoques por tamanho
        $estoqueM = EstoqueAbada::where('tamanho', 'M')->sum('quantidade');
        $estoqueG = EstoqueAbada::where('tamanho', 'G')->sum('quantidade');
        $estoqueGG = EstoqueAbada::where('tamanho', 'GG')->sum('quantidade');

        return view('admin.index', compact(
            'user',
            'kitsEntregues',
            'totalKitsEntregues',
            'entregasPorDia',
            'estoqueM',
            'estoqueG',
            'estoqueGG'
        ));
    }

    public function atualizar()
    {
        $totalKitsEntregues = LogEntrega::count();
        $estoqueM = EstoqueAbada::where('tamanho', 'M')->sum('quantidade');
        $estoqueG = EstoqueAbada::where('tamanho', 'G')->sum('quantidade');
        $estoqueGG = EstoqueAbada::where('tamanho', 'GG')->sum('quantidade');

        return response()->json([
            'totalKitsEntregues' => $totalKitsEntregues,
            'estoqueM' => $estoqueM,
            'estoqueG' => $estoqueG,
            'estoqueGG' => $estoqueGG,
        ]);
    }

    public function showListaEntregas()
    {
        // Obtém o usuário autenticado
        $user = auth()->user();

        if ($user->role === 'admin') {
            $entregas = LogEntrega::select(
                'logs_entregas.id',
                'users.name as entregador',
                'folioes.nome_completo as foliao',
                'folioes.tamanho',
                'folioes.cpf',
                'logs_entregas.created_at as data_entrega'
            )
                ->join('users', 'logs_entregas.user_id', '=', 'users.id')
                ->join('folioes', 'logs_entregas.foliao_id', '=', 'folioes.id')
                ->orderByDesc('logs_entregas.id')
                ->get();
        } else { // Usuário operador
            $entregas = LogEntrega::select(
                'logs_entregas.id',
                'users.name as entregador',
                'folioes.nome_completo as foliao',
                'folioes.tamanho',
                'folioes.cpf',
                'logs_entregas.created_at as data_entrega'
            )
                ->join('users', 'logs_entregas.user_id', '=', 'users.id')
                ->join('folioes', 'logs_entregas.foliao_id', '=', 'folioes.id')
                ->where('logs_entregas.user_id', $user->id) // Apenas as entregas do operador logado
                ->orderByDesc('logs_entregas.id')
                ->get();
        }

        return view('admin.listarEntregas', compact('entregas'));
    }

    public function exportarEntregasCSV()
    {
        $entregas = LogEntrega::select(
            'logs_entregas.id',
            'users.name as entregador',
            'folioes.nome_completo as foliao',
            'folioes.tamanho',
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
        $tamanhosDisponiveis = EstoqueAbada::where('quantidade', '>', 0)->get();
        return view('admin.addEntrega', compact('tamanhosDisponiveis'));
    }

    public function getTamanhosDisponiveis()
    {
        $tamanhos = EstoqueAbada::where('quantidade', '>', 0)->get();
        return response()->json($tamanhos);
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
            return back()->with('error', '<b>Entrega não autorizada:</b> Este CPF <b>' . $request->cpf . '</b> já recebeu um abadá!');
        }

        // Verifica se há estoque disponível para o tamanho selecionado
        $tamanho = $request->tamanho ?? $request->tamanho_abada;
        $estoque = EstoqueAbada::where('tamanho', $tamanho)->first();

        if (!$estoque || $estoque->quantidade <= 0) {
            return back()->with('error', 'Estoque insuficiente para o tamanho selecionado!');
        }

        DB::beginTransaction();

        try {
            // Busca o folião pelo CPF
            $foliao = Foliao::where('cpf', $cpf)->first();

            if (!$foliao) {
                $foliao = Foliao::create([
                    'nome_completo' => $request->nome_completo,
                    'cpf' => $cpf,
                    'abada_entregue' => $request->quantidade,
                    'tamanho' => $tamanho,
                ]);
            }

            // Registrar entrega do abadá
            $logEntrega = LogEntrega::create([
                'foliao_id' => $foliao->id,
                'user_id' => auth()->id(),
                'tamanho' => $tamanho,
                'created_at' => now(),
            ]);

            // Decrementa o estoque
            $estoque->decrement('quantidade');

            DB::commit();

            return back()->with('success', 'Entrega cadastrada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Registra o erro no log para análise
            Log::error('Erro ao cadastrar entrega: ' . $e->getMessage(), ['exception' => $e]);

            return back()->with('error', 'Erro ao registrar a entrega. Tente novamente.');
        }
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
        // Garantir que role e status tenham valores padrão
        $request->merge([
            'role' => $request->role ?? 'operador',
            'status' => $request->status ?? 'inativo',
        ]);

        // Validação dos campos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:operador,administrador',
            'status' => 'required|in:ativo,inativo',
        ], [
            'name.required' => 'O campo Nome Completo é obrigatório.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'Insira um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'role.required' => 'Selecione um tipo de usuário.',
            'status.required' => 'Selecione um status.',
        ]);

        // Criar usuário com senha padrão
        $user = User::create([
            'name' => strtoupper($request->name),
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

    public function alterarStatus($id)
    {
        $user = User::findOrFail($id);

        // Alterna entre "ativo" e "inativo"
        $user->status = $user->status === 'ativo' ? 'inativo' : 'ativo';
        $user->save();

        return redirect()->back()->with('success', 'Status do usuário atualizado com sucesso!');
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
            'folioes.tamanho',
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
