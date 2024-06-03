<x-app-layout>
    <div class="w-full flex justify-center min-h-screen bg-white" x-data="print">
        <div class="w-4/6 h-screen flex flex-col gap-2 p-5" x-ref="main">
            <div class="flex items-center justify-between bg-gray-200 rounded-lg p-5" x-ref="header">
                <div class="flex items-center gap-5">
                    <a href="{{ route('school-year.show', ['school_year' => $schoolYear->id]) }}" class="btn-generic"><i
                            class="fi fi-rr-arrow-left"></i></a>
                    <h1 class="panel-title capitalize">School Year {{ $schoolYear->year }}</h1>
                </div>
                <button class="btn btn-accent" @click="printComponent">
                    Print
                    <i class="fi fi-rr-print text-xl"></i>
                </button>
            </div>

            <div class="panel">

                <h1 class="panel-title"> {{ $schoolYear->year }}</h1>

                <div class="grid grid-cols-2 grid-flow-row gap-2">
                    <div class="card bg-accent text-primary">
                        <div class="card-label">
                            <i class="fi fi-rr-users"></i>
                            <h1>Total Events</h1>
                        </div>
                        <h1 class="card-number">
                            <span>0</span>
                        </h1>

                    </div>
                    <div class="card bg-accent text-primary">
                        <div class="card-label">
                            <i class="fi fi-rr-users"></i>
                            <h1>1st Semester</h1>
                        </div>
                        <h1 class="card-number">
                            <span>0</span>
                        </h1>

                    </div>
                    <div class="card bg-accent text-primary">
                        <div class="card-label">
                            <i class="fi fi-rr-users"></i>
                            <h1>2nd semester</h1>
                        </div>
                        <h1 class="card-number">
                            <span>0</span>
                        </h1>

                    </div>
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

                                                <form
                                                    action="{{ route('events.archives.store', ['event' => $event->id]) }}"
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
    </div>
</x-app-layout>
