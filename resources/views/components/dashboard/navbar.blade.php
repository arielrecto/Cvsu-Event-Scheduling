<div class="w-full h-auto flex justify-center bg-accent">
    <div class="w-4/6 p-2 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <x-application-logo class="h-16 w-16 object object-center"/>
            <h1 class="text-xl font-bold tracking-wider text-primary">
                Computer Studies Department, CvSU Bacoor City Campus Event Scheduling
            </h1>
        </div>
        <form action="{{route('logout')}}" method="post" class="flex justify-center gap-2">
            <span class="text-white capitalize">
                {{Auth::user()->name}}
            </span>

            @csrf
            <button class="btn btn-xs btn-accent text-lg">
                <i class="fi fi-rr-sign-out-alt"></i>
            </button>
        </form>
    </div>
</div>
