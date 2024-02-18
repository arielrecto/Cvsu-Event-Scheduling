<x-dashboard.base>
    <div class="panel flex flex-col gap-2">
        <x-notification-message />
        <div class="flex items-center justify-between">
            <h1 class="panel-title">Speaker/Host</h1>
            <a href="{{ route('speaker.create') }}" class="btn-generic">
                Add Speaker/Host
            </a>
        </div>

        <div class="w-full  flex items-center justify-end">
            <x-search :route="route('speaker.index')" :value="request()->get('search') ?? ''"/>
        </div>

        <div class="overflow-y-auto">
            <table class="table">
                <!-- head -->
                <thead class="bg-secondary">
                    <tr>
                        <th></th>
                        <th>Name</th>
                        {{-- <th>Speaker</th> --}}
                        <th>Events</th>
                        {{-- <th>Time</th>
                        <td>Address</th>--}}
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($speakers as $speaker)
                        <tr class="bg-base-100">
                            <th></th>
                            {{-- <td>{{ $event->name }}</td> --}}
                            <td class="capitalize">{{ $speaker->fullName() }}</td>
                            <td>{{ $speaker->events()->count() }}</td>
                            {{-- <td>{{ $event->timeDuration() }}</td>
                            <td>{{ $event->address() }}</td> --}}
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="{{route('speaker.show', ['speaker' => $speaker->id])}}" class="btn btn-xs btn-accent">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>
                                    <a href="{{route('speaker.edit', ['speaker' => $speaker->id])}}" class="btn btn-xs btn-secondary">
                                        <i class="fi fi-rr-edit"></i>
                                    </a>

                                    <form action="{{route('speaker.destroy', ['speaker' => $speaker->id])}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button  class="btn btn-xs btn-error">
                                            <i class="fi fi-rr-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr class="bg-base-200">
                            <td>No Speaker/Host</td>
                        </tr>
                    @endforelse


                </tbody>
            </table>





            {{ $speakers->links() }}
        </div>
    </div>
</x-dashboard.base>
