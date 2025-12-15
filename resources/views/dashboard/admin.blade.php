@extends('layouts.app')

@section('content')
<h2>Dashboard - Administrador</h2>

<div class="list-group">
    <a href="{{ route('disciplinas.index') }}" class="list-group-item">
        Gerenciar Disciplinas
    </a>
    <a href="{{ route('turmas.index') }}" class="list-group-item">
        Gerenciar Turmas
    </a>
</div>
@endsection
