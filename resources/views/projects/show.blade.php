@extends('layouts.app')

@section('content')
<header class="flex items-center mb-3 py-4">
    <div class="flex justify-between w-full items-center">
        <p class="text-gray-600 text-sm font-normal"><a href="/projects">
                Mis proyectos
            </a>
            / {{ $project->title }}</p>
        <a href="/projects/create" class="button">Nuevo proyecto</a>
    </div>
</header>

<main>
    <div class="md:flex -m-3">
        <div class="md:w-3/4 px-3">
            <div class="mb-6">
                <h2 class="text-gray-700 text-lg font-normal mb-3">Tareas</h2>
                <div class="card px-4 mb-3">Lorem ipsum</div>
                <div class="card px-4 mb-3">Lorem ipsum</div>
                <div class="card px-4 mb-3">Lorem ipsum</div>
                <div class="card px-4">Lorem ipsum</div>
            </div>
            <div class="mb-6">
                <h2 class="text-gray-700 text-lg font-normal mb-3">Notas generales</h2>
                <textarea class="card px-4 w-full" style="min-height: 180px;">Lorem ipsum</textarea>
            </div>
        </div>
        <div class="md:w-1/4 px-3">
            @include('projects/card')
        </div>
    </div>
</main>
@endsection