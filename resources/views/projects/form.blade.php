<div class="flex flex-col">
    @csrf
    <label for="title">
        Título
    </label>
    <input type="text" name="title" placeholder="Crear algo maravilloso" class="field" value="{{ $project->title }}" />
    <label for="description">
        Descripción
    </label>
    <textarea name="description" class="field" cols="30" rows="10">{{ $project->description }}</textarea>
    <div>