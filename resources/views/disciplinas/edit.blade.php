@extends('layout.app')

@section('content')
<h3>Editar Disciplina</h3>

<form method="POST" action="/disciplinas/{{ $disciplina->id }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nome</label>
        <input type="text" name="nome" value="{{ $disciplina->nome }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Descrição</label>
        <textarea name="descricao" class="form-control">{{ $disciplina->descricao }}</textarea>
    </div>

    <button class="btn btn-primary">Atualizar</button>
</form>
@endsection
