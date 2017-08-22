<!-- resources/views/friend.blade.php -->

@extends('layouts.app')

@section('content')
    <!-- 友達 -->
    <div class="container" >
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fa fa-btn fa-user-plus"></i> 友達追加</button>
        @if (count($friends) > 0)
        <div class="panel panel-default">
        <div class="panel-heading">友達一覧</div>
        <div class="panel-body">
        <!-- 友達一覧 -->
            @foreach ($friends as $friend)
            <div class="media">
                <!-- 1.画像の配置 -->
                <a class="media-left" href="#">
                    <img class="media-object" src="{{url($friend->user_img)}}">
                </a>
                <!-- 2.画像の説明 -->
                <div class="media-body">
                    <h4 class="media-heading">{{ $friend->name }}</h4>
                    <p>{{ $friend->user_content."/".$friend->user_sex."/".$friend->user_birthday }}</p>
                </div>
            </div>
            @endforeach
            </div>
            </div>
            </div>
        @endif
     </div>
@endsection