<x-dashboard.base>
    <div class="panel flex flex-col gap-2">
        <x-notification-message />
        <div class="flex items-center justify-between">
            <h1 class="panel-title">Events</h1>
            <a href="{{ route('events.create') }}" class="btn-generic">
                create Events
            </a>
        </div>

        <div class="w-full  flex items-center justify-end">
            <x-search :route="route('events.index')" :value="request()->get('search') ?? ''"/>
        </div>



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




                                @foreach ($event->hosts as $host)
                                    <p>{{$host->speaker->fullName()}},</p>
                                @endforeach

                            </td>
                            <td>{{ $event->dateDuration() }}</td>
                            <td>{{ $event->timeDuration() }}</td>
                            <td>{{ $event->address() }}</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="{{route('events.show', ['event' => $event->id])}}" class="btn btn-xs btn-accent">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>
                                    <a href="{{route('events.edit', ['event' => $event->id])}}" class="btn btn-xs btn-secondary">
                                        <i class="fi fi-rr-edit"></i>
                                    </a>

                                    <form action="{{route('events.destroy', ['event' => $event->id])}}" method="post">
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
            {{ $events->links() }}
        </div>
    </div>
</x-dashboard.base>
