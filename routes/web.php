<?php

use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Redirecionamento inicial
Route::redirect('/', '/login');

// --- ROTAS DE AUTENTICAÇÃO (Públicas) ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// --- DASHBOARD (Qualquer usuário logado) ---
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// --- ROTAS DE MATRÍCULA (Admin e Professor) ---
// Estão fora dos grupos de role específica porque ambos podem usar.
// A validação se o professor é dono da turma ocorre dentro do TurmaController.
Route::middleware(['auth'])->group(function () {
    Route::get('/turmas/{turma}/matriculas', [TurmaController::class, 'showMatriculas'])
        ->name('turmas.matriculas');
        
    Route::post('/turmas/{turma}/matriculas', [TurmaController::class, 'storeMatricula'])
        ->name('turmas.matriculas.store');
        
    Route::delete('/turmas/{turma}/matriculas/{aluno}', [TurmaController::class, 'destroyMatricula'])
        ->name('turmas.matriculas.destroy');
});

// --- GRUPO DE ADMINISTRADOR ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    // CRUD completo de Disciplinas e Turmas
    Route::resource('disciplinas', DisciplinaController::class);
    Route::resource('turmas', TurmaController::class);

    // Cadastro de novos usuários (Exclusivo Admin)
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// --- GRUPO DE PROFESSOR ---
Route::middleware(['auth', 'role:professor'])->group(function () {
    // Lançamento e Edição de Notas
    Route::get('/notas/create', [NotaController::class, 'create'])->name('notas.create');
    Route::post('/notas', [NotaController::class, 'store'])->name('notas.store');
    Route::get('/notas/{id}/edit', [NotaController::class, 'edit'])->name('notas.edit');
    Route::put('/notas/{id}', [NotaController::class, 'update'])->name('notas.update');
});

// --- GRUPO DE ALUNO ---
Route::middleware(['auth', 'role:aluno'])->group(function () {
    // Visualização de Notas
    Route::get('/notas', [NotaController::class, 'indexAluno'])->name('minhas-notas');
});