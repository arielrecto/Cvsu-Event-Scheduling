<x-dashboard.instructor>
    <div class="flex flex-col gap-2 p-5">
        <div class="panel flex flex-col gap-2">
            <h1 class="panel-title">Current Event</h1>
            <div class="flex rounded-lg bg-blue-500 h-64 relative">
                <img src="{{ $event->image }}" class="object-cover h-auto w-full" />
            </div>
            <h1 class="panel-title">
                Event: {{$event->name}}
            </h1>

            <h1 class="panel-label">
                Attendance Monitoring
            </h1>
        </div>
    </div>
</x-dashboard.instructor>
