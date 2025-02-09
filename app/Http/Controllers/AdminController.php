<?php

namespace App\Http\Controllers;

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
}
