<!DOCTYPE html>
<html>
<head>
    <title>Sistema Acadêmico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- MOVIDO PARA CÁ: Chart.js no head para carregar antes dos scripts da página --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="container mt-4">

<nav class="mb-4 d-flex justify-content-between">
    <div>
        @auth
            <a href="{{ route('dashboard') }}">Dashboard</a>

            @if(auth()->user()->role === 'admin')
                | <a href="{{ route('disciplinas.index') }}">Disciplinas</a>
                | <a href="{{ route('turmas.index') }}">Turmas</a>
            @endif

            @if(auth()->user()->role === 'professor')
                | <a href="{{ route('notas.create') }}">Lançar Notas</a>
            @endif

            @if(auth()->user()->role === 'aluno')
                | <a href="{{ route('minhas-notas') }}">Minhas Notas</a>
            @endif
        @endauth
    </div>

    <div>
        @auth
            <form method="POST" action="/logout" class="d-inline">
                @csrf
                <button class="btn btn-link">Logout</button>
            </form>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="btn btn-link">Login</a>
        @endguest
    </div>
</nav>

@yield('content')

</body>
</html>