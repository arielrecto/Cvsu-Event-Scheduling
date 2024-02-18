@props([
    'route' => null,
    'value' => null
])

<form action="{{$route}}" method="GET" class="max-w-md min-w-96">
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
    <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
        </div>
        <input type="search" id="default-search" name="search"
            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-secondary rounded-lg bg-base-100
             focus:ring-accent focus:border-accent
             "
             value="{{$value}}"
            placeholder="{{$value}}"/>
        <button type="submit"
            class="text-white absolute end-2.5 bottom-2.5 btn btn-accent top-1 ">Search</button>
    </div>
</form>
