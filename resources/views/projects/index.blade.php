@extends('layouts.app')

@section('content')
<div class="flex items-center">
    <h1 class="mr-auto">Proyectos</h1>
    <a href="/projects/create">Nuevo proyecto</a>
</div>

<ul>
    @forelse ($projects as $project)
    <a href="{{ $project->path() }}">
        <li>{{ $project->title }}</li>
    </a>
    @empty
    <li>No hay proyectos</li>
    @endforelse
</ul>
@endsection