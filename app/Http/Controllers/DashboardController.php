<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        return match ($user->role) {
            'admin' => redirect()->route('disciplinas.index'),
            'professor' => redirect()->route('notas.create'),
            'aluno' => redirect()->route('minhas-notas'),
            default => abort(403),
        };
    }
}
