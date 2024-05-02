<x-dashboard.instructor>
    <div class="panel flex flex-col gap-2">
        <x-notification-message />
        <x-dashboard.header :event_name="'Sections'" />

        <a href="{{route('faculty.sections.create')}}" class="btn btn-sm btn-accent">Add Section</a>
        <table class="table">
            <!-- head -->
            <thead class="bg-secondary">
                <tr>
                    <th></th>
                    {{-- <th>Student ID</th> --}}
                    <th>Course</th>
                    <th>Year</th>
                    <th>Section No. </th>
                    <th>Date</th>
                    {{-- <th>Time</th>
                    <td>Address</th> --}}
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>

                @forelse ($sections  as $_section)
                    <tr class="bg-base-100">
                        <th></th>
                        <td>{{ $_section->section->course->name }}</td>
                        <td>{{ $_section->section->year }}</td>
                        <td>{{ $_section->section->number }}</td>
                        <td>{{ date('F d, Y h:s A', strtotime($_section->created_at)) }}</td>

                        <td>
                            <div class="flex items-center gap-2">
                                {{-- <a href="#"
                                    class="btn btn-xs btn-accent">
                                    <i class="fi fi-rr-eye"></i>
                                </a> --}}


                                <form action="{{ route('faculty.sections.destroy', ['section' => $_section->id]) }}"
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
                        <td>No Section</td>
                    </tr>
                @endforelse


            </tbody>
        </table>
    </div>

</x-dashboard.instructor>
