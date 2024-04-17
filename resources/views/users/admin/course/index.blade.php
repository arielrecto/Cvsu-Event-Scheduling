<x-dashboard.base>
    <div class="panel flex flex-col gap-2">
        <x-notification-message />

        {{-- <div class="grid grid-cols-2 grid-flow-row gap-5 h-32 w-full">
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


        </div> --}}
        <div class="flex items-center justify-between">
            <h1 class="panel-title">Course</h1>
            <a href="{{ route('course.create') }}" class="btn-generic">
                create Course
            </a>
        </div>

        {{-- <div class="w-full  flex items-center justify-end">
            <x-search :route="route('students.index')" :value="request()->get('search') ?? ''" />
        </div> --}}
        <div class="overflow-y-auto">
            <table class="table">
                <!-- head -->
                <thead class="bg-secondary">
                    <tr>
                        <th></th>
                        {{-- <th>Student ID</th> --}}
                        <th>Name</th>
                        <th>Date Added</th>
                        {{-- <th>Date</th>
                        <th>Time</th>
                        <td>Address</th> --}}
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($courses as $course)
                        <tr class="bg-base-100">
                            <th></th>
                            <td>{{ $course->name }}</td>
                            <td>{{ date('F d Y h:s A', strtotime($course->created_at)) }}</td>
                            {{-- <td>{{ $student->profile->course }}</td> --}}
                            {{-- <td>{{ $event->dateDuration() }}</td>
                            <td>{{ $event->timeDuration() }}</td>
                            <td>{{ $event->address() }}</td> --}}
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="{{route('course.show', ['course' => $course->id])}}"
                                        class="btn btn-xs btn-accent">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>
                                    {{-- <div class="relative">
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
                                    </div> --}}

                                    <form action="{{route('course.destroy', ['course' => $course->id])}}" method="post">
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





            {{ $courses->links() }}
        </div>
    </div>
</x-dashboard.base>
