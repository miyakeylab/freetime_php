@section('head')
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
    <link href="{{ secure_asset('css/assets/css/reset.css') }}" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    <!-- bootstrap -->
    <link href="{{ secure_asset('css/assets/css/bootstrap.css')}}" rel="stylesheet">
    <!-- bootstrap-glyphicons -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link href="{{ secure_asset('css/assets/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{ secure_asset('css/assets/css/docs.css')}}" rel="stylesheet">
    <!-- bootstrap social -->
    <link href="{{ secure_asset('css/bootstrap-social.css')}}" rel="stylesheet">
    <!-- bootstrap datetimepicker -->
    <link href="{{ secure_asset('css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
    <!-- my CSS -->
    <link href="{{ secure_asset('css/assets/css/style.css')}}" rel="stylesheet">
    <!-- favicon -->
    <link rel="icon" href="{{ secure_asset('css/assets/img/favicon.png')}}">
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    
    <!-- Scripts -->
    <!-- page=1　スケジュール -->
    @if($page === 1)
    <!-- scedule script -->
    <script src="{{ secure_asset('css/assets/js/schedule.js') }}"></script>
    @elseif($page === 2)
    <script src="{{ secure_asset('css/assets/js/friend.js') }}"></script>
    @endif
    <script src="{{ secure_asset('js/app.js') }}"></script>
    <!-- moment script -->
    <script src="{{ secure_asset('js/moment.min.js') }}"></script>
    <!-- bootstrap datetimepicker script -->
    <script src="{{ secure_asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- jquery floatThead script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/floatthead/1.4.5/jquery.floatThead.js"></script>
@endsection

