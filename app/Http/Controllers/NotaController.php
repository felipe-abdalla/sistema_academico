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

        // Validação de Segurança (Professor dono da turma / Aluno matriculado)
        $turma = Turma::findOrFail($request->turma_id);
        
        if ($turma->professor_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado a esta turma.');
        }

        if (!$turma->alunos()->where('users.id', $request->aluno_id)->exists()) {
            return back()->withErrors(['aluno_id' => 'Este aluno não está matriculado nesta turma.']);
        }

        // --- LÓGICA DE SOMA DE NOTAS ---
        
        // 1. Tenta encontrar uma nota existente para este aluno nesta turma
        $notaExistente = Nota::where('turma_id', $request->turma_id)
                             ->where('aluno_id', $request->aluno_id)
                             ->first();

        if ($notaExistente) {
            // CENÁRIO A: Nota já existe, vamos somar
            $novoTotal = $notaExistente->valor + $request->valor;

            // Opcional: Impedir que a soma ultrapasse 100
            if ($novoTotal > 100) {
                return back()->withErrors(['valor' => "A soma das notas ({$notaExistente->valor} + {$request->valor}) ultrapassa o limite de 100."]);
            }

            $notaExistente->update([
                'valor' => $novoTotal,
                // Concatena o histórico: "10 + 20" vira "10 + 20 + 5"
                'historico' => $notaExistente->historico . ' + ' . $request->valor
            ]);

            $mensagem = 'Nota adicionada ao total existente!';
        } else {
            // CENÁRIO B: Primeira nota nesta turma
            Nota::create([
                'turma_id' => $request->turma_id,
                'aluno_id' => $request->aluno_id,
                'valor'    => $request->valor,
                'historico' => (string) $request->valor // O histórico inicial é o próprio valor
            ]);

            $mensagem = 'Primeira nota lançada com sucesso!';
        }

        return redirect()
            ->route('notas.create', ['turma_id' => $request->turma_id])
            ->with('success', $mensagem);
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