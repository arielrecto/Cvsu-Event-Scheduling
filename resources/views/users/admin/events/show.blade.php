<x-dashboard.base>
    <div class="panel flex flex-col gap-2">

        <x-dashboard.header :route="route('events.index')" :event_name="'Event - ' . $event->name" />
        {{-- <div class="flex items-center gap-5">
            <a href="{{route('events.index')}}" class="btn-generic"><i class="fi fi-rr-arrow-left"></i></a>
            <h1 class="panel-title capitalize">Event - {{ $event->name }}</h1>
        </div> --}}

        <x-notification-message />

        <div class="w-full flex items-center justify-between">
            <span class="text-xs text-accent">Note: sample text</span>
            <div class="flex items-center gap-5">
                <form method="POST" action="{{ route('events.archives.store', ['event' => $event->id]) }}" class="btn btn-ghost">
                    @csrf
                    <button class="btn btn-xs btn-error">
                        Archive
                    </button>
                </form>
                <a href="{{ route('events.report', ['event' => $event->id]) }}" class="btn btn-ghost">
                    <i class="fi fi-rr-print text-xl"></i>
                </a>
            </div>

        </div>


        <div class="flex flex-col gap-5">
            <div class="h-64 w-full relative">
                <img src="{{ $event->image }}" alt="" srcset="" class="h-full w-full object object-cover">
                <div
                    class="absolute z-10 top-0 backdrop-sepia-0 bg-black/30 flex justify-center h-full w-full items-center">
                    <h1 class="text-4xl font-bold text-white tracking-widest capitalize">{{ $event->name }}</h1>
                </div>
            </div>


            <div class="flex gap-2 capitalize">
                <div class="w-1/4 flex justify-center">
                    {!! QrCode::size(100)->color(18, 55, 42)->generate($event->ref) !!}

                </div>
                <div class="flex flex-col gap-2 w-full">
                    <div class="flex flex-col gap-2">
                        <label for="" class="text-sm text-accent">Name</label>
                        <h1 class="text-lg">{{ $event->name }}</h1>
                    </div>
                    <div class="grid grid-cols-3 grid-flow-row gap-2">
                        <div class="flex flex-col gap-2">
                            <label for="" class="text-sm text-accent">Category</label>
                            <h1 class="text-sm">{{ $event->category }}</h1>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="" class="text-sm text-accent">School Year</label>
                            <h1 class="text-sm">{{ $event->school_year }}</h1>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="" class="text-sm text-accent">Semester</label>
                            <h1 class="text-sm">{{ $event->semester }}</h1>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="" class="text-sm text-accent">Event Referrence:</label>
                        <h1 class="text-sm">{{ $event->ref }}</h1>
                    </div>
                    <div class="grid grid-cols-2 grid-flow-row gap-2">
                        <div class="flex flex-col gap-2">
                            <label for="" class="panel-label">Event Duration</label>
                            <h1 class="text-sm">{{ $event->dateDuration() }}</h1>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="" class="panel-label">Event Time</label>
                            <h1 class="text-sm">{{ $event->timeDuration() }}</h1>
                        </div>
                    </div>
                    <h1 class="panel-label">Location</h1>
                    <div x-data="mapDisplay({{ $event->location }})" class="h-64 w-full">


                        <h1 class="text-sm">
                            <span x-text="address" />
                        </h1>
                        <div x-ref="map" class="h-full w-full">

                        </div>
                    </div>

                    <div class="grid grid-cols-2 grid-flw">
                        <div class="flex flex-col gap-2">
                            <a href="#attendances">

                                <h1 class="panel-label">
                                    Total Attendees
                                </h1>
                            </a>
                            <p>
                                {{ count($event->attendances) }}
                            </p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <a href="#attendances">
                                <h1 class="panel-label">
                                    Total Evaluation Result
                                </h1>
                            </a>
                            <p>
                                {{ count($event->evaluations) }}
                            </p>
                        </div>

                    </div>
                    <h1 class="panel-label">Descriptions</h1>
                    <div class="min-h-64 max-h-96 w-full overflow-y-auto bg-base-100 p-2 rounded-lg ">
                        {!! $event->description !!}
                    </div>
                </div>
            </div>
            <h1 class="text-accent">Speaker/Host Information</h1>

            @php
                $hosts = $event->hosts;
            @endphp

            @forelse ($hosts as $host)
                <div class="flex gap-2 w-full">
                    <div class="w-1/4 h-64">
                        <img src="{{ $host->speaker->image }}" alt="" srcset=""
                            class="w-full h-auto object object-cover">
                    </div>
                    <div class="flex flex-col gap-2 capitalize p-2 w-full">
                        <div class="grid grid-cols-3 grid-flow-row">
                            <div class="flex flex-col gap-2">
                                <label for="" class="panel-label">Last Name</label>
                                <h1>{{ $host->speaker->last_name }}</h1>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="panel-label">First Name</label>
                                <h1>{{ $host->speaker->first_name }}</h1>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="panel-label">Middle Name</label>
                                <h1>{{ $host->speaker->middle_name }}</h1>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="panel-label">Age</label>
                                <h1>{{ $host->speaker->age }}</h1>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="panel-label">gender</label>
                                <h1>{{ $host->speaker->gender }}</h1>
                            </div>
                        </div>
                        <h1 class="panel-label">
                            Address
                        </h1>
                        <p class="">{{ $host->speaker->address }}</p>
                        <h1 class="penel-label">
                            Descriptions
                        </h1>
                        <div class="min-h-64 max-h-94 w-full bg-base-100 rounded-lg p-2">
                            {{ $host->speaker->description }}
                        </div>
                    </div>
                </div>


            @empty
                <p>
                    No hosts
                </p>
            @endforelse



            <h1 class="text-accent">Evaluation</h1>


            @if ($event->evaluationForm === null)

                <div class="min-h-64 w-full p-5 rounded-lg bg-base-100 flex items-center justify-center">
                    <a href="{{ route('events.evaluation.form.create', ['event' => $event->id]) }}"
                        class="btn-generic">Add Evaluation Form</a>
                </div>
            @else
                @php
                    $evaluation_form = $event->evaluationForm;

                    $form = json_decode($evaluation_form->form);
                @endphp
                <div class="flex items-center justify-between">
                    <label for="" class="input-generic-label">
                        <span>*</span>
                        This the evaluation form preview
                    </label>
                    <div class="flex items-center gap-2">
                        {{-- <a href="#" class="btn btn-xs btn-primary"><i class="fi fi-rr-edit"></i></a> --}}

                        <form action="{{ route('events.evaluation.form.destroy', ['form' => $evaluation_form->id]) }}"
                            method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-xs btn-error">
                                <i class="fi fi-rr-trash"></i>
                            </button>
                        </form>

                        <a href="{{ route('events.form.print', ['event' => $event->id]) }}" class="btn btn-ghost">
                            <i class="fi fi-rr-print text-xl"></i>
                        </a>

                    </div>
                </div>
                <div class="flex flex-col gap-2 min-h-64 relative">
                    <div class="w-full h-auto p-2 rouned-lg bg-base-100 flex justify-center">
                        <h1 class="text-4xl font-bold tracking-widest">{{ $form->title }}</h1>
                    </div>
                    <div class="flex flex-col gap-2">
                        @foreach ($form->fields as $field)
                            <label for="" class="input-generic-label">{{ $field->question }}</label>
                            @if ($field->input_type !== 'radio')
                                <input type="{{ $field->input_type }}" class="input-generic">
                            @else
                                <div class="flex items-center gap-5">
                                    @for ($i = 1; $i <= $field->radio_max; $i++)
                                        <div class="flex flex-col items-center">
                                            <input type="radio" name="radio-4" class="radio radio-accent"
                                                value="{{ $i }}" />
                                            <span>{{ $i }}</span>
                                        </div>
                                    @endfor
                                </div>
                            @endif
                        @endforeach


                        <h1 class="panel-label text-lg font-bold">
                            Hosts
                        </h1>
                        @foreach ($form->speakers as $speaker)
                            <h1 class="font-bold capitalize">
                                Host: {{ $speaker->name }}
                            </h1>
                            @foreach ($speaker->fields as $s_field)
                                <label for="" class="input-generic-label">{{ $s_field->question }}</label>
                                @if ($field->input_type !== 'radio')
                                    <input type="{{ $s_field->input_type }}" class="input-generic">
                                @else
                                    <div class="flex items-center gap-5">
                                        @for ($i = 1; $i <= $s_field->radio_max; $i++)
                                            <div class="flex flex-col items-center">
                                                <input type="radio" name="radio-4" class="radio radio-accent"
                                                    value="{{ $i }}" />
                                                <span>{{ $i }}</span>
                                            </div>
                                        @endfor
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                    <div class=" absolute z-10 top-0 h-full w-full ">
                        <div class="w-full h-full hidden hover:flex justify-center items-center">
                            <h1 class="btn btn-accent">Evaluation Will Start at the end of the Event</h1>
                        </div>
                    </div>
                </div>
            @endif

            @php
                $attendances = $event
                    ->attendances()
                    ->with([
                        'user.profile' => function ($q) {
                            $q->with(['course', 'section']);
                        },
                        'event',
                    ])
                    ->get();

            @endphp

            <h1 class="panel-label">
                Attendance Record
            </h1>




            @if (count($attendances) !== 0)
                {{-- <div class="grid gird-cols-2 grid-flow-row gap-5 h-auto" x-data="pieChart({{ $attendancesByCourse_json }})">
                    <div class="w-full h-full">
                        <div x-ref="chart" class="w-1/2 h-auto">

                        </div>
                    </div>
                </div> --}}
                @php
                    $json_attendances = json_encode($attendances);
                @endphp

                <div class="flex flex-col w-full min-h-64 max-h-96 overflow-y-auto" id="attendances"
                    x-data="adminEventAttendances" x-init="initAttendances({{ $json_attendances }}, {{$event->id}})">
                    <div class="w-full flex justify-end py-2">
                        <input type="text" placeholder="search" x-model.debounce.700ms="search" class="input-generic te">
                    </div>
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
                                    <th>Course</th>
                                    <th>Year & Section</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>


                                <template x-if="attendances.lenth === 0">
                                    <tr>
                                        <td>No Record</td>

                                    </tr>
                                </template>

                                <template x-if="attendances.length !== 0">
                                    <template x-for="attendance in attendances" :key="attendance.id">
                                        <tr>
                                            <th></th>
                                            <td><span x-text="attendance.user.profile.student_id"></span></td>
                                            <td><span
                                                    x-text="`${attendance.user.profile.last_name}, ${attendance.user.profile.first_name}`"></span>
                                            </td>
                                            <td><span x-text="attendance.time_in"></span></td>
                                           <td><span x-text="`${attendance.time_out !== null ? attendance.time_out : '-'}`"></span></td>
                                             <td><span x-text="attendance.user.profile.course.name"></span></td>
                                              <td><span x-text="`${attendance.user.profile.section.year} - ${attendance.user.profile.section.number}`"></span></td>
                                            <td>
                                                 <div class="flex items-center">
                                                    <a :href="`/students/${attendance.user.id}`"
                                                        class="btn btn-xs btn-ghost">
                                                        <i class="fi fi-rr-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                </template>

                                {{-- @forelse ($attendances as $attendance)
                                    <tr>
                                        <th></th>
                                        <td>{{ $attendance->user->profile->student_id }}</td>
                                        <td>{{ $attendance->user->profile->fullName() }}</td>
                                        <td>{{ $attendance->time_in }}</td>
                                        <td>{{ $attendance->time_out ?? '-' }}</td>
                                        <td>{{ $attendance->user->profile->course->name }}</td>
                                        <td>{{ $attendance->user->profile->section->year }} -
                                            {{ $attendance->user->profile->section->number }}</td>
                                        <td>
                                            <div class="flex items-center">
                                                <a href="{{ route('students.show', ['student' => $attendance->user->id]) }}"
                                                    class="btn btn-xs btn-ghost">
                                                    <i class="fi fi-rr-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td>No Record</td>

                                    </tr>
                                @endforelse --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="w-full min-h-64 bg-gray-200 rounded-lg flex justify-center items-center">
                    <h1 class="text-accent">
                        No Attendances
                    </h1>
                </div>
            @endif

            <h1 class="panel-label">
                Evaluation Record
            </h1>
            @php
                $evaluations = $event->evaluations;

                $average = $event->evaluationsAverage();

            @endphp

            @if (count($evaluations) !== 0)

                <div class="flex flex-col gap-2 min-h-64 max-h-96 overflow-y-auto" id="evaluation">
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
                                    <th>Action</th>
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
                                        <td>{{ $evaluation->user->profile->section->year }} -
                                            {{ $evaluation->user->profile->section->number }}</td>
                                        <td>
                                            <div class="flex items-center">
                                                <a href="{{ route('students.show', ['student' => $evaluation->user->id]) }}"
                                                    class="btn btn-xs btn-ghost">
                                                    <i class="fi fi-rr-eye"></i>
                                                </a>
                                            </div>
                                        </td>
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
            @else
                <div class="w-full min-h-64 bg-gray-200 rounded-lg flex justify-center items-center">
                    <h1 class="text-accent">
                        No Evaluations
                    </h1>
                </div>

            @endif



        </div>


    </div>
</x-dashboard.base>
