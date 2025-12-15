@extends('layout.app')

@section('content')
<h3>Lançar Nota</h3>

<form method="POST" action="/notas">
    @csrf

    <div class="mb-3">
        <label>Aluno</label>
        <select name="aluno_id" class="form-select">
            @foreach($alunos as $aluno)
                <option value="{{ $aluno->id }}">{{ $aluno->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Nota</label>
        <input type="number" name="valor" min="0" max="100" class="form-control">
    </div>

    <button class="btn btn-success">Salvar</button>
</form>
@endsection
