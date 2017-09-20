<!-- resources/views/group_schedule.blade.php -->

@extends('layouts.app')
@include('layouts.head', ['page' => 4])
@include('layouts.nav')


@section('content')
  
    <div class="panel-body">
        <!-- グループ詳細 -->
        <div class="media">
            <!-- 1.画像の配置 -->
            <a class="media-left" href="#">
                <img class="media-object" src="{{url($group->group_img)}}" style="height: 32px">
            </a>
            <!-- 2.画像の説明 -->
            <div class="media-body">
                <h4 class="media-heading">{{ $group->group_name }}</h4>
                <!--<button type="submit" class="btn btn-success" id="staticModalButton">-->
               <button type="submit" class="btn btn-success" 
                data-toggle="modal" 
                data-target="#staticModal" 
                data-start="" 
                data-end="" 
                data-title=""
                data-content=""
                style="width: 200px">             
                <i class="fa fa-btn fa-calendar"></i>{{ __('messages.gr_sche_cre_button') }}</button>
                <button type="submit" class="btn btn-success" id="groupfriendModal">
                <i class="fa fa-btn fa-user-plus"></i>{{ __('messages.gr_user_add_button') }}</button>
            </div>
        </div>

        <div class='table-responsive'>
        <table class="table table-striped sticky-header" style="font-size : 5px;">
            <thead>
            <tr>
                <th colspan="1" align="center">{{ $month."月" }}</th>
                @for ($i=0;$i<24;$i++)

                <th colspan="1" align="center">{{ $i.":00" }}</th>
                @endfor
            </tr>
            </thead>
            <tbody>
            @for ($i=1;$i <= $maxDay;$i++)
            <tr>
                <td colspan="1" align="center">
                    {{ $month."/".$i }} 
                </td>
                <td class="info" colspan="6" align="center">睡眠</td>
                <td colspan="1" align="center">朝食</td>
                <td colspan="1" align="center"></td>
                <td colspan="2" align="center">移動</td>
                <td class="danger" colspan="6" align="center">仕事</td>
                <td colspan="8" align="center"></td>
            </tr>
            <tr>
                <td colspan="1" align="center">
                </td>
                @for ($n=0;$n<24;$n++)
                <th class="yobiFeed" colspan="1" align="center"></th>
                @endfor
            </tr>
            @endfor
            </tbody>
        </table>
        </div>
    </div>
    
  <!-- グループフレンド招待ダイアログ -->
  <div class="modal" id="groupfriendAddModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false" >
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="POST" action="{{ url('group_schedule/add_friend') }}">
            {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&#215;</span><span class="sr-only">{{ __('messages.group_modal_close_button') }}</span>
          </button>
          <h4 class="modal-title">{{ __('messages.gr_user_add_title') }}</h4>
        </div><!-- /modal-header -->
        
        <div class="modal-body">
          <div class="panel panel-default">
            <!-- 友達一覧 -->
            <div class="panel-heading">{{ __('messages.friend_user_list') }}</div>
            <div class="panel-body fixed-panel">
            
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
                <a class="media-left">
                    <img class="media-object" src="{{url($friend->user_img)}}">
                </a>
                <!-- 2.画像の説明 -->
                <div class="media-body">
                    @if($friend->name !== "")
                    <h4 class="media-heading">{{ $friend->name }}</h4>
                    @endif
                    <div class="checkbox">
        				<label>
        					<input type="checkbox" name="addUser[]" value="{{ $friend->friend_user_id }}"> {{ __('messages.gr_user_add_button') }}
        				</label>
        			</div>
                </div>
                <div class="media-right">

                </div>
            </div>
            @endforeach
        @endif
        </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('messages.group_modal_close_button') }}</button>
          <button type="submit" class="btn btn-primary">{{ __('messages.gr_user_add_button') }}</button>
        </div>
        <input type="hidden" name="group_id" value="{{$group->id}}" >
        </form>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->
  
  <!-- 自モーダルダイアログ -->
  <div class="modal" id="staticModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="POST" action="{{ url('my_schedule/set') }}">
            {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&#215;</span><span class="sr-only">{{ __('messages.schedule_close') }}</span>
          </button>
          <h4 class="modal-title">{{ __('messages.schedule_modal_title') }}</h4>
        </div><!-- /modal-header -->
          <div class="panel panel-default">
                <div class="panel-heading">{{ __('messages.schedule_modal_date') }}</div>
                <div class="panel-body">
           <div class="padding-top-5"></div>
            <label for="schedule-start" class="col-md-4 control-label">{{ __('messages.schedule_modal_start') }}</label>
            <div class="col-md-5 input-group date" >
                <input class="form-control" type="text" id="schedule-start" name="schedule_start" />
                <span class="input-group-addon"><span class="add-on glyphicon glyphicon-th"></span></span>
            </div>
            <div class="padding-top-5"></div>
            <label for="schedule-end" class="col-md-4 control-label">{{ __('messages.schedule_modal_end') }}</label>
            <div class="col-md-5 input-group date" >
                <input class="form-control" type="text" id="schedule-end" name="schedule_end" />
                <span class="input-group-addon"><span class="add-on glyphicon glyphicon-th"></span></span>
            </div>
            </div>
            </div>
        <div class="modal-body">
          <div class="panel panel-default">
            <div class="panel-heading">{{ __('messages.schedule_modal_content_title') }}</div>
            <div class="panel-body">
            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2"  >
                <input type="text" class="form-control" id="schedule-title" name="schedule_title" ></textarea>
            </div>
            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2"  >
                <textarea class="form-control" id="schedule-content" name="schedule_content" cols="45" rows="4" ></textarea>
            </div>
            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2"  >
            
            <div class="checkbox-inline">
              <input type="radio" value="Default" name="colors" id="colors_default" checked="checked">
                <label for="colors_default" ><span class="badge badge-default">Default</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Primary" name="colors" id="colors_primary">
                <label for="colors_primary"><span class="badge badge-primary">Primary</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Success" name="colors" id="colors_success">
                <label for="colors_success"><span class="badge badge-success">Success</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Info" name="colors" id="colors_info">
                <label for="colors_info"><span class="badge badge-info">Info</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Warning" name="colors" id="colors_warning">
                <label for="colors_warning"><span class="badge badge-warning">Warning</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Danger" name="colors" id="colors_danger">
                <label for="colors_danger"><span class="badge badge-danger">Danger</span></label>
            </div> 
            </div>
            </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('messages.schedule_modal_close_button') }}</button>
          <button type="submit" class="btn btn-primary">{{ __('messages.schedule_modal_reg_button') }}</button>
        </div>
        <form>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->  
@endsection