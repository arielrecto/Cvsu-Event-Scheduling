<x-app-layout>
    <x-dashboard.navbar/>
    <div class="flex gap-5 h-[40rem] justify-center">
        <div class="w-4/6 h-full flex p-2 gap-5">
            <x-dashboard.sidebar/>
            <div class="h-full w-full flex flex-col gap-2 overflow-y-auto">
                <main>
                    {{ $slot }}
                </main>
            </div>

        </div>
    </div>
</x-app-layout>
