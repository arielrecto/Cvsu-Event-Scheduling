<x-dashboard.base>

    <div class="flex flex-col gap-5">

        <x-dashboard.header :route="route('course.index')" :event_name="'Course Show'" />


        <x-notification-message />

        <div class="panel">

            <div class="flex items-center justify-between">
                <h1 class="panel-title"> {{ $instructor->name}}</h1>
                <h1 class="panel-title"> {{ $instructor->email}}</h1>
            </div>






            <h1 class="panel-label flex items-center justify-between p-2">
                <span>Course</span>
                {{-- <span>
                  <a href="{{route('course.section.create', ['course' => $instructor->id])}}" class="btn btn-xs btn-accent">Add Section</a>
                </span> --}}
              </h1>

            <table class="table">
                <!-- head -->
                <thead class="bg-secondary">
                    <tr>
                        <th></th>
                        {{-- <th>Student ID</th> --}}
                        <th>Course</th>
                        {{-- <th>Section No. </th> --}}
                        <th>Date</th>
                        {{--<th>Time</th>
                        <td>Address</th> --}}
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($instructor->instructorInfo->courses as $i_course)
                        <tr class="bg-base-100">
                            <th></th>
                            <td>{{ $i_course->course->name}}</td>
                            {{-- <td>{{ $i_section->section->number }}</td> --}}
                            <td>{{ date('F d, Y h:s A', strtotime($i_course->created_at)) }}</td>

                            <td>
                                <div class="flex items-center gap-2">



                                    {{-- <form action="{{route('section.destroy', ['section' => $i_section->id])}}" method="post">
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
                            <td>No Section</td>
                        </tr>
                    @endforelse


                </tbody>
            </table>
            <h1 class="panel-label flex items-center justify-between p-2">
              <span>Sections</span>
              {{-- <span>
                <a href="{{route('course.section.create', ['course' => $instructor->id])}}" class="btn btn-xs btn-accent">Add Section</a>
              </span> --}}
            </h1>
            <table class="table">
                <!-- head -->
                <thead class="bg-secondary">
                    <tr>
                        <th></th>
                        {{-- <th>Student ID</th> --}}
                        <th>Year</th>
                        <th>Section No. </th>
                        <th>Date</th>
                        {{--<th>Time</th>
                        <td>Address</th> --}}
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($instructor->instructorInfo->sections  as $i_section)
                        <tr class="bg-base-100">
                            <th></th>
                            <td>{{ $i_section->section->year }}</td>
                            <td>{{ $i_section->section->number }}</td>
                            <td>{{ date('F d, Y h:s A', strtotime($i_section->created_at)) }}</td>

                            <td>
                                <div class="flex items-center gap-2">



                                    {{-- <form action="{{route('section.destroy', ['section' => $i_section->id])}}" method="post">
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
                            <td>No Section</td>
                        </tr>
                    @endforelse


                </tbody>
            </table>

        </div>

    </div>



</x-dashboard.base>
