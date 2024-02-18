@php

       $events = $speaker->events;
@endphp

<x-dashboard.base>

    <div class="panel flex flex-col gap-2">
        <x-dashboard.header :route="route('speaker.index')" :event_name="'Speaker/Host - ' . $speaker->fullName()" />

        <div class="flex gap-5">
            <div class="w-1/5 h-96 flex flex-col gap-2 capitalize mt-5">
                <a href="{{$speaker->image}}" class="venobox">
                    <img src="{{ $speaker->image }}" alt="" srcset=""
                    class="h-34 w-full rounded-full object object-center ">
                </a>

                    <h1 class="text-xl font-bold text-center">{{$speaker->fullName()}}</h1>
                    <p class="text-center text-accent text-sm flex flex-col">
                        <span>Date Added:</span>
                        <span> {{$speaker->dateCreated()}}</span>
                    </p>
            </div>

            <div class="flex flex-col gap-2 p-5 capitalize w-full">
                <h1 class="panel-label font-bold">Personal Information</h1>
                <div class="grid grid-cols-3 grid-flow-row gap-2 w-full">
                    <div class="flex flex-col gap-2">
                        <h1 class="panel-label">Last Name</h1>
                        <p>{{$speaker->last_name}}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h1 class="panel-label">First Name</h1>
                        <p>{{$speaker->first_name}}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h1 class="panel-label">Middle Name</h1>
                        <p>{{$speaker->middle_name}}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h1 class="panel-label">age</h1>
                        <p>{{$speaker->age}}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h1 class="panel-label">gender</h1>
                        <p>{{$speaker->gender}}</p>
                    </div>
                </div>
                <div class="w-full flex flex-col gap-2">
                    <h1 class="panel-label">Address</h1>
                    <p>
                        {{$speaker->address}}
                    </p>
                </div>
                <div class="w-full flex flex-col gap-2">
                    <h1 class="panel-label">Occupation</h1>
                    <p>
                        {{$speaker->occupation}}
                    </p>
                </div>
                <h1 class="panel-label">Description</h1>
                <div class="min-h-64 max-h-96 overflow-y-auto w-full p-5 bg-base-100 rounded-lg">
                    {!! $speaker->description !!}
                </div>
                <div class="w-full flex flex-col gap-2">
                    <h1 class="panel-label">Valid Documents</h1>
                    <a href="{{$speaker->valid_documents}}" class="venobox">
                        <img src="{{$speaker->valid_documents}}" alt="" srcset="" class="object object-center h-auto w-1/5">
                    </a>
                </div>

                <h1 class="panel-label font-bold">Events</h1>

                <table class="table">
                    <!-- head -->
                    <thead class="bg-secondary">
                        <tr>
                            <th></th>
                            <th>Name</th>
                            {{-- <th>Speaker</th>
                            <th>Date</th>
                            <th>Time</th> --}}
                            <td>Address</th>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>



                        @forelse ($events as $event)
                            <tr class="bg-base-100">
                                <th></th>
                                <td>{{ $event->name }}</td>
                                {{-- <td>{{ $event->speaker->fullName() }}</td>
                                <td>{{ $event->dateDuration() }}</td>
                                <td>{{ $event->timeDuration() }}</td> --}}
                                <td>{{ $event->address() }}</td>
                                 <td>
                                    <div class="flex items-center gap-2">
                                        <a href="{{route('events.show', ['event' => $event->id])}}" class="btn btn-xs btn-accent">
                                            <i class="fi fi-rr-eye"></i>
                                        </a>
                                  {{--      <a href="#" class="btn btn-xs btn-error">
                                            <i class="fi fi-rr-trash"></i>
                                        </a>--}}
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr class="bg-base-200">
                                <td>No Event</td>
                            </tr>
                        @endforelse


                    </tbody>
                </table>
            </div>
        </div>
    </div>



</x-dashboard.base>
