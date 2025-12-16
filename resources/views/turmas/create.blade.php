@extends('layout.app')

@section('content')
<h3>Nova Turma</h3>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif

<form method="POST" action="/turmas">
    @csrf

    <div class="mb-3">
        <label>Nome da Turma (Ex: 3º Ano A)</label>
        <input type="text" name="nome" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Disciplina</label>
        <select name="disciplina_id" class="form-select" required>
            <option value="">Selecione...</option>
            @foreach($disciplinas as $d)
                <option value="{{ $d->id }}">{{ $d->nome }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Professor Responsável</label>
        <select name="professor_id" class="form-select">
            <option value="">Selecione...</option>
            @foreach($professores as $p)
                <option value="{{ $p->id }}">{{ $p->name }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-success">Salvar Turma</button>
</form>
@endsection