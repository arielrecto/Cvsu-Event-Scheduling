<x-dashboard.instructor>
    <div class="flex flex-col gap-2 p-5">
        <div class="panel flex flex-col gap-2">

            <div class="flex justify-between">
                <h1 class="panel-title">Current Event</h1>

                <a href="{{ route('faculty.events.report', ['event' => $event->id]) }}" class="btn btn-ghost">
                    <i class="fi fi-rr-print text-xl"></i>
                </a>

            </div>

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

            <div class="overflow-x-auto" x-data="getEventAttendances({{ $event->id }})">
                <div class="flex justify-end p-5">
                    <div class="join">
                        <div>
                            <div>
                                <template x-if="!changeInpuTypeToggle">
                                    <input class="input input-bordered join-item" placeholder="Search"
                                        x-model.debounce.500ms="search" />
                                </template>


                                <template x-if="changeInpuTypeToggle">
                                    <select x-model="search"
                                        class="select border-gray-300 w-full max-w-xs rounded-r-none">
                                        <option>Select Section</option>

                                        @foreach ($sections as $_section)
                                            <option value="{{ $_section->section->id }}">
                                                {{ $_section->section->course->name . ' ' . $_section->section->year . '-' . $_section->section->number }}
                                            </option>
                                        @endforeach

                                    </select>
                                </template>

                            </div>
                        </div>
                        <select class="select select-bordered join-item" @change="selectCategory($event)">
                            <option disabled selected>Filter</option>
                            <option value="time in">Time In</option>
                            <option value="time out">Time Out</option>
                            <option value="course">Course</option>
                            <option value="my-section">My Section</option>
                        </select>
                        <div class="indicator">
                            <button class="btn join-item">Search</button>
                        </div>
                    </div>
                </div>
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
                            <th>Action</th>
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
                                    <div class="flex items-center">
                                        <a :href="`/faculty/attendances/${attendance.id}`" class="btn btn-xs btn-ghost">
                                            <i class="fi fi-rr-eye"></i>
                                        </a>
                                        <form :action="`/faculty/attendances/${attendance.id}`" method="post"
                                            class="btn btn-xs btn-ghost">
                                            @method('delete')
                                            @csrf
                                            <button><i class="fi fi-rr-trash-xmark text-error"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dashboard.instructor>
