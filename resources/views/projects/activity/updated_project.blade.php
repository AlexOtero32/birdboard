@if(count($activity->changes['after']) == 1)
    {{ $activity->user->name }} actualizó {{ key($activity->changes['after']) }} del proyecto
@else
    Actualizaste el proyecto
@endif
