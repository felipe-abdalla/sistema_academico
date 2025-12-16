@extends('layout.app')

@section('content')
<h3>Lançar Nota</h3>

{{-- Exibe erros de validação caso ocorram --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/notas">
    @csrf

    {{-- Seleção de Turma --}}
    <div class="mb-3">
        <label>Turma</label>
        <select name="turma_id" class="form-select" required>
            <option value="">Selecione uma turma...</option>
            @foreach($turmas as $turma)
                {{-- Exibe o nome da turma e da disciplina para facilitar --}}
                <option value="{{ $turma->id }}">
                    {{ $turma->nome }} - {{ $turma->disciplina->nome ?? 'Sem Disciplina' }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Aluno</label>
        <select name="aluno_id" class="form-select" required>
            @foreach($alunos as $aluno)
                <option value="{{ $aluno->id }}">{{ $aluno->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Nota</label>
        <input type="number" name="valor" min="0" max="100" class="form-control" required>
    </div>

    <button class="btn btn-success">Salvar</button>
</form>
@endsection