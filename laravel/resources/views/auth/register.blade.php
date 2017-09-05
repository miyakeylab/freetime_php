@extends('layouts.app')
@include('layouts.head',['page' => 0])
@include('layouts.nav')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-btn fa-sign-in"></i>{{__('messages.login_sns_login_title')}}</div>
                <div class="panel-body">
                    <div class="col-md-6 col-md-offset-3">
                    <div class="padding-top-10 ">
                    <a href="{{ url('/auth/google')}}" class="btn btn-social btn-google">
                        <i class="fa fa-google"></i>{{__('messages.login_sns_go')}}</a>
                        </div>
                         <div class="padding-top-10">
                    <a href="{{ url('/auth/facebook')}}" class="btn btn-social btn-facebook">
                        <i class="fa fa-facebook"></i>{{__('messages.login_sns_fb')}}</a>
                         </div>
                          <div class="padding-top-10">
                    <a href="{{ url('/auth/twitter')}}" class="btn btn-social btn-twitter">
                        <i class="fa fa-twitter"></i>{{__('messages.login_sns_tw')}}</a>
                         </div>
                          <div class="padding-top-10">
                    <a href="{{ url('/auth/github')}}" class="btn btn-social btn-github">
                        <i class="fa fa-github"></i>{{__('messages.login_sns_gi')}}</a> 
                         </div>
                         </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-btn fa-lock"></i>{{__('messages.register_title')}}</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">{{__('messages.register_name')}}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">{{__('messages.login_mail')}}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">{{__('messages.login_pass')}}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">{{__('messages.register_pass_conf')}}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    {{__('messages.register_button_label')}}
                                </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
