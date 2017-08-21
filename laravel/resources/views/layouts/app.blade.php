<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">-->
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/assets/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{ secure_asset('css/assets/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{ secure_asset('css/assets/css/docs.css')}}" rel="stylesheet">
    <link href="{{ secure_asset('css/bootstrap-social.css')}}" rel="stylesheet">
    <link href="{{ secure_asset('css/assets/css/style.css')}}" rel="stylesheet">
    <!-- favicon -->
    <link rel="icon" href="{{ secure_asset('css/assets/img/favicon.ico')}}">
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    
</head>
<body>
    <div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/home') }}"></a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav navbar-left">
                    @if (!Auth::guest())
                    <li><a>{{ "ようこそ".Auth::user()->name."さん" }}</a></li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">ログイン</a></li>
                        <li><a href="{{ url('/register') }}">新規登録</a></li>
                    @else
                        <li class="dropdown">
                            <!--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">-->
                            <!--    {{ Auth::user()->name }} <span class="caret"></span>-->
                            <!--</a>-->
                            <!--<ul class="dropdown-menu" role="menu">-->
                            <!--<li>    -->

                            <!--</ul>-->
                            <li><a href="{{ url('/my_schedule') }}">スケジュール</a></li>
                            <li><a href="{{ url('/friend') }}">友達</a></li>
                            <li><a href="{{ url('/offer') }}">オファー</a></li>
                            <li><a href="{{ url('/group') }}">グループ</a></li>
                            <li><a href="{{ url('/google_api') }}">連携</a></li>
                            <li><a href="{{ url('/setting') }}">設定</a></li>
                            <li><a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-btn fa-sign-out"></i>
                                            ログアウト
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form></li>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ secure_asset('js/app.js') }}"></script>
</body>
</html>
