@extends('layout.app')

@section('content')
<h3>Nova Disciplina</h3>

<form method="POST" action="/disciplinas">
    @csrf

    <div class="mb-3">
        <label>Nome</label>
        <input type="text" name="nome" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Descrição</label>
        <textarea name="descricao" class="form-control"></textarea>
    </div>

    <button class="btn btn-success">Salvar</button>
</form>
@endsection
