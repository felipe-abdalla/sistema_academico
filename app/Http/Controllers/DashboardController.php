<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Turma;
use App\Models\Nota;
use App\Models\Disciplina;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        switch ($user->role) {
            case 'admin':
                $disciplinas = Disciplina::withCount('turmas')->get();
                $labelsDisc = $disciplinas->pluck('nome');
                $dataDisc = $disciplinas->pluck('turmas_count');

                $usersCounts = User::selectRaw('role, count(*) as total')
                    ->groupBy('role')
                    ->pluck('total', 'role');
                
                return view('dashboard.admin', compact('labelsDisc', 'dataDisc', 'usersCounts'));
            
            case 'professor':
                $turmas = Turma::where('professor_id', $user->id)
                    ->with(['disciplina', 'notas'])
                    ->get();

                $turmaNomes = [];
                $medias = [];

                foreach ($turmas as $turma) {
                    $turmaNomes[] = $turma->nome . ' (' . ($turma->disciplina->nome ?? '-') . ')';
                    $medias[] = $turma->notas->avg('valor') ?? 0;
                }

                return view('dashboard.professor', compact('turmas', 'turmaNomes', 'medias'));

            case 'aluno':
                $notas = Nota::where('aluno_id', $user->id)
                    ->with('turma.disciplina')
                    ->get();
                
                $disciplinasAluno = $notas->map(fn($n) => $n->turma->disciplina->nome);
                $valoresNotas = $notas->pluck('valor');

                return view('dashboard.aluno', compact('notas', 'disciplinasAluno', 'valoresNotas'));

            default:
                abort(403);
        }
    }
}