@extends('layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body">
                <h4>Cadastro</h4>

                <form method="POST" action="/register">
                    @csrf

                    <div class="mb-3">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Senha</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Confirmar Senha</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Perfil</label>
                        <select name="role" class="form-select">
                            <option value="admin">Administrador</option>
                            <option value="professor">Professor</option>
                            <option value="aluno">Aluno</option>
                        </select>
                    </div>

                    <button class="btn btn-success w-100">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
