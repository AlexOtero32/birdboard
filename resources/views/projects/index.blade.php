@extends('layouts.app')

@section('content')
<div class="flex items-center">
    <h1 class="mr-auto">Proyectos</h1>
    <a href="/projects/create">Nuevo proyecto</a>
</div>

<div class="flex">
    @forelse ($projects as $project)
    <div class="bg-white mr-4 rounded p-5 shadow w-1/3" style="height: 250px;">
        <h3 class="font-normal text-xl py-4">{{$project->title}}</h3>
        <div class="text-gray-700">{{ Illuminate\Support\Str::limit($project->description) }}</div>
    </div>
    @empty
    <div>No hay proyectos</div>
    @endforelse
</div>
@endsection