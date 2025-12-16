<?php

use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('disciplinas', DisciplinaController::class);
    Route::resource('turmas', TurmaController::class);
});

Route::middleware(['auth', 'role:professor'])->group(function () {
    Route::get('/notas/create', [NotaController::class, 'create'])
        ->name('notas.create');

    Route::post('/notas', [NotaController::class, 'store'])
        ->name('notas.store');

    Route::get('/notas/{id}/edit', [NotaController::class, 'edit'])
        ->name('notas.edit');

    Route::put('/notas/{id}', [NotaController::class, 'update'])
        ->name('notas.update');
});

Route::middleware(['auth', 'role:aluno'])->group(function () {
    Route::get('/notas', [NotaController::class, 'indexAluno'])->name('minhas-notas');
});