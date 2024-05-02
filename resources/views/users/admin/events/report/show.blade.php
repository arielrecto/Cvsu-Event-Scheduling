<x-app-layout>
    <div class="w-full flex justify-center min-h-screen bg-white" x-data="print">
        <div class="w-4/6 h-screen flex flex-col gap-2 p-5" x-ref="main">
            <div class="flex items-center justify-between bg-gray-200 rounded-lg p-5" x-ref="header">
                <div class="flex items-center gap-5">
                    <a href="{{ route('events.show', ['event' => $event->id]) }}" class="btn-generic"><i
                            class="fi fi-rr-arrow-left"></i></a>
                    <h1 class="panel-title capitalize"> Event Report</h1>
                </div>
                <button class="btn btn-accent" @click="printComponent">
                    Print
                    <i class="fi fi-rr-print text-xl"></i>
                </button>
            </div>


            <div class="h-auto w-full p-5 flex flex-col gap-5 ">
                <div class="w-full flex justify-center items-center">
                    <div class="flex items-center gap-5">
                        <img src="{{ asset('logo.png') }}" alt="" srcset=""
                            class="h-12 w-12 object object-center">
                        <div>
                            <p class="text-gray-600 text-center text-sm">
                                Republic of the Philippines
                            </p>
                            <h1 class="text-2xl font-bold flex flex-col items-center">
                                <span class="text-3xl">
                                    Cavite State University
                                </span>

                                 <span class="text-sm">Bacoor City Campus</span> </h1>
                            <p class="text-gray-600 text-center text-xs font-bold">
                                Soldiers Hills IV, Molino VI, Bacoor City, Cavite
                            </p>
                            <p class="text-gray-600 text-center text-xs">
                               DEPARTMENT OF COMPUTER STUDIES
                            </p>
                        </div>
                    </div>
                </div>
                <div class="w-full items-center justify-between hidden" x-ref="reportHeader">
                    <h1 class="text-lg font-bold">Event Report</h1>
                    <h1 class="text-lg font-semibold">Generated: {{ now()->format('F d, Y') }}</h1>
                </div>

                <h1 class="panel-label">
                    Event Information
                </h1>
                <div class="min-h-64 flex gap-2 justify-between">
                    <div class="w-1/4 h-full">
                        <img src="{{ $event->image }}" alt="" class="h-auto w-full object object-center" />
                    </div>
                    <div class="w-4/6 h-auto flex flex-col gap-2 capitalize border-2 border-accent rounded-lg p-2">
                        <h1 class="panel-label font-bold">
                            Summary
                        </h1>
                        <div class="flex justify-between items-center">
                            <div class="flex flex-col gap-2">
                                <h1 class="text-xs text-accent">
                                    name
                                </h1>
                                <h1 class="text-sm">
                                    {{ $event->name }}
                                </h1>
                            </div>
                            <div class="flex flex-col gap-2">
                                <h1 class="text-xs text-accent">
                                    Date
                                </h1>
                                <h1 class="text-sm">
                                    {{ $event->dateDuration() }}
                                </h1>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 grid-flow-row gap-2 border-2 rounded-lg">
                            <div class="flex items-center border-r-2 p-2 justify-between">
                                <h1 class="text-sm">
                                    Total Attendees:
                                </h1>
                                <span class="font-bold text-center"> {{ count($event->attendances) }}</span>
                            </div>
                            <div class="flex items-center border-r-2 p-2 justify-between">
                                <h1 class="text-sm">
                                    Average:
                                </h1>
                                <span class="font-bold text-center"> {{ $event->evaluationsAverage() }}</span>
                            </div>
                            <div class="flex items-center border-r-2 p-2 justify-between">
                                <h1 class="text-sm">
                                    Result:
                                </h1>
                                <span class="font-bold text-center"> {{ $event->evaluationsResult() }}</span>
                            </div>
                        </div>
                        <h1 class="panel-label">
                            Course Attendees
                        </h1>
                        <div class="grid grid-cols-4 grid-flow-row gap-2 border-2 rounded-lg">

                            @foreach ($attendancesByCourse as $key => $value)
                                <div class="flex items-center border-r-2 p-2 justify-between">
                                    <h1 class="text-sm">
                                        {{ $key }}
                                    </h1>
                                    <span class="font-bold text-center"> {{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                        <h1 class="panel-label">
                            Host/Speaker
                        </h1>

                        @forelse ($event->hosts as $host)
                        <div class="flex flex-col gap-2">
                            <h1 class="text-xs text-accent">
                                name
                            </h1>
                            <h1>
                                {{$host->speaker->fullName()}}
                            </h1>
                        </div>
                        @empty

                            <p>No Hosts</p>
                        @endforelse

                    </div>
                </div>


                <h1 class="panel-label">
                    Attendance Record
                </h1>
                @php
                    $attendances = $event->attendances;

                @endphp

                {{-- <div class="grid gird-cols-2 grid-flow-row gap-5 h-auto" x-data="pieChart({{ $attendancesByCourse_json }})">
                    <div class="w-full h-full">
                        <div x-ref="chart" class="w-1/2 h-auto">

                        </div>
                    </div>
                </div> --}}

                <div class="flex flex-col w-full" id="attendances">

                    <div class="overflow-x-auto">
                        <table class="table">
                            <!-- head -->
                            <thead class="bg-accent text-white">
                                <tr>
                                    <th></th>
                                    <th>Student Id</th>
                                    <th>Fullname</th>
                                    <th>Time in</th>
                                    <th>Time out</th>
                                    <th>gender</th>
                                    <th>Course</th>
                                    <th>Year & Section</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($attendances as $attendance)
                                    <tr>
                                        <th></th>
                                        <td>{{ $attendance->user->profile->student_id }}</td>
                                        <td>{{ $attendance->user->profile->fullName() }}</td>
                                        <td>{{ $attendance->time_in }}</td>
                                        <td>{{ $attendance->time_out ?? '-' }}</td>
                                        <td>{{ $attendance->user->profile->gender }}</td>
                                        <td>{{ $attendance->user->profile->course->name }}</td>
                                        <td>{{ $attendance->user->profile->section->year . ' - ' . $attendance->user->profile->section->number }}</td>
                                        {{-- <td>
                                            <div class="flex items-center">
                                                <a href="{{ route('students.show', ['student' => $attendance->user->id]) }}"
                                                    class="btn btn-xs btn-ghost">
                                                    <i class="fi fi-rr-eye"></i>
                                                </a>
                                            </div>
                                        </td> --}}
                                    </tr>

                                @empty
                                    <tr>
                                        <td>No Record</td>

                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <h1 class="panel-label">
                    Evaluation Record
                </h1>
                @php
                    $evaluations = $event->evaluations;

                    $average = $event->evaluationsAverage();
                @endphp
                <div class="flex flex-col gap-2" id="evaluation">
                    <div class="grid grid-cols-2 grid-flow-row h-32 w-full gap-2">
                        <div class="card bg-accent text-primary">
                            <h1 class="card-label">
                                Average
                            </h1>
                            <span class="card-number">
                                {{ $average }}
                            </span>
                        </div>
                        <div class="card bg-secondary">
                            <h1 class="card-label">
                                Result
                            </h1>
                            <span class="card-number">
                                {{ $event->evaluationsResult() }}
                            </span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="table">
                            <!-- head -->
                            <thead class="bg-accent text-white">
                                <tr>
                                    <th></th>
                                    <th>Student Id</th>
                                    <th>Fullname</th>
                                    <th>Average</th>
                                    <th>Result</th>
                                    <th>Course</th>
                                    <th>Year & Section</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($evaluations as $evaluation)
                                    <tr>
                                        <th></th>
                                        <td>{{ $evaluation->user->profile->student_id }}</td>
                                        <td>{{ $evaluation->user->profile->fullName() }}</td>
                                        <td>{{ $evaluation->average }}</td>
                                        <td>{{ $evaluation->result }}</td>
                                        <td>{{ $evaluation->user->profile->course->name }}</td>
                                        <td>{{ $evaluation->user->profile->section->year . ' - ' . $evaluation->user->profile->section->number }}</td>
                                        {{-- <td>
                                            <div class="flex items-center">
                                                <a href="{{ route('students.show', ['student' => $attendance->user->id]) }}"
                                                    class="btn btn-xs btn-ghost">
                                                    <i class="fi fi-rr-eye"></i>
                                                </a>
                                            </div>
                                        </td> --}}
                                    </tr>

                                @empty
                                    <tr>
                                        <td>No Record</td>

                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="mt-24 w-full flex justify-end">
                    <div class="flex flex-col gap-2 w-auto h-auto">
                        <span class="border-b-2 border-black"></span>
                        <h1 class="text-center font-bold">Prepared By: {{ Auth::user()->name }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
