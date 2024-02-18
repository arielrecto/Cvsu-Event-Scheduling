@props([
    'route' => null,
    'event_name' => null
])

<div class="flex items-center gap-5">
    <a href="{{$route}}" class="btn-generic"><i class="fi fi-rr-arrow-left"></i></a>
    <h1 class="panel-title capitalize">{{ $event_name }}</h1>
</div>
