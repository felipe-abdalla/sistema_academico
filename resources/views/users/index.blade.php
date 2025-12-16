@extends('layout.app')

@section('content')
<h2>Gerenciar Usuários</h2>

{{-- Botão que leva para o cadastro existente --}}
<a href="{{ route('register') }}" class="btn btn-primary mb-3">Novo Usuário</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Perfil</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'professor' ? 'info' : 'secondary') }}">
                {{ ucfirst($user->role) }}
            </span>
        </td>
        <td>
            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Editar</a>
            
            {{-- Impede botão de excluir no próprio usuário logado --}}
            @if(auth()->id() !== $user->id)
                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Excluir</button>
                </form>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@endsection