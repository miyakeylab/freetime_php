<!-- resources/views/group.blade.php -->

@extends('layouts.app')

@section('content')
    <!-- グループ -->
    <div class="container" >
        
        <button type="submit" class="btn btn-success">
        <i class="fa fa-btn fa-users"></i> グループ新規作成</button>
        <div class="padding-top-10">
        
        @if (count($groups) > 0)
        <div class="panel panel-default">
        <div class="panel-heading">グループ一覧</div>
        <div class="panel-body">
        <!-- 友達一覧 -->
            @foreach ($groups as $group)
            <div class="media">
                <!-- 1.画像の配置 -->
                <a class="media-left" href="#">
                   <img class="media-object" src="{{url($group->group_img)}}">
                </a>
                <!-- 2.画像の説明 -->
                <div class="media-body">
                    @if($group->group_name !== "")
                    <h4 class="media-heading">{{ $group->group_name }}</h4>
                    @endif
                </div>
                <div class="media-right">
                    <button type="submit" class="btn btn-danger">
                    <i class="fa fa-btn fa-frown-o"></i> 退会</button>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
            </div>
        @endif
        @if (count($groups) > 0)
        <div class="panel panel-default">
        <div class="panel-heading">グループ申請</div>
        <div class="panel-body">
        <!-- 友達一覧 -->
            @foreach ($groups as $group)
            <div class="media">
                <!-- 1.画像の配置 -->
                <a class="media-left" href="#">
                   <img class="media-object" src="{{url($group->group_img)}}">
                </a>
                <!-- 2.画像の説明 -->
                <div class="media-body">
                    @if($group->group_name !== "")
                    <h4 class="media-heading">{{ $group->group_name }}</h4>
                    @endif
                </div>
                <div class="media-right">
                    <button type="submit" class="btn btn-success">
                    <i class="fa fa-btn fa-users"></i> グループ参加</button>
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
    </div>
@endsection