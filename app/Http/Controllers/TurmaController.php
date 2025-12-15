<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use App\Models\Disciplina;
use App\Models\User;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    public function index()
    {
        $turmas = Turma::with(['disciplina', 'professor'])->get();
        return view('turmas.index', compact('turmas'));
    }

    public function create()
    {
        $disciplinas = Disciplina::all();
        $professores = User::where('role', 'professor')->get();

        return view('turmas.create', compact('disciplinas', 'professores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'disciplina_id' => 'required|exists:disciplinas,id',
            'professor_id' => 'nullable|exists:users,id',
        ]);

        Turma::create($request->all());

        return redirect()->route('turmas.index');
    }

    public function edit(Turma $turma)
    {
        $disciplinas = Disciplina::all();
        $professores = User::where('role', 'professor')->get();

        return view('turmas.edit', compact('turma', 'disciplinas', 'professores'));
    }

    public function update(Request $request, Turma $turma)
    {
        $request->validate([
            'nome' => 'required',
            'disciplina_id' => 'required|exists:disciplinas,id',
            'professor_id' => 'nullable|exists:users,id',
        ]);

        $turma->update($request->all());

        return redirect()->route('turmas.index');
    }

    public function destroy(Turma $turma)
    {
        $turma->delete();
        return redirect()->route('turmas.index');
    }
}
