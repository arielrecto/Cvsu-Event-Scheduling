<x-dashboard.base>

    <div class="panel flex flex-col gap-2">
        <x-dashboard.header :route="route('announcements.index')" :event_name="'Announcement - ' . $announcement->title" />

        <h1 class="text-4xl text-center tracking-widest capitalize font-bold text-accent">
            {{ $announcement->title }}
        </h1>
        <p class="w-full text-end text-xs panel-label">
            <span class="font-bold">Posted At:{{ date('F d, Y', strtotime($announcement->created_at)) }}</span>
        </p>


        <div class="min-h-96 w-fulll max-h-max whitespace-pre-line bg-base-100 rounded-lg p-5">

            {!! $announcement->description !!}

        </div>


        @if ($announcement->images->count() !== 0)
            <div class="w-full h-96">

                <x-carousel :images="$announcement->images" />
            </div>
        @endif

    </div>

</x-dashboard.base>
