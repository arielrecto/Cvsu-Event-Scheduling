@php
    $routes_links = [
        [
            'url' => 'faculty.dashboard',
            'icon' => 'fi fi-rr-dashboard mt-1',
            'name' => 'Dashboard',
        ],
        [
            'url' => 'faculty.events.index',
            'icon' => 'fi fi-rr-calendar-day mt-1',
            'name' => 'Events',
        ],
    ];
@endphp

<x-app-layout>
    <x-dashboard.navbar />
    <div class="flex gap-5 h-[40rem] justify-center">
        <div class="w-4/6 h-full flex p-2 gap-5">
            <div class="w-1/4 h-full flex flex-col gap-2 p-2 bg-white rounded-lg hover:show-lg">

                @foreach ($routes_links as $link)
                    <div
                        class="w-full flex justify-center  rounded-lg duration-700 {{ Route::is($link['url']) ? 'font-bold bg-secondary' : 'hover:text-primary hover:font-bold hover:bg-secondary' }} ">
                        <a href="{{ Route($link['url']) }}" class="text-lg flex items-center p-2 gap-2 w-5/6">
                            <i class="{{ $link['icon'] }}"></i>
                            <span>
                                {{ $link['name'] }}
                            </span>
                        </a>
                    </div>
                @endforeach

            </div>

            <div class="h-full w-full flex flex-col gap-2 overflow-y-auto">
                <main>
                    {{ $slot }}
                </main>
            </div>

        </div>
    </div>
</x-app-layout>
