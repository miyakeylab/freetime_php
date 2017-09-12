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

        <div class="row">
        <div class="col-md-8 col-md-offset-2">  
        <div class="panel panel-default">
        <div class="panel-heading">{{ __('messages.group_list') }}</div>
        <div class="panel-body">
            @if (count($groups) > 0)
            <!-- グループ一覧 -->
            <?php $i = 0; ?>
            @foreach ($groups as $group)
            <?php if($i !== 0){ ?>
            <hr class="style-one">
            <?php } ?>
            <?php $i++; ?>
            <div class="media">
                <!-- 1.画像の配置 -->
                <a class="media-left" href="{{ url('/group_schedule',$group->id) }}">
                   <img class="media-object" src="{{url($group->group_img)}}">
                </a>
                <!-- 2.画像の説明 -->
                <div class="media-body">
                    @if($group->group_name !== "")
                    <h4 class="media-heading"><a href="{{ url('/group_schedule',$group->id) }}">{{ $group->group_name }}</a></h4>
                    <p>{{ __('messages.group_admin').$group->user_name }}</p>
                    @endif
                </div>
                <div class="media-right">
                    <button type="submit" class="btn btn-danger">
                    <i class="fa fa-btn fa-frown-o"></i>{{ __('messages.group_leave_button') }}</button>
                </div>
            </div>
            @endforeach
            @endif
            </div>
            </div>           
            </div>
            </div>


        <div class="row">
        <div class="col-md-8 col-md-offset-2"> 
        <div class="panel panel-default">
        <div class="panel-heading">{{ __('messages.group_request_list') }}</div>
        <div class="panel-body">
            @if (count($group_offer_count) > 0)
            <!-- グループ申請 -->
            <?php $i = 0; ?>
            @foreach ($group_offer_count as $group_offer)
            <?php if($i !== 0){ ?>
            <hr class="style-one">
            <?php } ?>
            <?php $i++; ?>
            <div class="media">
                <!-- グループ画像 -->
                <a class="media-left" href="#">
                   <img class="media-object" src="{{url($group_offer->group_img)}}">
                </a>
                <!-- グループ名・管理者 -->
                <div class="media-body">
                    @if($group_offer->group_name !== "")
                    <h4 class="media-heading">{{ $group_offer->group_name }}</h4>
                    @endif
                </div>
                <!-- ボタン -->
                <div class="media-right">
                    <form class="form-horizontal" method="POST" action="{{ url('group/reaponse/ng') }}">
                        {{ csrf_field() }}
                        <!-- 拒否 -->
                        <button type="submit" class="btn btn-success">
                        <i class="fa fa-btn fa-users"></i>{{ __('messages.group_ng_Button') }}</button>
                        <input type="hidden" name="group_res_ng_id" value="{{$group_offer->master_id}}" />  
                    </form>
                    <div class="padding-top-10">
                        
                    <form class="form-horizontal" method="POST" action="{{ url('group/reaponse/ok') }}">
                        {{ csrf_field() }}
                        <!-- グループ参加 -->
                        <button type="submit" class="btn btn-danger">
                        <i class="fa fa-btn fa-frown-o"></i>{{ __('messages.group_add_Button') }}</button>
                        <input type="hidden" name="group_res_ok_id" value="{{$group_offer->master_id}}" />  
                    </form>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
            </div>
            </div>            
            </div>
            </div>

    </div>
  <!-- グループ作成ダイアログ -->
  <div class="modal" id="groupModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false" >
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="POST" action="{{ url('group/create') }}">
            {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&#215;</span><span class="sr-only">{{ __('messages.group_modal_close_button') }}</span>
          </button>
          <h4 class="modal-title">{{ __('messages.group_modal_title') }}</h4>
        </div><!-- /modal-header -->
        
        <div class="modal-body">
          <div class="panel panel-default">
            <div class="panel-heading">{{ __('messages.group_modal_content') }}</div>
            <div class="panel-body">
            
            <label for="group-name-input" class="col-md-4 control-label">{{ __('messages.group_modal_name') }}</label>
            <div class="col-md-6"  >
                <input type="text" class="form-control" id="group-name-input" name="group_name" />
            </div>  
            </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('messages.group_modal_close_button') }}</button>
          <button type="submit" class="btn btn-primary">{{ __('messages.group_modal_title') }}</button>
        </div>
        </form>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->
@endsection