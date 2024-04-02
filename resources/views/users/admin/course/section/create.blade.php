<x-dashboard.base>

    <div class="flex flex-col gap-5">

        <x-dashboard.header :route="route('course.show', ['course' => $course->id])" :event_name="'Section Create'" />


        <x-notification-message />

        <div class="panel">

            <h1 class="panel-title">Add Section</h1>

            <h1 class="panel-lable">Sections</h1>
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

                    @forelse ($course->sections  as $section)
                        <tr class="bg-base-100">
                            <th></th>
                            <td>{{ $section->year }}</td>
                            <td>{{ $section->number }}</td>
                            <td>{{ date('F d, Y h:s A', strtotime($section->created_at)) }}</td>

                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="#"
                                        class="btn btn-xs btn-accent">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>


                                    <form action="#" method="post">
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


            <form action="{{route('course.section.store', ['course' => $course->id])}}" method="post" class="w-full flex flex-col gap-2">
                @csrf

                <div class="input-generic-div">
                    <label for="" class="input-generic-label">Year Level</label>
                    <input type="number" name="year_level" placeholder="Year Level" class="input-generic">

                    @if ($errors->has('year_level'))
                        <p class="text-xs text-error">{{$errors->first('year_level')}}</p>
                    @endif
                </div>
                <div class="input-generic-div">
                    <label for="" class="input-generic-label">Section Number</label>
                    <input type="number" name="section_number" placeholder="Section Number" class="input-generic">

                    @if ($errors->has('section_number'))
                        <p class="text-xs text-error">{{$errors->first('section_number')}}</p>
                    @endif
                </div>

                <input type="hidden" name="course" value="{{$course->id}}">

                <button class="btn btn-accent">Submit</button>
            </form>

        </div>

    </div>



</x-dashboard.base>
