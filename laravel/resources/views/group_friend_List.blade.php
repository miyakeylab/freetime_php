<!-- resources/views/group_friend_List.blade.php -->

@extends('layouts.app')
@include('layouts.head', ['page' => 2])
@include('layouts.nav')


@section('content')
    <!-- 友達 -->
    <div class="container" >

        <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
        <div class="panel-heading">友達一覧</div>
        <div class="panel-body">
        @if (count($friends) > 0)
            <?php $i=0; ?>
            <!-- 友達一覧 -->
            @foreach ($friends as $friend)
            <?php if($i !== 0){ ?>
            <hr class="style-one">
            <?php } ?>
            <?php $i++; ?>
            <div class="media">
                <!-- 1.画像の配置 -->
                <a class="media-left" href="{{ url('/user_schedule',$friend->friend_user_id) }}">
                    <img class="media-object" src="{{url($friend->user_img)}}">
                </a>
                <!-- 2.画像の説明 -->
                <div class="media-body">
                    @if($friend->name !== "")
                    <h4 class="media-heading">{{ $friend->name }}</h4>
                    @endif
                    <p>{{ $friend->user_content."/".__('messages.user_sex')[$friend->user_sex]."/".$friend->user_birthday }}</p>
                </div>
            </div>
            @endforeach
            
        @endif
        </div>
        </div>
        </div>
        </div>
 
@endsection