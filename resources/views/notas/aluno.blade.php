@extends('layout.app')

@section('content')
<h2>Minhas Notas</h2>

@if($notas->isEmpty())
    <div class="alert alert-info">
        Nenhuma nota lançada ainda.
    </div>
@else
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Disciplina</th>
            <th>Turma</th>
            <th>Nota</th>
        </tr>
    </thead>
    <tbody>
        @foreach($notas as $nota)
            <tr>
                <td>{{ $nota->turma->disciplina->nome }}</td>
                <td>{{ $nota->turma->nome }}</td>
                <td>{{ $nota->valor }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
