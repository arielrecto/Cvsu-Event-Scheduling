<x-dashboard.base>

    <div class="flex flex-col gap-5">

        <x-dashboard.header :route="route('course.index')" :event_name="'Course Create'" />


        <x-notification-message />

        <div class="panel">

            <h1 class="panel-title">Add School Year</h1>


            <form action="{{route('school-year.store')}}" method="post" class="w-full flex flex-col gap-2">
                @csrf

                <div class="input-generic-div">
                    <label for="" class="input-generic-label">Start Year</label>
                    <input type="number" name="start_year" placeholder="2023" class="input-generic">

                    @if ($errors->has('start_year'))
                        <p class="text-xs text-error">{{$errors->first('start_year')}}</p>
                    @endif
                </div>
                <div class="input-generic-div">
                    <label for="" class="input-generic-label">End Year</label>
                    <input type="number" name="end_year" placeholder="2024" class="input-generic">

                    @if ($errors->has('end_year'))
                        <p class="text-xs text-error">{{$errors->first('end_year')}}</p>
                    @endif
                </div>

                <button class="btn btn-accent">Submit</button>
            </form>

        </div>

    </div>



</x-dashboard.base>
