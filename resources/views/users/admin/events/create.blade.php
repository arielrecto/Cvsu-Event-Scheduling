<x-dashboard.base>

    <div class="panel">
        <x-dashboard.header :route="route('events.index')" :event_name="'Event Create'" />
        {{-- <h1 class="panel-title">Event Create</h1> --}}

        <x-notification-message />
        <form action="{{ route('events.store') }}" method="post" class="flex flex-col gap-2" enctype="multipart/form-data">
            <div class="input-generic-div">
                <label for="" class="input-generic-label">Name</label>
                <input type="text" class="input input-accent" name="name" placeholder="Event Name">
                @if ($errors->has('name'))
                    <p class="text-xs text-error">{{ $errors->first('name') }}</p>
                @endif
            </div>


            @csrf

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
                <label for="" class="input-generic-label">Event Speaker (optional)</label>
                <div class="flex items-center gap-2">
                    <select name="speakers[]" multiple class="select select-accent w-full">
                        <option disabled selected>Select Host/Speaker</option>
                        @foreach ($speakers as $speaker)
                            <option value="{{ $speaker->id }}" class="capitalize">{{ $speaker->fullName() }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('speaker.create') }}" class="btn btn-accent">Add Event Speaker</a>
                </div>
                @if ($errors->has('speakers'))
                    <p class="text-xs text-error">{{ $errors->first('speakers') }}</p>
                @endif
            </div>

            <label for="" class="input-generic-label">Event Duration</label>
            <div class="grid grid-cols-2 grid-flow-row gap-5">
                <div class="input-generic-div" x-data="checkDateIsPast">
                    <label for="" class="input-generic-label">Start Date</label>
                    <input type="date" name="start_date" x-model="selectedDate" placeholder="Start Date"
                        class="input-generic">
                    @if ($errors->has('start_date'))
                        <p class="text-xs text-error">{{ $errors->first('start_date') }}</p>
                    @endif
                    <template x-if="message !== null">
                        <p class="text-xs text-error" x-text="message" />
                    </template>

                </div>
                <div class="input-generic-div" x-data="checkDateIsPast">
                    <label for="" class="input-generic-label">End Date</label>
                    <input type="date" name="end_date" x-model="selectedDate" placeholder="End Date"
                        class="input-generic">
                    @if ($errors->has('end_date'))
                        <p class="text-xs text-error">{{ $errors->first('end_date') }}</p>
                    @endif

                    <template x-if="message !== null">
                        <p class="text-xs text-error" x-text="message" />
                    </template>
                </div>
            </div>

            <label for="" class="input-generic-label">Event Duration per Day</label>
            <div class="grid grid-cols-2 grid-flow-row gap-5">
                <div class="input-generic-div">
                    <label for="" class="input-generic-label">Start Time</label>
                    <input type="time" name="start_time" class="input-generic">
                    @if ($errors->has('start_time'))
                        <p class="text-xs text-error">{{ $errors->first('start_time') }}</p>
                    @endif
                </div>
                <div class="input-generic-div">
                    <label for="" class="input-generic-label">End Time</label>
                    <input type="time" name="end_time" class="input-generic">
                    @if ($errors->has('end_time'))
                        <p class="text-xs text-error">{{ $errors->first('end_time') }}</p>
                    @endif
                </div>
            </div>



            <div class="input-generic-div" x-data="mapRender">
                <label for="" class="input-generic-label">Location</label>

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

            <div class="input-generic-div">
                <label for="" class="input-generic-label">Category</label>
                <div class="flex items-center gap-2">
                    <select name="category" class="select select-accent w-full">
                        <option disabled selected>Select Category</option>

                        <option value="online" class="capitalize">Online</option>

                        <option value="F2F" class="capitalize">Face to Face</option>

                    </select>
                    <a href="{{ route('speaker.create') }}" class="btn btn-accent">Add Event Speaker</a>
                </div>
                @if ($errors->has('category'))
                    <p class="text-xs text-error">{{ $errors->first('category') }}</p>
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
