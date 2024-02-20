<x-app-layout>



    <div class="bg-base-100 w-full min-h-screen flex justify-center items-center">
        <div class="w-4/6 h-auto rounded-lg bg-gray-50 flex flex-col gap-2">
            <x-dashboard.navbar />

            <x-notification-message />

            <div class="p-5 flex flex-col gap-2">
                <h1 class="panel-title p-5">
                    Attendance
                </h1>
                <h1 class="panel-label">Event Information</h1>
                <div class="panel gap-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="panel-label">Name</h1>
                            <h1 class="font-bold text-lg">{{ $event->name }}</h1>
                        </div>

                        <h1 class="font-semibold text-sm"> <span>Posted At:
                            </span>{{ date('F d, Y', strtotime($event->created_at)) }}</h1>
                    </div>

                    <div class="flex justify-between place-items-center">
                        <div class="flex flex-col gap-2">
                            <h1 class="panel-label">Event Duration</h1>
                            <h1>{{ $event->dateDuration() }}</h1>
                        </div>
                        <div class="flex flex-col gap-2">
                            <h1 class="panel-label">Even Time</h1>
                            <h1>{{ $event->timeDuration() }}</h1>
                        </div>
                    </div>
                    <h1 class="font-bold text-accent">Start Time: {{ $event->start_time }}</h1>

                    <div x-data="displayClock"
                        class="flex items-center justify-center text-3xl font-4xl font-bold tracking-widest text-accent p-5">
                        <div x-text="time" x-ref="MyClockDisplay">

                        </div>
                    </div>

                    @if ($attendance !== null)
                        <div class="overflow-x-auto">
                            <table class="table">
                                <!-- head -->
                                <thead class="bg-accent text-primary">
                                    <tr>
                                        <th>Student ID</th>
                                        <th>FullName</th>
                                        <th>Time In</th>
                                        <th>Time Out</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- row 1 -->
                                    <tr>
                                        <th>{{ $attendance->user->profile->student_id }}</th>
                                        <td>{{ $attendance->user->profile->fullName() }}</td>
                                        <td>{{ $attendance->time_in }}</td>
                                        <td>{{ $attendance->time_out ?? '-' }}</td>
                                        <td>{{ date('F d, Y', strtotime($attendance->created_at)) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if ($attendance == null || $attendance->time_out == null)
                        <form action="{{ route('event.attendance', ['event_ref' => $event->ref]) }}" method="post">
                            @csrf

                            @if ($attendance !== null)
                                <button class="btn-generic w-full h-32 text-xl">Time Out</button>
                            @else
                                <button class="btn-generic w-full h-32 text-xl">Time In</button>
                            @endif

                        </form>
                    @endif

                </div>
            </div>

        </div>
    </div>


    {{-- <form action="{{route('logout')}}" method="post">

    @csrf

    <button>Logout</button>
</form> --}}

</x-app-layout>
