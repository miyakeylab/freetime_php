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
                <img class="media-object" src="{{url($group->group_img)}}">
            </a>
            <!-- 2.画像の説明 -->
            <div class="media-body">
                <h4 class="media-heading">{{ $group->group_name }}</h4>
                <button type="submit" class="btn btn-success" id="staticModalButton">
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
                    その他
                </td>
                @for ($n=0;$n<24;$n++)
                <th colspan="1" align="center"></th>
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
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('messages.group_modal_close_button') }}</button>
          <button type="submit" class="btn btn-primary">{{ __('messages.gr_user_add_button') }}</button>
        </div>
        <input type="hidden" name="group_id" value="{{$group->id}}" >
        </form>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->
@endsection