@extends('layout.app')

@section('content')
<h2>Minhas Notas</h2>

@if($notas->isEmpty())
    <div class="alert alert-info">
        Nenhuma nota lançada ainda.
    </div>
@else
<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>Disciplina</th>
            <th>Turma</th>
            <th>Composição da Nota</th> {{-- Nova Coluna --}}
            <th>Total Acumulado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($notas as $nota)
            <tr>
                <td>{{ $nota->turma->disciplina->nome }}</td>
                <td>{{ $nota->turma->nome }}</td>
                
                {{-- Exibe o histórico (ex: 10 + 20 + 5) --}}
                <td class="text-muted fst-italic">
                    {{ $nota->historico ?? $nota->valor }}
                </td>

                <td class="fw-bold fs-5">
                    {{ $nota->valor }}
                    
                    {{-- Badge de status --}}
                    @if($nota->valor >= 60)
                        <span class="badge bg-success fs-6 ms-2">Aprovado</span>
                    @else
                        <span class="badge bg-danger fs-6 ms-2">Reprovado</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection