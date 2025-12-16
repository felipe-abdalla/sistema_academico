@extends('layout.app')

@section('content')
<h2>Painel do Aluno</h2>
<p class="text-muted">Bem-vindo, {{ auth()->user()->name }}.</p>

<div class="row mt-4">
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-header">Meu Desempenho Acadêmico</div>
            <div class="card-body">
                <canvas id="chartNotas" style="max-height: 400px;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white"><strong>Boletim Detalhado</strong></div>
            @if($notas->isEmpty())
                <div class="p-4 text-center">Nenhuma nota lançada.</div>
            @else
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Disciplina</th>
                            <th>Turma</th>
                            <th>Nota</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notas as $nota)
                        <tr>
                            <td>{{ $nota->turma->disciplina->nome }}</td>
                            <td>{{ $nota->turma->nome }}</td>
                            <td class="fw-bold">{{ $nota->valor }}</td>
                            <td>
                                @if($nota->valor >= 60)
                                    <span class="badge bg-success">Aprovado</span>
                                @else
                                    <span class="badge bg-danger">Reprovado</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('chartNotas');
    // Armazena os valores em uma variável para usar na cor também
    const valores = {!! json_encode($valoresNotas) !!};

    new Chart(ctx, {
        type: 'bar',
        data: {
            // CORREÇÃO AQUI
            labels: {!! json_encode($disciplinasAluno) !!},
            datasets: [{
                label: 'Minhas Notas',
                data: valores,
                // Lógica de cor condicional
                backgroundColor: valores.map(v => v >= 60 ? 'rgba(40, 167, 69, 0.7)' : 'rgba(220, 53, 69, 0.7)'),
                borderColor: '#000',
                borderWidth: 1
            }]
        },
        options: {
            scales: { y: { beginAtZero: true, max: 100 } },
            plugins: { legend: { display: false } }
        }
    });
</script>
@endsection