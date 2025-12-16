@extends('layout.app')

@section('content')
<h2 class="mb-4">Painel Administrativo</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Cartões de Acesso Rápido --}}
<div class="row mb-5">
    <div class="col-md-4 mb-3">
        <div class="card h-100 shadow-sm border-primary">
            <div class="card-body text-center">
                <h5 class="card-title text-primary">Disciplinas</h5>
                <a href="{{ route('disciplinas.index') }}" class="btn btn-outline-primary w-100">Gerenciar</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card h-100 shadow-sm border-success">
            <div class="card-body text-center">
                <h5 class="card-title text-success">Turmas</h5>
                <a href="{{ route('turmas.index') }}" class="btn btn-outline-success w-100">Gerenciar</a>
            </div>
        </div>
    </div>
    {{-- NOVO: Cartão de Usuários --}}
   <div class="col-md-4 mb-3">
        <div class="card h-100 shadow-sm border-warning">
            <div class="card-body text-center">
                <h5 class="card-title text-warning">Usuários</h5>
                {{-- Link alterado de 'register' para 'users.index' --}}
                <a href="{{ route('users.index') }}" class="btn btn-outline-warning w-100">
                    Gerenciar Usuários
                </a>
            </div>
        </div>
    </div>

{{-- Área de Gráficos (MANTIDA IGUAL AO ANTERIOR) --}}
<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header">Turmas por Disciplina</div>
            <div class="card-body">
                <canvas id="chartDisciplinas"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header">Usuários por Perfil</div>
            <div class="card-body">
                <canvas id="chartUsers" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    // Gráfico de Barras: Turmas por Disciplina
    const ctxDisc = document.getElementById('chartDisciplinas');
    new Chart(ctxDisc, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labelsDisc) !!},
            datasets: [{
                label: 'Qtd. de Turmas',
                data: {!! json_encode($dataDisc) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: { scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
    });

    // Gráfico de Pizza: Usuários
    const ctxUser = document.getElementById('chartUsers');
    new Chart(ctxUser, {
        type: 'doughnut',
        data: {
            labels: ['Admin', 'Professor', 'Aluno'],
            datasets: [{
                data: [
                    {{ $usersCounts['admin'] ?? 0 }},
                    {{ $usersCounts['professor'] ?? 0 }},
                    {{ $usersCounts['aluno'] ?? 0 }}
                ],
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
            }]
        }
    });
</script>
@endsection