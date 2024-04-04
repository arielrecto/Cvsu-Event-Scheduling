<x-dashboard.instructor>
    <div class="flex flex-col gap-2 p-5">
        <div class="panel flex flex-col gap-2">
            <h1 class="panel-title">Current Event</h1>

            @if($event === null)
            <div class="flex rounded-lg bg-blue-500 h-96 relative">
                <img src="{{ $event->image }}" class="object-cover h-auto w-full" />
                <a href="{{route('faculty.events.current', ['event' => $event->id])}}"
                    class="w-full absolute z-10 bottom-0 h-24 flex items-center justify-between backdrop-blur-lg bg-white/30 p-5">
                    <div class="flex items-center gap-2">
                        <h1 class="text-lg font-bold">
                            <span>Event Date: </span>
                            <span>{{ date('F d, Y', strtotime($event->start_date)) }} </span>
                        </h1> <span> - </span>
                        <h1 class="text-lg font-bold">
                            <span>Until Date:</span>
                            <span>{{ date('F d, Y', strtotime($event->end_date)) }} </span>
                        </h1>
                    </div>
                    <div class="flex items-center gap-2">
                        <h1 class="text-lg font-bold">
                            Time :

                        </h1>
                        <h1 class="text-lg font-bold">
                            <span>
                                {{ date('h:s A', strtotime($event->start_time)) }} -
                            </span>
                            <span>
                                {{ date('h:s A', strtotime($event->end_time)) }}
                            </span>
                        </h1>
                    </div>
                </a>
            </div>
            @else
            <div class="flex rounded-lg bg-blue-500 h-96 relative">
                <img src="{{ asset('calendar.png') }}" class="object-cover h-auto w-full" />
                <a href="#"
                    class="w-full absolute z-10 bottom-0 h-24 flex items-center justify-center backdrop-blur-lg bg-white/30 p-5">
                    No Current Event
                </a>
            </div>
            @endif

        </div>
    </div>
</x-dashboard.instructor>
