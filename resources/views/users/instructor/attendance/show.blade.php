<x-dashboard.instructor>

    <div class="flex flex-col gap-5">

        <x-dashboard.header :event_name="'Attendance Show'" />


        <x-notification-message />

        <div class="panel flex flex-col gap-5">

            <h1 class="panel-title">{{ $attendance->user->name }}</h1>


            @php
                $student = $attendance->user;
            @endphp

            <div class="flex flex-col gap-2">
                <h1 class="panel-label">Student ID </h1>
                <p class="font-bold tracking-widest">{{ $student->profile->student_id }}</p>
            </div>
            <div class="grid grid-cols-3 grid-flow-row gap-2 w-full">
                <div class="flex flex-col gap-2">
                    <h1 class="panel-label">Last Name</h1>
                    <p>{{ $student->profile->last_name }}</p>
                </div>
                <div class="flex flex-col gap-2">
                    <h1 class="panel-label">First Name</h1>
                    <p>{{ $student->profile->first_name }}</p>
                </div>
                <div class="flex flex-col gap-2">
                    <h1 class="panel-label">Middle Name</h1>
                    <p>{{ $student->profile->middle_name }}</p>
                </div>
                <div class="flex flex-col gap-2">
                    <h1 class="panel-label">age</h1>
                    <p>{{ $student->profile->age }}</p>
                </div>
                <div class="flex flex-col gap-2">
                    <h1 class="panel-label">Course</h1>
                    <p>{{ $student->profile->course->name }}</p>
                </div>
                <div class="flex flex-col gap-2">
                    <h1 class="panel-label">Year & Section</h1>
                    <p>{{ $student->profile->section->year }} - {{$student->profile->section->number}}</p>
                </div>
                <div class="flex flex-col gap-2">
                    <h1 class="panel-label">gender</h1>
                    <p>{{ $student->profile->gender }}</p>
                </div>
            </div>
            <div class="w-full flex flex-col gap-2">
                <h1 class="panel-label">Address</h1>
                <p>
                    {{ $student->profile->address }}
                </p>
            </div>

            <table class="table">

                <thead class="bg-accent text-white">
                    <tr>
                        <th></th>

                        <th>Time in</th>
                        <th>Time out</th>

                    </tr>
                </thead>
                <tbody>



                    <tr>
                        <th></th>


                        <td>{{ $attendance->time_in }}</td>
                        <td>{{ $attendance->time_out }}</td>


                    </tr>

                </tbody>
            </table>
        </div>

    </div>



</x-dashboard.instructor>
