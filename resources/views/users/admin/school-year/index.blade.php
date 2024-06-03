<x-dashboard.base>
    <div class="panel flex flex-col gap-2">
        <x-notification-message />


        <div class="flex items-center justify-between">
            <h1 class="panel-title">Course</h1>
            <a href="{{ route('course.create') }}" class="btn-generic">
                create Course
            </a>
        </div>


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

                    @forelse ($schoolYears as $schoolYear)
                        <tr class="bg-base-100">
                            <th></th>
                            <td>{{ $schoolYear->year }}</td>

                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="{{route('shool-year.show', ['shool_year' => $schoolYear->id])}}"
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

                                    {{-- <form action="{{route('course.destroy', ['course' => $course->id])}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-xs btn-error">
                                            <i class="fi fi-rr-trash"></i>
                                        </button>
                                    </form> --}}


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





            {{ $schoolYears->links() }}
        </div>
    </div>
</x-dashboard.base>
