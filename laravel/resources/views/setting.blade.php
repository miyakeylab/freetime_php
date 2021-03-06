<!-- resources/views/setting.blade.php -->

@extends('layouts.app')
@include('layouts.head', ['page' => 1])
@include('layouts.nav')

@section('content')
    <!-- 設定 -->
    <div class="container">    
      <div class="row">
          <div class="panel panel-default">
          <div class="panel-heading">  <h4 >{{ __('messages.setting_title') }}</h4></div>
           <div class="panel-body">
          <div class="col-md-4 col-xs-12 col-sm-6 col-lg-4">
           <img alt="User Pic" src="{{ url($userdetail->user_img) }}" id="profile-image1" class="img-circle user_setting_size"> 
         
     
          </div>
          <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8 user-setting-font" >
              <div class="container" >
                <h2>{{"Name: ".$userdetail->user_name}}</h2>
                <p></p>
              </div>
               <hr>
              <ul class="container details" >
                <li><p><span class="glyphicon glyphicon-user one" ></span> {{$userdetail->content}}</p></li>
                <li><p><span class="glyphicon glyphicon-envelope one"></span> {{$user->email}}</p></li>
              </ul>
              <hr>
              <div class="col-sm-5 col-xs-6 tital">{{ $birthday }}</div>
          </div>
    </div>
</div>
</div>
@endsection