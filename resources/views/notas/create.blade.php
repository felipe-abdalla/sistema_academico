@extends('layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Lançar Nota</h4>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
                    </div>
                @endif
                
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('notas.store') }}">
                    @csrf

                    {{-- PASSO 1: Seleção de Turma --}}
                    <div class="mb-3">
                        <label class="form-label">1. Selecione a Turma</label>
                        {{-- O script abaixo recarrega a página ao mudar a seleção --}}
                        <select name="turma_id" class="form-select" onchange="window.location.href = '{{ route('notas.create') }}?turma_id=' + this.value" required>
                            <option value="">Selecione...</option>
                            @foreach($turmas as $turma)
                                <option value="{{ $turma->id }}" {{ (isset($turmaSelecionada) && $turmaSelecionada->id == $turma->id) ? 'selected' : '' }}>
                                    {{ $turma->nome }} - {{ $turma->disciplina->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- PASSO 2: Seleção de Aluno (Só aparece se Turma estiver selecionada) --}}
                    @if(isset($turmaSelecionada))
                        <div class="mb-3 p-3 bg-light border rounded">
                            <label class="form-label">2. Selecione o Aluno (Matriculado em {{ $turmaSelecionada->nome }})</label>
                            
                            @if($alunos->isEmpty())
                                <div class="alert alert-warning mb-0">
                                    Nenhum aluno matriculado nesta turma.
                                </div>
                            @else
                                <select name="aluno_id" class="form-select" required>
                                    <option value="">Selecione o aluno...</option>
                                    @foreach($alunos as $aluno)
                                        <option value="{{ $aluno->id }}">{{ $aluno->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">3. Informe a Nota (0-100)</label>
                            <input type="number" name="valor" min="0" max="100" class="form-control" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-success" {{ $alunos->isEmpty() ? 'disabled' : '' }}>Salvar Nota</button>
                        </div>
                    @else
                        <div class="alert alert-secondary text-center">
                            Selecione uma turma acima para carregar a lista de alunos.
                        </div>
                    @endif
                    
                    <a href="{{ route('dashboard') }}" class="btn btn-link mt-2 d-block text-center">Voltar ao Painel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection