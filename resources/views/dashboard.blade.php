<x-dashboard.base>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}
    <div class="main">
        <div class="header-grid">
            <div class="card bg-accent text-primary">
                <div class="card-label">
                    <i class="fi fi-rr-users"></i>
                    <h1>Unverified Student</h1>
                </div>
                <h1 class="card-number">
                    <span>{{$totalUnverifiedStudent}}</span>
                </h1>

            </div>
            <div class="card bg-secondary">
                <div class="card-label">
                    <i class="fi fi-rr-users-alt"></i>
                    <h1>Registered Student</h1>
                </div>
                <h1 class="card-number">
                    <span>{{$totalVerifiedStudent}}</span>
                </h1>
            </div>
            <div class="card bg-primary">
                <div class="card-label">
                    <i class="fi fi-rr-calendar-day"></i>
                    <h1>Events</h1>
                </div>
                <h1 class="card-number">
                    <span>{{count($events)}}</span>
                </h1>
            </div>
        </div>

        <div class="panel" x-data="calendar({{$events_json}})">
            <h1 class="panel-title">
                Event Calendar
            </h1>

            <div class="h-auto w-full" x-ref="calendar">

            </div>
        </div>

        <div class="panel">
            <h1 class="panel-title">
                Event
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

                        @forelse ($events as $event)
                            <tr class="bg-base-100">
                                <th></th>
                                <td>{{ $event->name }}</td>
                                <td>

                                    @forelse ($event->hosts as $host)
                                    {{ $host->speaker->fullName() }}
                                    @empty
                                        no host
                                    @endforelse
                                    </td>
                                <td>{{ $event->dateDuration() }}</td>
                                <td>{{ $event->timeDuration() }}</td>
                                <td>{{ $event->address() }}</td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a href="{{route('events.show', ['event' => $event->id])}}" class="btn btn-xs btn-accent">
                                            <i class="fi fi-rr-eye"></i>
                                        </a>
                                        {{-- <a href="#" class="btn btn-xs btn-error">
                                            <i class="fi fi-rr-trash"></i>
                                        </a> --}}
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




                {{ $events->links() }}
            </div>
        </div>

    </div>


</x-dashboard.base>
