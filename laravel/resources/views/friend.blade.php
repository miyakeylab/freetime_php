<!-- resources/views/friend.blade.php -->

@extends('layouts.app')

@section('content')
    <!-- 友達 -->
    <div class="panel-body" >
        <div class="table-responsive" id="LAYER">
            <button>友達追加</button>
        
        @if (count($friends) > 0)
        <!-- 友達一覧 -->
        <table class="table table-bordered " style="font-size : 5px;">
            @foreach ($friends as $friend)
            <tr>
                <td colspan="2" align="center">{{ $friend->friend_user_id }}</td>
                <td colspan="2" align="center">{{ $friend->name }}</td>
            </tr>
            @endforeach
        </table>
        @endif
        </div>
        <div class="media">
            <!-- 1.画像の配置 -->
            <a class="media-left" href="#">
                <img class="media-object" src="{{url('css/assets/img/user_icon/no_icon.jpg')}}">
            </a>
            <!-- 2.画像の説明 -->
            <div class="media-body">
                <h4 class="media-heading">友達名前1</h4>
                <p>友達内容1</p>
            </div>
        </div>
                <div class="media">
            <!-- 1.画像の配置 -->
            <a class="media-left" href="#">
                <img class="media-object" src="{{url('css/assets/img/user_icon/no_icon.jpg')}}">
            </a>
            <!-- 2.画像の説明 -->
            <div class="media-body">
                <h4 class="media-heading">友達名前2</h4>
                <p>友達内容2</p>
            </div>
        </div>
     </div>
@endsection