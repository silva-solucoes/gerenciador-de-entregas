<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('forgot-password',[AuthController::class, 'showEsqueceuSenha'])->name('esqueceuSenha.show');
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->group(function () {
    // Painel de administração
    Route::get('admin', [AdminController::class, 'index'])->name('admin.index');

    Route::get('admin/listar-entregas', [AdminController::class, 'showListaEntregas'])->name('admin.listaEntregas');

    // Exibir usuários
    Route::get('admin/users', [AdminController::class, 'users'])->name('admin.users');

    //Exibir usuários
    Route::get('admin/users/visualizar', [AdminController::class, 'showListUsers'])->name('admin.listaUsers');

    // Cadastrar Usuário
    Route::get('admin/users/cadastrar', [AdminController::class, 'showFormUsuario'])->name('admin.cadastrarUser');

    // Editar Usuário
    Route::get('admin/users/editar', [AdminController::class, 'showFormEditUsuario'])->name('admin.editarUser');

    //Exibir legislações
    Route::get('admin/laws/visualizar', [AdminController::class, 'showFormLaws'])->name('admin.listLaws');

    //Cadastrar Legislação
    Route::get('admin/laws/cadastrar', [AdminController::class, 'showFormLaws'])->name('admin.cadastrarLegislacao');

    // Exibir logs do sistema
    //Route::get('admin/logs/user', [AdminController::class, 'showLogsUser'])->name('admin.logsUser');
    //Route::get('admin/logs', [AdminController::class, 'logs'])->name('admin.logs');

    // Exibir e editar perfil do administrador
    Route::get('admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('admin/profile', [AdminController::class, 'updateProfile'])->name('admin.updateProfile');

    // Excluir usuário
    Route::delete('admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.destroyUser');
});
