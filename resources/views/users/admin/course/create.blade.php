<x-dashboard.base>

    <div class="flex flex-col gap-5">

        <x-dashboard.header :route="route('course.index')" :event_name="'Course Create'" />


        <x-notification-message />

        <div class="panel">

            <h1 class="panel-title">Add Course</h1>


            <form action="{{route('course.store')}}" method="post" class="w-full flex flex-col gap-2">
                @csrf

                <div class="input-generic-div">
                    <label for="" class="input-generic-label">Name</label>
                    <input type="text" name="name" placeholder="name" class="input-generic">

                    @if ($errors->has('name'))
                        <p class="text-xs text-error">{{$errors->first('name')}}</p>
                    @endif
                </div>

                <button class="btn btn-accent">Submit</button>
            </form>

        </div>

    </div>



</x-dashboard.base>
