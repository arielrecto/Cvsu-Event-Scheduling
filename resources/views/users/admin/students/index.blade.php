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
        <div class="flex items-center justify-between">
            <h1 class="panel-title">Students</h1>
            <a href="{{ route('events.create') }}" class="btn-generic">
                create
            </a>
        </div>

        <div class="w-full  flex items-center justify-end">
            <x-search :route="route('students.index')" :value="request()->get('search') ?? ''" />
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
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->profile->course }}</td>
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

                                    <form action="{{route('students.destroy', ['student' => $student->id])}}" method="post">
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
