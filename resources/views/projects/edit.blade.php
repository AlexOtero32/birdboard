@extends('layouts.app')

@section('content')
<div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
    <h1 class="text-lg">Editar proyecto</h1>

    <form action="{{ $project->path() }}" method="POST">
        @method('PATCH')

        @include('projects/form')
        <input type="submit" class="button" value="Editar">
        <a href="{{ $project->path() }}">Cancelar</a>
    </form>
</div>
@include('projects/errors')
@endsection