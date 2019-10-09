<div class="card mt-3 px-3">
    <ul>
        @foreach ($project->activity as $activity)
        <li class="{{ $loop->last ? '' : 'mb-1' }}">
            @include("projects.activity.{$activity->description}") {{ $activity->created_at->diffForHumans() }}
        </li>
        @endforeach
    </ul>
</div>