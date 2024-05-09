<x-dashboard.base>
    <div class="panel flex flex-col gap-2">
        <x-notification-message />

        <div class="grid grid-cols-2 grid-flow-row gap-5 h-32 w-full">
            <a href="{{ route('students.index') }}" class="card bg-accent text-primary">
                <div class="card-label">
                    <i class="fi fi-rr-users"></i>
                    <h1> Student</h1>
                </div>
                <h1 class="card-number">
                    <span>{{ $totalVerifiedStudent }}</span>
                </h1>

            </a>

            <a href="{{ route('students.index', ['filter' => 'Unverified']) }}" class="card bg-secondary">
                <div class="card-label">
                    <i class="fi fi-rr-users-alt"></i>
                    <h1>Unverified Student</h1>
                </div>
                <h1 class="card-number">
                    <span>{{ $totalUnverifiedStudent }}</span>
                </h1>
            </a>


        </div>
        {{-- <div class="flex items-center justify-between">
            <h1 class="panel-title">Students</h1>
            <a href="{{ route('events.create') }}" class="btn-generic">
                create
            </a>
        </div> --}}

        <div class="w-full  flex items-center justify-end">
            @if (!request()->get('filter'))
                <x-search :route="route('students.index')" :value="request()->get('search') ?? ''" />
            @else
                <form action="{{ route('students.index') }}" method="GET" class="max-w-md min-w-96">
                    <label for="default-search"
                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search" id="default-search" name="search"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-secondary rounded-lg bg-base-100
                         focus:ring-accent focus:border-accent
                         "
                            placeholder="search" />

                        <input type="hidden" id="default-search" name="filter"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-secondary rounded-lg bg-base-100
                         focus:ring-accent focus:border-accent
                         "
                            value="{{ request()->get('filter') }}" placeholder="search" />
                        <button type="submit"
                            class="text-white absolute end-2.5 bottom-2.5 btn btn-accent top-1 ">Search</button>
                    </div>
                </form>
            @endif
        </div>
        <div class="overflow-y-auto">
            <table class="table">
                <!-- head -->
                <thead class="bg-secondary">
                    <tr>
                        <th></th>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Course</th>
                        {{-- <th>Date</th>
                        <th>Time</th>
                        <td>Address</th> --}}
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($students as $student)
                        <tr class="bg-base-100">
                            <th></th>
                            <td>{{ $student->profile->student_id }}</td>
                            <td>{{ $student->profile->fullName() }}</td>
                            <td>{{ $student->profile->course->name }}</td>
                            {{-- <td>{{ $event->dateDuration() }}</td>
                            <td>{{ $event->timeDuration() }}</td>
                            <td>{{ $event->address() }}</td> --}}
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('students.show', ['student' => $student->id]) }}"
                                        class="btn btn-xs btn-accent">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>
                                    <div class="relative">
                                        <a href="{{ route('students.edit', ['student' => $student->id]) }}"
                                            class="btn btn-xs btn-secondary">
                                            <i class="fi fi-rr-edit"></i>
                                        </a>
                                        @if (!$student->profile->verified_at)
                                            <div
                                                class="absolute z-10 top-0 w-full h-full backdrop-blur-md flex items-center justify-center">
                                                <p class="text-accent">
                                                    <i class="fi fi-rr-person-circle-xmark"></i>
                                                </p>
                                            </div>
                                        @endif
                                    </div>

                                    <form action="{{ route('students.destroy', ['student' => $student->id]) }}"
                                        method="post">
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
                            <td>No Student</td>
                        </tr>
                    @endforelse


                </tbody>
            </table>





            {{ $students->links() }}
        </div>
    </div>
</x-dashboard.base>
