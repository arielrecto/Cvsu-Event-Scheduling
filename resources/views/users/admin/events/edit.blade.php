<x-dashboard.base>

    <div class="panel">
        <x-dashboard.header :route="route('events.index')" :event_name="'Event Edit'" />
        {{-- <h1 class="panel-title">Event Create</h1> --}}

        <x-notification-message/>
        <form action="{{ route('events.update', ['event' => $event->id]) }}" method="post" class="flex flex-col gap-2" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="input-generic-div">
                <label for="" class="input-generic-label">Event Speaker
                    <p class="text-xs text-accent capitalize">{{$event->speaker->fullName()}}</p>
                </label>
                <div class="flex items-center gap-2">
                    <select name="speaker" class="select select-accent w-full">
                        <option disabled selected>Select Host/Speaker</option>
                        @foreach ($speakers as $speaker)
                            <option value="{{ $speaker->id }}" class="capitalize">{{ $speaker->fullName() }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('speaker.create') }}" class="btn btn-accent">Add Event Speaker</a>
                </div>
                @if ($errors->has('speaker'))
                    <p class="text-xs text-error">{{ $errors->first('speaker') }}</p>
                @endif
            </div>
            <div class="flex justify-center min-h-24" x-data="imageUploadHandler">
                <div class="w-1/2 h-full">
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file" x-show="image === null"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50
                             hover:bg-gray-100 ">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 " aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 "><span class="font-semibold">Click to
                                        upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 "> PNG, JPG </p>
                            </div>
                            <input id="dropzone-file" name="image" type="file" class="hidden"
                                @change="uploadHandler($event)" />
                        </label>
                    </div>
                    <template x-if="image !== null">
                        <img :src="image" alt="" class="object object-center w-1/2 h-auto">
                    </template>
                </div>
            </div>
            @if ($errors->has('image'))
                <p class="text-xs text-error">{{ $errors->first('image') }}</p>
            @endif
            <div class="input-generic-div">
                <label for="" class="input-generic-label">Name <p class="text-xs text-accent capitalize">{{$event->name}}</p></label>
                <input type="text" class="input input-accent" name="name" placeholder="Event Name">
                @if ($errors->has('name'))
                    <p class="text-xs text-error">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <label for="" class="input-generic-label">Event Duration</label>
            <div class="grid grid-cols-2 grid-flow-row gap-5">
                <div class="input-generic-div">
                    <label for="" class="input-generic-label">Start Date: <p class="text-xs text-accent">{{$event->start_date}}</p></label>
                    <input type="date" name="start_date" placeholder="Start Date" class="input-generic">
                    @if ($errors->has('start_date'))
                        <p class="text-xs text-error">{{ $errors->first('start_date') }}</p>
                    @endif
                </div>
                <div class="input-generic-div">
                    <label for="" class="input-generic-label">End Date  <p class="text-xs text-accent">{{$event->end_date}}</p></label>
                    <input type="date" name="end_date" placeholder="End Date" class="input-generic">
                    @if ($errors->has('end_date'))
                        <p class="text-xs text-error">{{ $errors->first('end_date') }}</p>
                    @endif
                </div>
            </div>

            <label for="" class="input-generic-label">Event Duration per Day</label>
            <div class="grid grid-cols-2 grid-flow-row gap-5">
                <div class="input-generic-div">
                    <label for="" class="input-generic-label">Start Time <p class="text-xs text-accent">{{date('h:s A', strtotime($event->start_time)) }}</p></label>
                    <input type="time" name="start_time" class="input-generic">
                    @if ($errors->has('start_time'))
                        <p class="text-xs text-error">{{ $errors->first('start_time') }}</p>
                    @endif
                </div>
                <div class="input-generic-div">
                    <label for="" class="input-generic-label">End Time <p class="text-xs text-accent">{{ date('h:s A', strtotime($event->end_time))}}</p></label>
                    <input type="time" name="end_time" class="input-generic">
                    @if ($errors->has('end_time'))
                        <p class="text-xs text-error">{{ $errors->first('end_time') }}</p>
                    @endif
                </div>
            </div>

            @php
                $location = json_decode($event->location);
            @endphp

            <div class="input-generic-div" x-data="mapRender">
                <label for="" class="input-generic-label">Location
                    <p class="text-xs text-accent">{{$location->address}}</p>
                </label>

                <div x-ref="map" class="h-96 w-full">

                </div>

                <div class="relative">
                    <input type="text" class="input-generic w-full" placeholder="Locations"
                        x-model="locations.address">
                    <div class="absolute top-0 w-full h-full">

                    </div>
                    <input type="hidden" name="locations" x-model="JSON.stringify(locations)">
                </div>

                @if ($errors->has('locations'))
                    <p class="text-xs text-error">{{ $errors->first('locations') }}</p>
                @endif
            </div>
    </div>

    <div class="h-auto w-auto flex flex-col gap-2" x-data="textEditor">
        <div class="input-generic-div">
            <label for="" class="input-generic-label">Descriptions</label>
            <div x-ref="editor" class="min-h-24 max-h-34 w-full">
            </div>
            <input type="hidden" name="description" x-model="descriptions">
        </div>

        <button class="btn btn-accent" @click="getContent">Submit</button>
    </div>
    </form>
    </div>

</x-dashboard.base>
