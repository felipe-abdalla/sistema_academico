<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use App\Models\Disciplina;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- Importação necessária adicionada

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

    // --- GESTÃO DE MATRÍCULAS ---

    public function showMatriculas(Turma $turma)
    {
        // REGRA DE SEGURANÇA:
        // Se for Professor, só pode acessar se a turma for dele.
        // Se for Admin, pode acessar qualquer uma.
        if (Auth::user()->role === 'professor' && $turma->professor_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para gerenciar alunos desta turma.');
        }

        // Busca alunos que NÃO estão nesta turma para preencher o select
        $alunosDisponiveis = User::where('role', 'aluno')
            ->whereDoesntHave('turmasMatriculadas', function($q) use ($turma) {
                $q->where('turma_id', $turma->id);
            })->orderBy('name')->get();

        return view('turmas.matriculas', compact('turma', 'alunosDisponiveis'));
    }

    public function storeMatricula(Request $request, Turma $turma)
    {
        // Segurança
        if (Auth::user()->role === 'professor' && $turma->professor_id !== Auth::id()) {
            abort(403);
        }

        $request->validate(['aluno_id' => 'required|exists:users,id']);
        
        // Verifica se já não está matriculado para evitar duplicação
        // Nota: no código original estava "where('aluno_id'...", para tabelas pivô o padrão costuma ser direto ou via wherePivot,
        // mas em relacionamentos BelongsToMany o eloquent entende o nome da coluna da outra tabela ('users.id') ou pivot se especificado.
        // A forma mais segura usando o model User é verificar se o ID existe na collection ou via query.
        if (!$turma->alunos()->where('users.id', $request->aluno_id)->exists()) {
            $turma->alunos()->attach($request->aluno_id);
            return back()->with('success', 'Aluno matriculado com sucesso!');
        }

        return back()->with('error', 'Aluno já pertence à turma.');
    }

    // Remover aluno da turma
    public function destroyMatricula(Turma $turma, User $aluno)
    {
        // Segurança
        if (Auth::user()->role === 'professor' && $turma->professor_id !== Auth::id()) {
            abort(403);
        }

        $turma->alunos()->detach($aluno->id);

        return back()->with('success', 'Aluno removido da turma.');
    }
}