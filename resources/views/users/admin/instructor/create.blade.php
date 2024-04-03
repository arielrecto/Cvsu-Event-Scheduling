<x-dashboard.base>
    <div class="panel">
        <h1 class="panel-title">Faculty Member</h1>

        <x-notification-message />
        <form action="{{route('instructors.store')}}" method="POST" class="w-full flex flex-col gap-2" enctype="multipart/form-data">
            @csrf


            {{-- <p class="text-xs text-secondary">All label input has <span class="text-error">*</span> is required field</p> --}}

            <h1 class="panel-label flex flex-col">
                Account
                <p class="input-generic-label">
                    Note: sample note
                </p>
            </h1>
            <div class="flex flex-col gap-2">
                <div class="input-generic-div">
                    <label for="" class="input-generic-label">Username <span>*</span></label>
                    <input type="text" name="name" class="input-generic" placeholder="">
                    @if ($errors->has('email'))
                        <p class="text-xs text-error">{{ $errors->first('name') }}</p>
                    @endif
                </div>
                <div class="input-generic-div">
                    <label for="" class="input-generic-label">Email <span>*</span></label>
                    <input type="email" name="email" class="input-generic" placeholder="">
                    @if ($errors->has('email'))
                        <p class="text-xs text-error">{{ $errors->first('email') }}</p>
                    @endif
                </div>
                <div class="input-generic-div">
                    <label for="" class="input-generic-label">Password <span>*</span></label>
                    <input type="password" name="password" class="input-generic">
                    @if ($errors->has('password'))
                        <p class="text-xs text-error">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <div class="input-generic-div">
                    <label for="" class="input-generic-label">Confirm Password<span>*</span></label>
                    <input type="password" name="password_confirmation" class="input-generic">
                    {{-- @if ($errors->has('email'))
                        <p class="text-xs text-error">{{ $errors->first('email') }}</p>
                    @endif --}}
                </div>
            </div>

            <h1 class="panel-label">
                Profile
            </h1>

            <div class="grid grid-cols-2 grid-flow-row gap-2" x-data="getSections">
                <div class="input-generic-div">
                    <label for="" class="input-generic-label">Course </label>
                    <select class="select select-accent w-full" name="course" x-model="course">
                        <option disabled selected>Select</option>
                        @forelse ($courses as $course)
                            <option value="{{ $course->name }}">{{ $course->name }}</option>
                        @empty
                            <option disabled>No Course</option>
                        @endforelse

                    </select>
                    @if ($errors->has('course'))
                        <p class="text-xs text-error">{{ $errors->first('course') }}</p>
                    @endif
                </div>
                <div class="input-generic-div">
                    <label for="" class="input-generic-label">Section</label>
                    {{-- <input type="number" class="input-generic" name="section"
                        placeholder="{{ $profile->section }}"> --}}
                    <select class="select select-accent w-full" name="section">
                        <option disabled selected>Select Section</option>
                        <template x-for="section in sections">
                            <option :value="section.id"><span x-text="`${section.year} - ${section.number}`" /></option>
                        </template>
                    </select>
                    @if ($errors->has('section'))
                        <p class="text-xs text-error">{{ $errors->first('section') }}</p>
                    @endif
                </div>
            </div>
            <button class="btn btn-accent">Submit</button>
        </form>
    </div>
</x-dashboard.base>
