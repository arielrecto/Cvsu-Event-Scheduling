<x-dashboard.instructor>
    <div class="panel">
        <h1 class="panel-title">Add Section</h1>

        <x-notification-message />
        <form action="{{ route('faculty.sections.store') }}" method="POST" class="w-full flex flex-col gap-2"
            enctype="multipart/form-data">
            @csrf

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
                    <select class="select select-accent w-full" name="sections[]" multiple>
                        <option disabled selected>Select Section</option>
                        <template x-for="section in sections">
                            <option :value="section.id"><span x-text="`${section.year} - ${section.number}`" />
                            </option>
                        </template>
                    </select>
                    @if ($errors->has('section'))
                        <p class="text-xs text-error">{{ $errors->first('section') }}</p>
                    @endif
                </div>
            </div>
            <button class="btn btn-sm btn-accent">Add Section</button>
        </form>
    </div>
</x-dashboard.instructor>
