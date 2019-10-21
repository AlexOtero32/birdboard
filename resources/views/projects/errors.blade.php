@if($errors->{$bag ?? 'default'}->any())
    <ul class="mt-6 px-3">
        @foreach ($errors->{$bag ?? 'default'}->all() as $error)
            <li class="text-red-500 list-reset">{{ $error }}</li>
        @endforeach
    </ul>
@endif
