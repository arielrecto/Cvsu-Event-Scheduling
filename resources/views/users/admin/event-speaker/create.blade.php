<x-dashboard.base>
    <div class="panel">
        <h1 class="panel-title">Event Speaker Create</h1>
        <form action="{{ route('speaker.store') }}" method="POST" class="w-full flex flex-col gap-2" enctype="multipart/form-data">
            @csrf
            <p class="text-xs text-secondary">All label input has <span class="text-error">*</span> is required field</p>
            <label for="" class="input-generic-label">Image <span>*</span></label>
            <div class="flex items-center justify-center w-full" x-data="imageUploadHandler">

                <label for="dropzone-file" x-show="image === null"
                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50
                     hover:bg-gray-100 ">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 "><span class="font-semibold">Click to
                                upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 "> PNG, JPG </p>
                    </div>
                    <input id="dropzone-file" name="image" type="file" class="hidden"
                        @change="uploadHandler($event)" />
                </label>

                <template x-if="image !== null">
                    <img :src="image" alt="" srcset="" class="object object-center w-1/2 h-auto">
                </template>

            </div>
            @if ($errors->has('image'))
                <p class="text-xs text-error">{{ $errors->first('image') }}</p>
            @endif
            <div class="grid grid-cols-3 grid-flow-row gap-5">
                <div class="input-generic-div">
                    <label for="" class="input-generic-label">Last Name <span>*</span></label>
                    <input type="text" name="last_name" class="input-generic" placeholder="Last Name" value="{{old('last_name')}}">
                    @if ($errors->has('last_name'))
                        <p class="text-xs text-error">{{ $errors->first('last_name') }}</p>
                    @endif
                </div>

                <div class="input-generic-div">
                    <label for="" class="input-generic-label">First Name <span>*</span></label>
                    <input type="text" name="first_name" class="input-generic" placeholder="First Name" value="{{old('first_name')}}">
                    @if ($errors->has('first_name'))
                        <p class="text-xs text-error">{{ $errors->first('first_name') }}</p>
                    @endif
                </div>
                <div class="input-generic-div">
                    <label for="" class="input-generic-label">Middle Name (Optional)</label>
                    <input type="text" name="middle_name" class="input-generic" placeholder="Middle Name" value="{{old('middle_name')}}">
                </div>
            </div>
            <div class="grid grid-cols-2 grid-flow-row gap-5">
                <div class="input-generic-div">
                    <label for="" class="input-generic-label">Age <span>*</span></label>
                    <input type="number" class="input-generic" name="age" placeholder="age" value="{{old('age')}}">
                    @if ($errors->has('age'))
                        <p class="text-xs text-error">{{ $errors->first('age') }}</p>
                    @endif
                </div>
                <div class="input-generic-div">
                    <label for="" class="input-generic-label">Gender <span>*</span></label>
                    <select class="select select-accent w-full" name="gender">
                        <option disabled selected>Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    @if ($errors->has('gender'))
                        <p class="text-xs text-error">{{ $errors->first('gender') }}</p>
                    @endif
                </div>
            </div>
            <div class="input-generic-div">
                <label for="" class="input-generic-label">Address <span>*</span> </label>
                <input type="text" name="address" class="input-generic" placeholder="Address" value="{{old('address')}}">
                @if ($errors->has('address'))
                    <p class="text-xs text-error">{{ $errors->first('address') }}</p>
                @endif
            </div>
            <div class="input-generic-div">
                <label for="" class="input-generic-label">Occupation <span>*</span></label>
                <input type="text" name="occupation" class="input-generic" placeholder="Ex: Instructor|student|etc." value="{{old('occupation')}}">
                @if ($errors->has('occupation'))
                    <p class="text-xs text-error">{{ $errors->first('occupation') }}</p>
                @endif
            </div>

            <div class="input-generic-div">
                <label for="" class="input-generic-label">Description</label>
                <textarea id="" cols="30" name="description" rows="10" class="textarea textarea-accent">

                </textarea>
                @if ($errors->has('description'))
                <p class="text-xs text-error">{{ $errors->first('description') }}</p>
            @endif
            </div>
            <div class="input-generic-div">
                <label for="" class="input-generic-label">Valid Documents <span>*</span></label>
                <p class="text-xs text-secondary">file format required : jpg, png, jpeg</p>
                <input type="file" name="valid_document" class="file-input file-input-accent"
                    placeholder="Ex: student Id|Cetificate">

                @if ($errors->has('valid_document'))
                    <p class="text-xs text-error">{{ $errors->first('valid_document') }}</p>
                @endif
            </div>
            <button class="btn btn-accent">Submit</button>
        </form>
    </div>
</x-dashboard.base>
