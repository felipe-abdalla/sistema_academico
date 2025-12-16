@extends('layout.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gerenciar Alunos - {{ $turma->nome }}</h2>
        <a href="{{ auth()->user()->role === 'admin' ? route('turmas.index') : route('dashboard') }}" class="btn btn-secondary">
            Voltar
        </a>
    </div>

    <div class="row">
        {{-- COLUNA 1: Adicionar Novo Aluno --}}
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    Matricular Novo Aluno
                </div>
                <div class="card-body">
                    <form action="{{ route('turmas.matriculas.store', $turma->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Selecione o Aluno:</label>
                            <select name="aluno_id" class="form-select" required>
                                <option value="">Selecione...</option>
                                @foreach($alunosDisponiveis as $aluno)
                                    <option value="{{ $aluno->id }}">{{ $aluno->name }} ({{ $aluno->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Adicionar à Turma</button>
                    </form>
                    
                    @if($alunosDisponiveis->isEmpty())
                        <small class="text-muted mt-2 d-block text-center">Todos os alunos do sistema já estão nesta turma.</small>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body bg-light">
                    <h6>Informações da Turma</h6>
                    <p class="mb-1"><strong>Disciplina:</strong> {{ $turma->disciplina->nome ?? 'N/A' }}</p>
                    <p class="mb-0"><strong>Professor:</strong> {{ $turma->professor->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        {{-- COLUNA 2: Lista de Alunos Matriculados --}}
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    Alunos Matriculados ({{ $turma->alunos->count() }})
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($turma->alunos as $aluno)
                            <tr>
                                <td>{{ $aluno->name }}</td>
                                <td>{{ $aluno->email }}</td>
                                <td class="text-end">
                                    <form action="{{ route('turmas.matriculas.destroy', ['turma' => $turma->id, 'aluno' => $aluno->id]) }}" method="POST" onsubmit="return confirm('Remover este aluno da turma?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Remover</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">Nenhum aluno matriculado nesta turma.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection