 @extends('layouts.app')

 @section('content')
 <h1>Crear un proyecto</h1>

 <form action="/projects" method="POST">
     @csrf
     <input type="text" name="title" />
     <textarea name="description" cols="30" rows="10"></textarea>
     <input type="submit" value="Enviar">
     <a href="/projects">Cancelar</a>
 </form>

 @endsection