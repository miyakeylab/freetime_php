@section('nav')
    <nav class="navbar navbar-default navbar-static-top navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <img class="media-object" src="{{url('css/assets/img/favicon.ico')}}" width="18" height="18">
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
                            <li><a href="{{ url('/my_schedule') }}"><i class="fa fa-btn fa-calendar"></i> </a></li>
                            <li><a href="{{ url('/friend') }}"><i class="fa fa-btn fa-user"></i> <span class="badge">26</span></a></li>
                            <li><a href="{{ url('/offer') }}"><i class="fa fa-btn fa-envelope-o"></i> <span class="badge">26</span></a></li>
                            <li><a href="{{ url('/group') }}"><i class="fa fa-btn fa-users"></i> </a></li>
                            <li><a href="{{ url('/google_api') }}"><i class="fa fa-btn fa-google"></i> </a></li>
                            <li><a href="{{ url('/setting') }}"><i class="fa fa-btn fa-cog"></i> </a></li>
                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-btn fa-sign-out"></i> ログアウト</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form></li>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endsection

