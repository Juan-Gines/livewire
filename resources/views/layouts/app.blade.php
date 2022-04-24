<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('vendor\fontawesome-free\css\all.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    @stack('css') {{-- Colocamos nuestros archivos css --}}

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    {{-- Agregamos libreria mensajes de alerta --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body class="font-sans antialiased">
    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 ">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts

    @stack('js') {{-- Colocamos nuestros archivos js --}}

    {{-- Ponemos el script que va a escuchar el evento alert cuando se dispare --}}

    <script>
        Livewire.on('alert', (title, message) => {
            console.log(title, message);
            swal({
                title: title,
                text: message,
                icon: "success",
                button: "CONTINUAR",
            });
        })
    </script>
</body>

</html>
