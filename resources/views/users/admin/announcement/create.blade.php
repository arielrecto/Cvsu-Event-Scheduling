<x-dashboard.base>
    <div class="panel flex flex-col gap-2">
        <h1 class="panel-title">Announcement</h1>

        <x-notification-message />
        <form action="{{ route('announcements.store') }}" method="post" class="flex flex-col gap-2 w-full" enctype="multipart/form-data">

            @csrf
            <div class="input-generic-div">
                <label for="" class="input-generic-label">Title</label>
                <input type="text" name="title" class="input-generic" placeholder="ex: Sample title" value="{{old('title')}}">


                @if ($errors->has('title'))
                    <p class="text-xs text-error">{{ $errors->first('title') }}</p>
                @endif
            </div>


            <div class="input-generic-div">
                <label for="" class="input-generic-label">Images</label>
                <input type="file" name="images[]" multiple class="file-input file-input-accent">


                @if ($errors->has('title'))
                    <p class="text-xs text-error">{{ $errors->first('title') }}</p>
                @endif
            </div>

            <div class="input-generic-div" x-data="textEditor">
                <label for="" class="input-generic-label">Description</label>
                <div class="min-h-64 max-h-96 overflow-y-auto" x-ref="editor">

                </div>
                @if ($errors->has('descriptions'))
                    <p class="text-xs text-error">{{ $errors->first('descriptions') }}</p>
                @endif
                <input type="hidden" name="description" x-model="descriptions">

                <button class="btn btn-accent" @click="getContent">Submit</button>
            </div>
        </form>
    </div>
</x-dashboard.base>
