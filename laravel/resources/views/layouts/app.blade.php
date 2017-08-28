<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @yield('head')
</head>
<body>
    <div id="app">
    @yield('nav')

    @yield('content')
    </div>
</body>
</html>
