@extends('layouts.app')

@section('content')
<header class="flex items-center mb-3 py-4">
    <div class="flex justify-between w-full items-center">
        <p class="text-gray-600 text-sm font-normal"><a href="/projects">
                Mis proyectos
            </a>
            / {{ $project->title }}</p>
        <a href="{{ $project->path(). '/edit' }}" class="button">Editar</a>
    </div>
</header>

<main>
    <div class="md:flex -m-3">
        <div class="md:w-3/4 px-3">
            <div class="mb-6">
                <h2 class="text-gray-700 text-lg font-normal mb-3">Tareas</h2>
                @forelse ($project->tasks as $task)
                <div class="card px-4 mb-3">
                    <form action="{{ $task->path() }}" method="post">
                        @method('PATCH')
                        @csrf
                        <div class="flex">
                            <input type="text" name="body" value="{{ $task->body }}" class="w-full bg-transparent {{$task->completed ? 'text-gray-400' : ''}}">
                            <input type="checkbox" name="completed" onChange="this.form.submit()" {{$task->completed ? 'checked' : ''}} />
                        </div>
                    </form>
                </div>
                @empty
                <div class="card px-4 mb-3">Añadir tareas</div>
                @endforelse
                <div class="card px-4">
                    <form action="{{ $project->path() . '/tasks' }}" method="post">
                        @csrf
                        <input type="text" name="body" class="bg-transparent w-full" placeholder="Añadir una tarea..." />
                    </form>
                </div>
            </div>
            <div class="mb-6">
                <h2 class="text-gray-700 text-lg font-normal mb-3">Notas generales</h2>
                <form action="{{ $project->path() }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <textarea class="card px-4 w-full" name="notes" style="min-height: 180px;">{{ $project->notes }}</textarea>
                    <button type="submit" class="button">Actualizar</button>
                </form>
            </div>
        </div>
        <div class="md:w-1/4 px-3">
            @include('projects/card')

            @include('projects/activity/card')
        </div>
    </div>
    @include('projects/errors')
</main>
@endsection