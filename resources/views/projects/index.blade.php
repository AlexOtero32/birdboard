@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between w-full items-center">
            <h1 class="text-default text-sm font-normal">Mis proyectos</h1>
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
    <modal name="new-project" classes="p-10 bg-card rounded-lg" height="auto">
        <h1 class="font-normal mb-16 text-center text-2xl">Crea algo nuevo</h1>
        <div class="flex">
            <div class="flex-1 mr-4">
                <div class="mb-4">
                    <label for="title" class="text-sm block mb-2">Título</label>
                    <input type="text" name="title"
                           class="block border p-2 border-gray-300 text-sm w-full rounded"/>
                </div>
                <div class="mb-4">
                    <label for="description" class="text-sm block mb-2">Descripción</label>
                    <textarea type="text" name="description"
                              class="block border p-2 border-gray-300 text-sm w-full rounded">
                    </textarea>
                </div>
            </div>
            <div class="flex-1 ml-4">
                <div class="mb-4">
                    <label for="task" class="text-sm block mb-2">Crear tareas</label>
                    <input
                        type="text" name="task"
                        class="block border p-2 border-gray-300 text-sm w-full rounded"
                        placeholder="Primera tarea"
                    />
                </div>
                <button>
                    <span>Añadir nueva tarea</span>
                </button>
            </div>
        </div>
        <footer class="flex justify-end">
            <button class="mr-4 is-outline">Crear proyecto</button>
            <button @click="$modal.hide('new-project')">Cancelar</button>
        </footer>
    </modal>
    <a href="" @click.prevent="$modal.show('new-project')">Ver modal</a>
@endsection
