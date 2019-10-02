@extends('layouts.app')

@section('content')
<h1>Birdboard</h1>

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