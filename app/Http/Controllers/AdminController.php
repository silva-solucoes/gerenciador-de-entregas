<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin'); // Middleware para verificar se o usuário é admin
    }

    public function index()
    {
        // Exemplo de inicialização de $lawCount
        $userCount = User::orderBy('created_at', 'desc')->get();
        $logsCount = Log::count();

        $recentLogs = Log::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', ['user' => Auth::user()], compact('userCount', 'logsCount', 'cont', 'recentLogs'));
    }
}
