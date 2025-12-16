@extends('layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="mb-3">Editar Usuário</h4>

                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Nome</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Perfil</label>
                        <select name="role" class="form-select" required>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="professor" {{ $user->role == 'professor' ? 'selected' : '' }}>Professor</option>
                            <option value="aluno" {{ $user->role == 'aluno' ? 'selected' : '' }}>Aluno</option>
                        </select>
                    </div>

                    <hr>
                    <p class="text-muted"><small>Deixe em branco se não quiser alterar a senha.</small></p>

                    <div class="mb-3">
                        <label>Nova Senha (Opcional)</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Confirmar Nova Senha</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <button class="btn btn-primary w-100">Salvar Alterações</button>
                    <a href="{{ route('users.index') }}" class="btn btn-link w-100 mt-2">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection