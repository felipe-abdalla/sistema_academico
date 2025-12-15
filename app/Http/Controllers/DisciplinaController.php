<?php

namespace App\Http\Controllers;

use App\Models\Disciplina;
use Illuminate\Http\Request;

class DisciplinaController extends Controller
{
    public function index()
    {
        $disciplinas = Disciplina::all();
        return view('disciplinas.index', compact('disciplinas'));
    }

    public function create()
    {
        return view('disciplinas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|unique:disciplinas,nome',
            'descricao' => 'nullable',
        ]);

        Disciplina::create($request->all());

        return redirect()->route('disciplinas.index');
    }

    public function edit(Disciplina $disciplina)
    {
        return view('disciplinas.edit', compact('disciplina'));
    }

    public function update(Request $request, Disciplina $disciplina)
    {
        $request->validate([
            'nome' => 'required|unique:disciplinas,nome,' . $disciplina->id,
            'descricao' => 'nullable',
        ]);

        $disciplina->update($request->all());

        return redirect()->route('disciplinas.index');
    }

    public function destroy(Disciplina $disciplina)
    {
        $disciplina->delete();
        return redirect()->route('disciplinas.index');
    }
}
