 @extends('layouts.app')

 @section('content')
 <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
     <h1 class="text-lg">Crear un proyecto</h1>

     <form action="/projects" method="POST">
         @include('projects/form', ['project' => new App\Project])
         <input type="submit" class="button" value="Crear">
         <a href="/projects">Cancelar</a>
     </form>
 </div>
 @endsection