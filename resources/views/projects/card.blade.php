<a href="{{ $project->path() }}" class="no-underline">
    <div class="card flex flex-col" style="height: 250px;">
        <h3 class="font-normal text-xl py-4 px-5 border-l-4 border-blue-400 mb-2">
            {{$project->title}}
        </h3>
        <div class="text-gray-700 px-5 mb-4 flex-1">{{ Illuminate\Support\Str::limit($project->description) }}</div>

        <footer>
            <form action="{{ $project->path() }}" class="text-right">
                @csrf
                @method('DELETE')
                <button type="submit" class="m-3">
                    Eliminar
                </button>
            </form>
        </footer>
    </div>
</a>
