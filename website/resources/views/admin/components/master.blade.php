<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ env('APP_TITLE') }} - @yield('title')</title>

    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main/app-dark.css') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/img/icon/favicon.ico') }}" type="image/x-icon" />
    <link href="{{ asset('assets/img/icon/') }}" rel="apple-touch-icon">

    <link rel="stylesheet" href="{{ asset('assets/css/shared/iconly.css') }}" />

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 81%;
            /* Warna latar belakang */
            padding: 20px;
            /* Atur jarak di dalam footer */
        }
    </style>
    @stack('head')
</head>

<body>
    @include('sweetalert::alert')
    <div id="app">
        @include('admin.components.sidebar')

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            @yield('container')

            @include('admin.components.footer')
        </div>
    </div>


    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @stack('scripts')



</body>

</html>
