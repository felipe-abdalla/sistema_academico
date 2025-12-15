@extends('layout.app')

@section('content')
<h3>Minhas Notas</h3>

<table class="table table-striped">
    <tr>
        <th>Disciplina</th>
        <th>Nota</th>
    </tr>

    @foreach($notas as $nota)
    <tr>
        <td>{{ $nota->turma->disciplina->nome }}</td>
        <td>{{ $nota->valor }}</td>
    </tr>
    @endforeach
</table>
@endsection
