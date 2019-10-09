<div class="card mt-3 px-3">
    <ul>
        @foreach ($project->activity as $activity)
        <li class="{{ $loop->last ? '' : 'mb-1' }}">
            @include("projects.activity.{$activity->description}") <span class="text-gray-400">{{ $activity->created_at->diffForHumans(null, true) }}</span>
        </li>
        @endforeach
    </ul>
</div>