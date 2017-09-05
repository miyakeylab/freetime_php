<!-- resources/views/group.blade.php -->

@extends('layouts.app')
@include('layouts.head', ['page' => 3])
@include('layouts.nav')


@section('content')
    <!-- グループ -->
    <div class="container" >
        <div class="col-md-8 col-md-offset-2">  
        <!-- グループ作成ボタン -->
        <button type="submit" class="btn btn-success" id="groupModalButton">
        <i class="fa fa-btn fa-users"></i>{{ __('messages.group_create_button') }}</button>
        <div class="padding-top-10"></div>
        </div>
        @if (count($groups) > 0)
        <div class="row">
        <div class="col-md-8 col-md-offset-2">  
        <div class="panel panel-default">
        <div class="panel-heading">{{ __('messages.group_list') }}</div>
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
                    <p>{{ __('messages.group_admin') }}</p>
                    @endif
                </div>
                <div class="media-right">
                    <button type="submit" class="btn btn-danger">
                    <i class="fa fa-btn fa-frown-o"></i>{{ __('messages.group_leave_button') }}</button>
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
        <div class="panel-heading">{{ __('messages.group_request_list') }}</div>
        <div class="panel-body">
            <!-- グループ申請 -->
            <?php $i = 0; ?>
            @foreach ($groups as $group)
            <?php if($i !== 0){ ?>
            <hr class="style-one">
            <?php } ?>
            <?php $i++; ?>
            <div class="media">
                <!-- グループ画像 -->
                <a class="media-left" href="#">
                   <img class="media-object" src="{{url($group->group_img)}}">
                </a>
                <!-- グループ名・管理者 -->
                <div class="media-body">
                    @if($group->group_name !== "")
                    <h4 class="media-heading">{{ $group->group_name }}</h4>
                    <p>{{ __('messages.group_admin') }}</p>
                    @endif
                </div>
                <!-- ボタン -->
                <div class="media-right">
                    <!-- 拒否 -->
                    <button type="submit" class="btn btn-success">
                    <i class="fa fa-btn fa-users"></i>{{ __('messages.group_ng_Button') }}</button>
                    <div class="padding-top-10">
                    <!-- グループ参加 -->
                    <button type="submit" class="btn btn-danger">
                    <i class="fa fa-btn fa-frown-o"></i>{{ __('messages.group_add_Button') }}</button>
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
  <!-- グループ作成ダイアログ -->
  <div class="modal" id="groupModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false" >
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&#215;</span><span class="sr-only">{{ __('messages.group_modal_close_button') }}</span>
          </button>
          <h4 class="modal-title">{{ __('messages.group_modal_title') }}</h4>
        </div><!-- /modal-header -->
        <div class="modal-body">
          <p class="recipient"></p>
        </div>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->
@endsection