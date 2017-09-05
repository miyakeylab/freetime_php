<!-- resources/views/group.blade.php -->

@extends('layouts.app')
@include('layouts.head', ['page' => 1])
@include('layouts.nav')


@section('content')
    <!-- グループ -->
    <div class="container" >
        <div class="col-md-8 col-md-offset-2">  
        <button type="submit" class="btn btn-success">
        <i class="fa fa-btn fa-users"></i> グループ新規作成</button>
        <div class="padding-top-10"></div>
        </div>
        @if (count($groups) > 0)
        <div class="row">
        <div class="col-md-8 col-md-offset-2">  
        <div class="panel panel-default">
        <div class="panel-heading">グループ一覧</div>
        <div class="panel-body">
            <!-- グループ一覧 -->
            <?php $i = 0; ?>
            @foreach ($groups as $group)
            <?php if($i !== 0){ ?>
            <hr class="style-one">
            <?php } ?>
            <?php $i++; ?>
            <div class="media">
                <!-- 1.画像の配置 -->
                <a class="media-left" href="#">
                   <img class="media-object" src="{{url($group->group_img)}}">
                </a>
                <!-- 2.画像の説明 -->
                <div class="media-body">
                    @if($group->group_name !== "")
                    <h4 class="media-heading">{{ $group->group_name }}</h4>
                    <p>管理者：</p>
                    @endif
                </div>
                <div class="media-right">
                    <button type="submit" class="btn btn-danger">
                    <i class="fa fa-btn fa-frown-o"></i> 退会</button>
                </div>
            </div>
            @endforeach
            </div>
            </div>           
            </div>
            </div>
        @endif
        @if (count($groups) > 0)
        <div class="row">
        <div class="col-md-8 col-md-offset-2"> 
        <div class="panel panel-default">
        <div class="panel-heading">グループ申請</div>
        <div class="panel-body">
            <!-- グループ申請 -->
            <?php $i = 0; ?>
            @foreach ($groups as $group)
            <?php if($i !== 0){ ?>
            <hr class="style-one">
            <?php } ?>
            <?php $i++; ?>
            <div class="media">
                <!-- 1.画像の配置 -->
                <a class="media-left" href="#">
                   <img class="media-object" src="{{url($group->group_img)}}">
                </a>
                <!-- 2.画像の説明 -->
                <div class="media-body">
                    @if($group->group_name !== "")
                    <h4 class="media-heading">{{ $group->group_name }}</h4>
                    <p>管理者：</p>
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
            </div>
            </div>
        @endif
    </div>
@endsection