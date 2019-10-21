<div class="card flex flex-col mt-3">
    <h3 class="font-normal text-xl py-4 px-5 border-l-4 border-blue-400 mb-2">
        Invitar usuario
    </h3>

    <form action="{{$project->path()}}/invitations" method="POST" class="px-3">
        @csrf
        <div class="mb-3">
            <input
                type="email"
                name="email"
                class="border border-gray-400 rounded w-full py-2 px-3"
                placeholder="Email"
            />
        </div>

        <button class="button" type="submit">
            Invitar
        </button>
    </form>
    @include('projects/errors', ['bag' => 'invitations'])
</div>
