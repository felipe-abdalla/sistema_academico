@extends('layout.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Painel do Professor</h2>
    <a href="{{ route('notas.create') }}" class="btn btn-primary">Lançar Notas</a>
</div>

<div class="row">
    {{-- Lista de Turmas --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-light"><strong>Minhas Turmas</strong></div>
            <div class="card-body p-0">
                @if($turmas->isEmpty())
                    <p class="p-3 text-muted">Nenhuma turma vinculada.</p>
                @else
                    <table class="table table-striped mb-0">
        <thead>
            <tr>
                <th>Turma</th>
                <th>Disciplina</th>
                <th>Ações</th> {{-- Coluna Adicionada --}}
            </tr>
        </thead>
        <tbody>
            @foreach($turmas as $turma)
            <tr>
                <td>{{ $turma->nome }}</td>
                <td>{{ $turma->disciplina->nome ?? 'N/A' }}</td>
                <td>
                    {{-- Botão para o Professor adicionar alunos --}}
                    <a href="{{ route('turmas.matriculas', $turma) }}" class="btn btn-sm btn-outline-primary">
                        Gerenciar Alunos
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
                    
                @endif
            </div>
        </div>
    </div>

    {{-- Gráfico de Desempenho --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">Média de Notas por Turma</div>
            <div class="card-body">
                <canvas id="chartMedias"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('chartMedias');
    new Chart(ctx, {
        type: 'bar',
        data: {
            // CORREÇÃO AQUI
            labels: {!! json_encode($turmaNomes) !!},
            datasets: [{
                label: 'Média da Turma',
                data: {!! json_encode($medias) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: { y: { beginAtZero: true, max: 100 } }
        }
    });
</script>
@endsection