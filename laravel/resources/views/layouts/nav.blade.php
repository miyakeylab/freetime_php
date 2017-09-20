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
                    <!-- ユーザー名 -->
                    @if (!Auth::guest())
                    <li><a>{{ __('messages.nav_welcome', ['name' => Auth::user()->name]) }}</a></li>
                    @endif
                    <!-- 言語切り替え -->
                    <li class="dropdown" id="nav-lang">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            {{ Config::get('languages')[App::getLocale()] }}
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @foreach (Config::get('languages') as $lang => $language)
                                @if ($lang != App::getLocale())
                                    <li>
                                        <a href="{{ route('lang.switch', $lang) }}">{{$language}}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                    <!-- ログイン前 -->
                        <li><a href="{{ url('/login') }}"><i class="fa fa-btn fa-sign-in"></i> </a></li>
                        <li><a href="{{ url('/register') }}"><i class="fa fa-btn fa-lock"></i> </a></li>
                    @else
                    <!-- ログイン後メニュー -->
                        <li class="dropdown">
                            <li><a href="{{ url('/my_schedule') }}"><i class="fa fa-btn fa-calendar"></i> </a></li>
                            <li><a href="{{ url('/friend') }}"><i class="fa fa-btn fa-user"></i> 
                            @if(count($friend_offer_count) > 0)
                                <span class="badge">{{ count($friend_offer_count) }}</span>
                            @endif
                            </a></li>
                            <li><a href="{{ url('/offer') }}"><i class="fa fa-btn fa-envelope-o"></i> 
                            @if(count($offer_count) > 0)
                                <span class="badge">{{ count($offer_count) }}</span>
                            @endif
                            </a></li>
                            <li><a href="{{ url('/group') }}"><i class="fa fa-btn fa-users"></i> 
                            @if(count($group_offer_count) > 0)
                                <span class="badge">{{ count($group_offer_count) }}</span>
                            @endif</a></li>
                            <!--<li><a href="{{ url('/google_api') }}"><i class="fa fa-btn fa-google"></i> </a></li>-->
                            <li><a href="{{ url('/setting') }}"><i class="fa fa-btn fa-cog"></i> </a></li>
                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-btn fa-sign-out"></i> </a>
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

