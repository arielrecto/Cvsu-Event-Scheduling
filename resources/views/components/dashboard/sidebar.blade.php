@php
    $routes_links = [
        [
            'url' => 'dashboard',
            'icon' => 'fi fi-rr-dashboard mt-1',
            'name' => 'Dashboard',
        ],
        [
            'url' => 'announcements.index',
            'icon' => 'fi fi-rr-megaphone mt-1',
            'name' => 'Announcement',
        ],
        [
            'url' => 'events.index',
            'icon' => 'fi fi-rr-calendar-day mt-1',
            'name' => 'Events',
        ],
        [
            'url' => 'speaker.index',
            'icon' => 'fi fi-rr-user mt-1',
            'name' => 'Speaker/Host',
        ],
        [
            'url' => 'students.index',
            'icon' => 'fi fi-rr-users-alt mt-1',
            'name' => 'Students',
        ],
    ];
@endphp


<div class="w-1/4 h-full flex flex-col gap-2 p-2 bg-white rounded-lg hover:show-lg">

    @foreach ($routes_links as $link)
    <div class="w-full flex justify-center  rounded-lg duration-700 {{ Route::is($link['url']) ? 'text-primary font-bold bg-secondary' : 'hover:text-primary hover:font-bold hover:bg-secondary'}} ">
        <a href="{{ Route($link['url']) }}" class="text-lg flex items-center p-2 gap-2 w-5/6">
            <i class="{{ $link['icon'] }}"></i>
            <span>
                {{ $link['name'] }}
            </span>
        </a>
    </div>

    @endforeach

</div>
