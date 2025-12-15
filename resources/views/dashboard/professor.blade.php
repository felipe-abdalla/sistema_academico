@extends('layouts.app')

@section('content')
<h2>Dashboard - Professor</h2>

<a href="{{ route('notas.create') }}" class="btn btn-primary">
    Lançar Notas
</a>
@endsection
