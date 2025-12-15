<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Turma;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotaController extends Controller
{
    // Professor
    public function create()
    {
        $turmas = Turma::where('professor_id', Auth::id())->get();
        $alunos = User::where('role', 'aluno')->get();

        return view('notas.create', compact('turmas', 'alunos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'turma_id' => 'required|exists:turmas,id',
            'aluno_id' => 'required|exists:users,id',
            'valor' => 'required|numeric|min:0|max:100',
        ]);

        Nota::create($request->all());

        return redirect()->back();
    }

    public function edit(Nota $nota)
    {
        return view('notas.edit', compact('nota'));
    }

    public function update(Request $request, Nota $nota)
    {
        $request->validate([
            'valor' => 'required|numeric|min:0|max:100',
        ]);

        $nota->update(['valor' => $request->valor]);

        return redirect()->back();
    }

    // Aluno
    public function indexAluno()
    {
        $notas = Nota::where('aluno_id', Auth::id())
            ->with('turma.disciplina')
            ->get();

        return view('notas.aluno', compact('notas'));
    }
}
