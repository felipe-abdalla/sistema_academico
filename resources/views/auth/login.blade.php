@extends('layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="card-title mb-3">Login</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="/login">
                    @csrf

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Senha</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button class="btn btn-primary w-100 mb-2">Entrar</button>
                    
                    <div class="text-center">
                        <span class="text-muted">ou</span>
                    </div>
                    <a href="/register" class="btn btn-outline-secondary w-100 mt-2">Criar Nova Conta</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection