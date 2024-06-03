@php

    //    $events = $speaker->events;
@endphp

<x-dashboard.base>

    <div class="panel flex flex-col gap-2">
        <x-dashboard.header :route="route('students.index')" :event_name="'Student - ' . $student->profile->fullName()" />

        <x-notification-message/>


        @if ($student->profile->verified_at === null)
            <div class="w-full flex items-center justify-between">
                <h1 class="input-generic-label"><span>*</span> Review all the information of the student for verification</h1>
                <div class="flex items-center gap-2">
                    <a href="{{route('students.approved', ['student' => $student->id])}}" class="btn btn-success btn-xs">verified</a>

                    <a href="{{route('students.reject', ['student' => $student->id])}}" class="btn btn-xs btn-error">Reject</a>
                </div>
            </div>
        @endif

        <div class="flex gap-5">
            <div class="w-1/5 h-96 flex flex-col gap-2 capitalize mt-5">
                <a href="{{ $student->profile->image }}" class="venobox">
                    <img src="{{ $student->profile->image }}" alt="" srcset=""
                        class="h-34 w-full rounded-full object object-center ">
                </a>

                <h1 class="text-xl font-bold text-center">{{ $student->profile->fullName() }}</h1>
                <p class="text-center text-accent text-sm flex flex-col">
                    <span>Date Added:</span>
                    <span> {{ $student->profile->dateCreated() }}</span>
                </p>
            </div>


            <div class="flex flex-col gap-2 p-5 capitalize w-full">
                <h1 class="panel-label font-bold">
                    Account Detail
                </h1>
                <div class="grid grid-cols-2 grid-flow-row gap-2">
                    <div class="flex flex-col gap-2">
                        <h1 class="panel-label">Username </h1>
                        <p>{{ $student->name }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h1 class="panel-label">Email {{$studen->email_verified_at ? 'Email Verified' : 'Not Verified'}} </h1>
                        <p>{{ $student->email }}</p>
                    </div>
                </div>
                <h1 class="panel-label font-bold">Personal Information</h1>
                <div class="flex flex-col gap-2">
                    <h1 class="panel-label">Student ID </h1>
                    <p class="font-bold tracking-widest">{{ $student->profile->student_id }}</p>
                </div>
                <div class="grid grid-cols-3 grid-flow-row gap-2 w-full">
                    <div class="flex flex-col gap-2">
                        <h1 class="panel-label">Last Name</h1>
                        <p>{{ $student->profile->last_name }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h1 class="panel-label">First Name</h1>
                        <p>{{ $student->profile->first_name }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h1 class="panel-label">Middle Name</h1>
                        <p>{{ $student->profile->middle_name }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h1 class="panel-label">age</h1>
                        <p>{{ $student->profile->age }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h1 class="panel-label">Course</h1>
                        <p>{{ $student->profile->course->name }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h1 class="panel-label">Year & Section</h1>
                        <p>{{ $student->profile->section->year }} - {{$student->profile->section->number}}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h1 class="panel-label">gender</h1>
                        <p>{{ $student->profile->gender }}</p>
                    </div>
                </div>
                <div class="w-full flex flex-col gap-2">
                    <h1 class="panel-label">Address</h1>
                    <p>
                        {{ $student->profile->address }}
                    </p>
                </div>
                {{--     <div class="w-full flex flex-col gap-2">
                    <h1 class="panel-label">Occupation</h1>
                    <p>
                        {{$speaker->occupation}}
                    </p>
                </div>
                <h1 class="panel-label">Description</h1>
                <div class="min-h-64 max-h-96 overflow-y-auto w-full p-5 bg-base-100 rounded-lg">
                    {!! $speaker->description !!}
                </div> --}}
                <div class="w-full flex flex-col gap-2">
                    <h1 class="panel-label">Valid Documents</h1>
                    <a href="{{ $student->profile->valid_documents }}" class="venobox">
                        <img src="{{ $student->profile->valid_documents }}" alt="" srcset=""
                            class="object object-center h-auto w-1/5">
                    </a>
                </div>
            </div>
        </div>

    </div>


</x-dashboard.base>
