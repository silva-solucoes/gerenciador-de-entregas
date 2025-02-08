<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // Exemplo de inicialização de $lawCount

        return view('admin.index', ['user' => Auth::user()]);
    }
}
