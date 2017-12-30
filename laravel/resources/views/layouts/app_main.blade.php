<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @yield('head')
</head>
<body>
    <div id="app">
    @yield('nav')

    @yield('content')
    @yield('input_modal')
    @yield('offer_modal')
    </div>
</body>
</html>
