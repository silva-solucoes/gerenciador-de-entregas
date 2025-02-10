<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PortalTransparenciaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;

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

Route::get('/', [Controller::class, 'index']);
Route::get('/portal-pessoa', [PortalTransparenciaController::class, 'index'])->name('portal.index');
Route::post('/portal-pessoa/buscar', [PortalTransparenciaController::class, 'buscarPessoa'])->name('portal.buscar');

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

    Route::get('admin/cadastar-entrega', [AdminController::class, 'showFormEntrega'])->name('admin.cadastrarEntrega');

    Route::get('/buscar-nome/{cpf}', [PortalTransparenciaController::class, 'buscarNome']);

    Route::post('/admin/submeter-entrega', [AdminController::class, 'cadastrarEntrega'])->name('entregas.store');
    // Exibir usuários
    Route::get('admin/users', [AdminController::class, 'users'])->name('admin.users');

    //Exibir usuários
    Route::get('admin/users/visualizar', [AdminController::class, 'showListUsers'])->name('admin.listaUsers');

    // Cadastrar Usuário
    Route::get('admin/users/cadastrar', [AdminController::class, 'showFormUsuario'])->name('admin.cadastrarUser');

    Route::post('/admin/users/novo-usuario', [AdminController::class, 'cadastrarUser'])->name('admin.novoUser');

    // Editar Usuário
    Route::get('admin/users/editar/{encryptedId}', [AdminController::class, 'showFormEditUsuario'])
    ->name('admin.editarUser');

    Route::put('/admin/users/update/{id}', [AdminController::class, 'updateUser'])->name('admin.updateUser');

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

    Route::get('/admin/entregas/exportar', [AdminController::class, 'exportarEntregasCSV'])->name('exportarEntregas');

    Route::get('admin/relatorio/personalizado', [AdminController::class, 'showRelatorio'])->name('admin.showRelatorio');

    Route::get('/admin/relatorio-entregas', [AdminController::class, 'gerarRelatorioEntregas'])
    ->name('admin.relatorio.entregas');

    Route::get('/testar-view', function () {
        return view('admin.relatorios.entregas');
    });

});
