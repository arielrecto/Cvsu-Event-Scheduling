<x-dashboard.instructor>
    <div class="flex flex-col gap-2 p-5">
        <div class="panel flex flex-col gap-2">
            <h1 class="panel-title">Current Event</h1>
            <div class="flex rounded-lg bg-blue-500 h-64 relative">
                <img src="{{ $event->image }}" class="object-cover h-auto w-full" />
            </div>
            <h1 class="panel-title">
                Event: {{ $event->name }}
            </h1>

            <h1 class="panel-label">
                Attendance Monitoring
            </h1>

            <div x-data="displayClock">
                <h1 class="flex items-center gap-2">
                    <span>Time : </span>
                    <span x-text="time" />
                </h1>
            </div>

            <div class="overflow-x-auto" x-data="getEventAttendances({{$event->id}})">
                <table class="table">
                    <!-- head -->
                    <thead class="bg-accent text-white">
                        <tr>
                            <th></th>
                            <th>Student Id</th>
                            <th>Name</th>
                            <th>Time in</th>
                            <th>Time out</th>
                            <th>Course</th>
                            <th>Year & Section</th>
                        </tr>
                    </thead>
                    <tbody>

                     <template x-for="attendance in attendances" :key="attendance.id">

                        <tr>
                            <th></th>
                            <td><span x-text="attendance.user.profile.student_id" /></td>
                            <td><span x-text="attendance.user.name" /></td>
                            <td><span x-text="attendance.time_in" /></td>
                            <td><span x-text="attendance.time_out" /></td>
                            <td><span x-text="attendance.user.profile.course.name" /></td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <h1>
                                        <span x-text="attendance.user.profile.section.year" />
                                    </h1>
                                    <span> - </span>
                                    <h1>
                                        <span x-text="attendance.user.profile.section.number" />
                                    </h1>
                                </div>
                            </td>
                            <td>
                                {{-- <div class="flex items-center">
                                    <a href="#"
                                        class="btn btn-xs btn-ghost">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>
                                </div> --}}
                            </td>
                        </tr>
                     </template>



                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dashboard.instructor>
