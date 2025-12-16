<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Turma;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotaController extends Controller
{
   public function create(Request $request)
    {
        // 1. Busca turmas do professor logado
        $turmas = Turma::where('professor_id', Auth::id())->with('disciplina')->get();

        $alunos = [];
        $turmaSelecionada = null;

        // 2. Se uma turma foi selecionada na tela, busca os alunos DELA
        if ($request->has('turma_id')) {
            $turmaSelecionada = Turma::where('id', $request->turma_id)
                ->where('professor_id', Auth::id()) // Segurança: garante que é dele
                ->first();

            if ($turmaSelecionada) {
                // Pega apenas alunos matriculados (usando o relacionamento do Passo 1)
                $alunos = $turmaSelecionada->alunos; 
            }
        }

        return view('notas.create', compact('turmas', 'alunos', 'turmaSelecionada'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'turma_id' => 'required|exists:turmas,id',
            'aluno_id' => 'required|exists:users,id',
            'valor'    => 'required|numeric|min:0|max:100',
        ]);

        // Validação Extra de Segurança
        $turma = Turma::findOrFail($request->turma_id);
        
        // Verifica se professor é dono da turma
        if ($turma->professor_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado a esta turma.');
        }

        // Verifica se aluno realmente pertence à turma (Regra Sofisticada)
        if (!$turma->alunos()->where('users.id', $request->aluno_id)->exists()) {
            return back()->withErrors(['aluno_id' => 'Este aluno não está matriculado nesta turma.']);
        }

        Nota::create($request->all());

        // Redireciona mantendo a turma selecionada para facilitar lançamentos em sequência
        return redirect()
            ->route('notas.create', ['turma_id' => $request->turma_id])
            ->with('success', 'Nota lançada com sucesso!');
    }

    public function edit(Nota $nota)
    {
        // Garante que o professor só edite notas das SUAS turmas
        if ($nota->turma->professor_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado');
        }
        return view('notas.edit', compact('nota'));
    }

    public function update(Request $request, Nota $nota)
    {
        // Garante que o professor só atualize notas das SUAS turmas
        if ($nota->turma->professor_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'valor' => 'required|numeric|min:0|max:100',
        ]);

        $nota->update(['valor' => $request->valor]);

        return redirect()->route('dashboard')->with('success', 'Nota atualizada!');
    }

    // Aluno (Mantido igual)
    public function indexAluno()
    {
        $notas = Nota::where('aluno_id', Auth::id())
            ->with('turma.disciplina')
            ->get();

        return view('notas.aluno', compact('notas'));
    }
}