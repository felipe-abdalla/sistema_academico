@extends('layout.app')

@section('content')
<h3>Editar Turma</h3>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif

<form method="POST" action="{{ route('turmas.update', $turma->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nome da Turma</label>
        <input type="text" name="nome" value="{{ $turma->nome }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Disciplina</label>
        <select name="disciplina_id" class="form-select" required>
            @foreach($disciplinas as $d)
                <option value="{{ $d->id }}" {{ $turma->disciplina_id == $d->id ? 'selected' : '' }}>
                    {{ $d->nome }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Professor Responsável</label>
        <select name="professor_id" class="form-select">
            <option value="">Selecione...</option>
            @foreach($professores as $p)
                <option value="{{ $p->id }}" {{ $turma->professor_id == $p->id ? 'selected' : '' }}>
                    {{ $p->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-primary">Atualizar Turma</button>
    <a href="{{ route('turmas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection