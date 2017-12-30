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
    @yield('change_modal')
    @yield('offer_modal')
    @yield('group_modal')
    @yield('friend_modal')
    </div>
</body>
</html>
