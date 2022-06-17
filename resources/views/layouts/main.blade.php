<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
{{--    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>--}}
    <script src="{{ asset('js/swiper.js') }}" defer></script>
    <script src="{{ asset('js/slider.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/movie.js') }}" defer></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    @if (request()->is('profile'))
        <script src="{{ asset('js/dragdrop.js') }}" defer></script>
    @endif

    <!-- Styles -->
{{--    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css"/>--}}
    <link rel="stylesheet" href="{{ asset('css/swiper.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Fonts -->
    <link href="//fonts.gstatic.com" rel="dns-prefetch">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<div class="main-wrapper">
    @include('blocks.menu')
    <div class="main-content">
        @yield('content')
    </div>
    @include('blocks.footer')
</div>
</body>
</html>
