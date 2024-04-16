<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <link rel="shortcut icon" href="{{ asset('logo.ico') }}" type="image/x-icon">

    {{-- flaticon --}}
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.1.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>


    {{-- quill editor  css --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">


    {{-- leaflet css  --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />


    {{-- venovox --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/venobox/2.1.6/venobox.css"
        integrity="sha512-s+l15zg0IbE3rd3e24wM2Nne3q4bsueCUVmELW2EbU2NCp/gUdgnzfO9MHQ5OwqtUXxJ7H5mM5drz59BdApJNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    {{-- swipper --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-base-100">
        {{-- @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif --}}

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    {{-- full calendar --}}
    <script src="
            https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js
            "></script>


    {{-- quill editor --}}
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    {{-- leaftlet --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>


    {{-- venobox --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/venobox/2.1.6/venobox.min.js"></script>


    {{-- Apex Chart --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    {{-- swipper --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


    <script>
        new VenoBox({
            selector: '.venobox'
        })
    </script>


    @stack('js')

</body>

</html>
