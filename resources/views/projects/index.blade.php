@extends('layouts.app')

@section('content')
<header class="flex items-center mb-3 py-4">
    <div class="flex justify-between w-full items-center">
        <h1 class="text-gray-600 text-sm font-normal">Mis proyectos</h1>
        <a href="/projects/create" class="button">Nuevo proyecto</a>
    </div>
</header>

<div class="md:flex md:flex-wrap -mx-3">
    @forelse ($projects as $project)
    <div class="md:w-1/3 px-2 pb-6">
        @include('projects.card')
    </div>
    @empty
    <div>No hay proyectos</div>
    @endforelse
</div>
@endsection