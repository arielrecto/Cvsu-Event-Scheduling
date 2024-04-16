<x-dashboard.instructor>
    <div class="flex flex-col gap-2 p-5">
        <div class="panel flex flex-col gap-2">
            <h1 class="panel-title">Events</h1>



            <div class="panel flex flex-col gap-2">
                <h1 class="panel-title">Current Event</h1>
                @if ($event !== null)
                    <div class="flex rounded-lg bg-blue-500 h-96 relative">
                        <img src="{{ $event->image }}" class="object-cover h-auto w-full" />
                        <a href="{{ route('faculty.events.current', ['event' => $event->id]) }}"
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
                            <h1 class="text-3xl font-bold text-neural">
                                No Current Event
                            </h1>
                        </a>
                    </div>
                @endif
            </div>



            <h1 class="panel-label">
                Incoming Events
            </h1>
            <div class="overflow-y-auto">
                <table class="table">
                    <!-- head -->
                    <thead class="bg-secondary">
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Speaker</th>
                            <th>Date</th>
                            <th>Time</th>
                            <td>Address</th>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($incoming_events as $event)
                            <tr class="bg-base-100">
                                <th></th>
                                <td>{{ $event->name }}</td>
                                <td>
                                    @foreach ($event->hosts as $host)
                                        {{ $host->speaker->fullName() }}
                                    @endforeach
                                </td>
                                <td>{{ $event->dateDuration() }}</td>
                                <td>{{ $event->timeDuration() }}</td>
                                <td>{{ $event->address() }}</td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('faculty.events.show', ['event' => $event->id]) }}"
                                            class="btn btn-xs btn-accent">
                                            <i class="fi fi-rr-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-xs btn-secondary">
                                            <i class="fi fi-rr-edit"></i>
                                        </a>

                                        <form action="#" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-xs btn-error">
                                                <i class="fi fi-rr-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr class="bg-base-200">
                                <td>No Event</td>
                            </tr>
                        @endforelse


                    </tbody>
                </table>
                {{ $incoming_events->links() }}
            </div>

            <h1 class="panel-label">
                Passed Events
            </h1>
            <div class="overflow-y-auto">
                <table class="table">
                    <!-- head -->
                    <thead class="bg-secondary">
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Speaker</th>
                            <th>Date</th>
                            <th>Time</th>
                            <td>Address</th>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($passed_events as $event)
                            <tr class="bg-base-100">
                                <th></th>
                                <td>{{ $event->name }}</td>
                                <td>
                                    @foreach ($event->hosts as $host)
                                        {{ $host->speaker->fullName() }}
                                    @endforeach
                                </td>
                                <td>{{ $event->dateDuration() }}</td>
                                <td>{{ $event->timeDuration() }}</td>
                                <td>{{ $event->address() }}</td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('faculty.events.show', ['event' => $event->id]) }}"
                                            class="btn btn-xs btn-accent">
                                            <i class="fi fi-rr-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-xs btn-secondary">
                                            <i class="fi fi-rr-edit"></i>
                                        </a>

                                        <form action="#" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-xs btn-error">
                                                <i class="fi fi-rr-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr class="bg-base-200">
                                <td>No Event</td>
                            </tr>
                        @endforelse


                    </tbody>
                </table>
                {{ $passed_events->links() }}
            </div>
        </div>
    </div>
</x-dashboard.instructor>
