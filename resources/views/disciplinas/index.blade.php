@extends('layouts.app')

@section('content')
<h2>Disciplinas</h2>

<a href="{{ route('disciplinas.create') }}" class="btn btn-primary mb-2">Nova</a>

<table class="table">
@foreach($disciplinas as $d)
<tr>
    <td>{{ $d->nome }}</td>
    <td>
        <a href="{{ route('disciplinas.edit', $d) }}" class="btn btn-sm btn-warning">Editar</a>
        <form action="{{ route('disciplinas.destroy', $d) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Excluir</button>
        </form>
    </td>
</tr>
@endforeach
</table>
@endsection
