@extends('layout.app')

@section('content')
<h2>Gerenciar Turmas</h2>

<a href="{{ route('turmas.create') }}" class="btn btn-primary mb-3">Nova Turma</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Turma</th>
            <th>Disciplina</th>
            <th>Professor Responsável</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    @foreach($turmas as $turma)
    <tr>
        <td>{{ $turma->nome }}</td>
        <td>{{ $turma->disciplina->nome ?? 'Sem Disciplina' }}</td>
        <td>{{ $turma->professor->name ?? 'Sem Professor' }}</td>
        <td>
            <a href="{{ route('turmas.edit', $turma) }}" class="btn btn-sm btn-warning">Editar</a>
            <form action="{{ route('turmas.destroy', $turma) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza?');">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Excluir</button>
            </form>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@endsection