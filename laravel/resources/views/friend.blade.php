<!-- resources/views/friend.blade.php -->

@extends('layouts.app')

@section('content')
    <!-- 友達 -->
    <div class="container" >

        
        @if (count($friends) > 0)
        <div class="panel panel-default">
        <div class="panel-heading">友達一覧</div>
        <div class="panel-body">
        <!-- 友達一覧 -->
            @foreach ($friends as $friend)
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
                    <p>{{ $friend->user_content."/".$friend->user_sex."/".$friend->user_birthday }}</p>
                </div>
            </div>
            @endforeach
            </div>
            </div>
        @endif
        
        @if (count($friendOffers) > 0)
        <div class="panel panel-default">
        <div class="panel-heading">友達申請</div>
        <div class="panel-body">
        <!-- 友達一覧 -->
            @foreach ($friendOffers as $friendOffer)
            <div class="media">
                <!-- 1.画像の配置 -->
                <a class="media-left" href="{{ url('/user_schedule',$friendOffer->user_id) }}">
                    <img class="media-object" src="{{url($friendOffer->user_img)}}">
                </a>
                <!-- 2.画像の説明 -->
                <div class="media-body">
                    @if($friendOffer->name !== "")
                    <h4 class="media-heading">{{ $friendOffer->name }}</h4>
                    @endif
                    <p>{{ $friendOffer->user_content."/".$friendOffer->user_sex."/".$friendOffer->user_birthday }}</p>
                </div>
                <div class="media-right">
                    <button type="submit" class="btn btn-success">
                    <i class="fa fa-btn fa-user-plus"></i> 友達追加</button>
                    <div class="padding-top-10">
                    <button type="submit" class="btn btn-danger">
                    <i class="fa fa-btn fa-frown-o"></i> 拒否</button>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
            </div>
        @endif
        @if (count($users) > 0)
        <div class="panel panel-default">
        <div class="panel-heading">友達一覧</div>
        <div class="panel-body">
        <!-- 友達一覧 -->
            @foreach ($users as $user)
            <div class="media">
                <!-- 1.画像の配置 -->
                <a class="media-left" href="#">
                    <!--<img class="media-object" src="{{url($friendOffer->user_img)}}">-->
                </a>
                <!-- 2.画像の説明 -->
                <div class="media-body">
                    @if($user->name !== "")
                    <h4 class="media-heading">{{ $user->name }}</h4>
                    @endif
                </div>
                <div class="media-right">
                     <button type="submit" class="btn btn-primary">
                         <i class="fa fa-btn fa-user-plus"></i> 友達リクエスト</button>
                </div>
            </div>
            @endforeach
            </div>
            </div>
        @endif        
        
       

     </div>
@endsection