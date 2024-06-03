<x-dashboard.base>

    <div class="flex flex-col gap-5">

        <x-dashboard.header :route="route('school-year.index')" :event_name="'School  Year Show'" />


        <x-notification-message />

        <div class="panel">

            <div class="flex items-center justify-between">

                <h1 class="panel-title"> {{ $schoolYear->year }}</h1>


                <a href="{{ route('school-year.print.show', ['school-year' => $schoolYear->id]) }}" class="btn btn-ghost">
                    <i class="fi fi-rr-print text-xl"></i>
                </a>
            </div>


            <h1 class="text-sm text-accent">Events</h1c>
                <div class="overflow-y-auto">
                    <table class="table">
                        <!-- head -->
                        <thead class="bg-secondary">
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Hosts</th>
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
                                            <p>{{ $host->speaker->fullName() }},</p>

                                        @empty

                                            <p>No Hosts</p>
                                        @endforelse

                                    </td>
                                    <td>{{ $event->dateDuration() }}</td>
                                    <td>{{ $event->timeDuration() }}</td>
                                    <td>{{ $event->address() }}</td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('events.show', ['event' => $event->id]) }}"
                                                class="btn btn-xs btn-accent">
                                                <i class="fi fi-rr-eye"></i>
                                            </a>
                                            <a href="{{ route('events.edit', ['event' => $event->id]) }}"
                                                class="btn btn-xs btn-secondary">
                                                <i class="fi fi-rr-edit"></i>
                                            </a>

                                            <form action="{{ route('events.archives.store', ['event' => $event->id]) }}"
                                                method="post">
                                                @csrf
                                                {{-- @method('delete') --}}
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
                    {{ $events->links() }}
                </div>
        </div>

    </div>



</x-dashboard.base>
