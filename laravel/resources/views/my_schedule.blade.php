<!-- resources/views/my_schedule.blade.php -->

@extends('layouts.app')
@include('layouts.head', ['page' => 1])
@include('layouts.nav')

@section('content')
    <div class="panel-body">

        <button type="submit" class="btn btn-success col-xs-6" 
        data-toggle="modal" 
        data-target="#staticModal" 
        data-start="{{ $now.' '.str_pad($hour, 2, 0, STR_PAD_LEFT).':00' }}" 
        data-end="{{ $now.' '.str_pad(($hour+1), 2, 0, STR_PAD_LEFT).':00' }}" 
        data-title=""
        style="width: 200px">
        <i class="fa fa-btn fa-calendar"></i>{{ __('messages.schedule_create_button') }}</button>

        <div class="form-group col-xs-6">
            <select class="form-control my-timezone-size" id="timezone" name="timezone" style="width: 200px">
            @foreach (Config::get('const.TIME_ZONE_NAME') as $timeName )
              <option value="1">{{$timeName}}</option>
            @endforeach
            </select>
        </div>      
        <div class="col-xs-12">
          <i class="fa fa-btn fa-chevron-left"></i> {{ " "."$now"." " }}<i class="fa fa-btn fa-chevron-right"></i>
        </div>
        <div class="padding-top-10" />

        <div class='table-responsive  col-xs-12'>
        <table class="table table-striped sticky-header" >
            <thead>
            <tr>
                <th colspan="1" align="center"><b>{{ $now }}</b></th>
                @for ($i=0;$i<24;$i++)
                @if ($i === $hour )
                <th colspan="1" align="center"><font color="#FF0000"><b>{{"NOW"}}</b></font></th>
                @else
                <th colspan="1" align="center" ><b>{{ $i.":00" }}</b></th>
                @endif
                @endfor
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="1" align="center">
                  <a href="{{ url('/user_schedule',$user->user_id) }}">
                    <img class="media-object user_icon_size" src="{{url($user->user_img)}}">
                  </a>
                </td>
                 
                @for ($n=0; $n<24; $n++)
                   <?php  $str_1 = new \Carbon\Carbon($now.' '.str_pad($n, 2, 0, STR_PAD_LEFT).':00'); 
                          $str_2 = new \Carbon\Carbon($now.' '.str_pad($n+1, 2, 0, STR_PAD_LEFT).':00'); 
                          $result = 0; ?>
    
                    <!-- スケジュール -->
                    @foreach( $mySchedule as $schedule)
                      <?php $now_start = new \Carbon\Carbon($schedule->start_time); ?>                    
                      @if ($now_start->gte($str_1)=== true && $now_start->lt($str_2)===true)
                        @if($result === 0)
                          <?php $result = 1; 
                          $color= "badge-default";
                          switch($schedule->category_id)
                          {
                          case 0:
                            $color= "badge-default";
                            break;
                          case 1:
                            $color= "badge-primary";
                            break;
                          case 2:
                            $color= "badge-success";
                            break;
                          case 3:
                            $color= "badge-info";
                            break;
                          case 4:
                            $color= "badge-warning";
                            break;
                          case 5:
                            $color= "badge-danger";
                            break;
                          }
                          ?>
                        <td class="myFeed {{  $color  }}" colspan="1" align="center" data-toggle="modal" 
                        data-target="#staticModal" 
                        data-start="{{ $schedule->start_time }}" 
                        data-end="{{ $schedule->end_time }}"
                        data-title="{{ $schedule->title }}"><span>{{ $schedule->title }}</span></td>
                        @endif
                      @endif
                    @endforeach
                    @if($result === 0)
                      <td class="myFeed" colspan="1" align="center" data-toggle="modal" 
                      data-target="#staticModal" 
                      data-start="{{ $now.' '.str_pad($n, 2, 0, STR_PAD_LEFT).':00' }}" 
                      data-end="{{ $now.' '.str_pad(($n+1), 2, 0, STR_PAD_LEFT).':00' }}"
                      data-title=""></td>
                    @endif
                @endfor
            </tr>
            <tr>
                <td class="overflow" colspan="1" align="center">
                  <a href="{{ url('/user_schedule',$user->user_id) }}">
                    {{ $user->user_name }}
                  </a>
                </td>
                @for ($n=0;$n<24;$n++)
                  @if($n % 2 === 0)
                    <td class="yobiFeed" colspan="1" align="center"></td>
                  @else
                    <td class="yobiFeed" colspan="1" align="center"></td>
                  @endif
                @endfor
            </tr>
            <tr>
                <td class="schedule-tr-head" colspan="25" align="center">
                  {{ __('messages.schedule_group_list') }}
                </td>
            </tr>
            <!-- グループ一覧  -->
            @if (count($groups) > 0)
            @foreach ($groups as $group)
            <tr>
                <td colspan="1" align="center">
                  <a href="{{ url('/group_schedule',$group->master_id) }}">
                    <img class="media-object user_icon_size" src="{{url($group->group_img)}}" >
                  </a>
                </td>
                <td class="info friendFeed" colspan="6" align="center"  data-toggle="modal" data-target="#friendModal" data-="#friendModal">睡眠</td>
                <td class="danger friendFeed" colspan="1" align="center">朝食</td>
                <td class="friendFeed" colspan="1" align="center"></td>
                <td class="info friendFeed" colspan="2" align="center">移動</td>
                <td class="danger friendFeed" colspan="6" align="center">仕事</td>
                <td class="friendFeed" colspan="8" align="center"></td>
            </tr>
            <tr>
                <td class="overflow" colspan="1" align="center">
                  <a href="{{ url('/group_schedule',$group->master_id) }}">
                    {{ $group->group_name  }}
                  <a>
                </td>
                @for ($n=0;$n<24;$n++)
                <td class="yobiFeed" colspan="1" align="center"></td>
                @endfor
            </tr>
            @endforeach
            @endif
            <tr>
                <td class="schedule-tr-head" colspan="25" align="center">
                  {{ __('messages.schedule_friend_list') }}
                </td>
            </tr>
            <!-- 友達  -->
            @if (count($friends) > 0)
            @foreach ($friends as $friend)
            <tr>
                <td colspan="1" align="center">
                  <a href="{{ url('/user_schedule',$friend->friend_user_id) }}">
                    <img class="media-object user_icon_size" src="{{url($friend->user_img)}}" >
                  </a>
                </td>
                <td class="info friendFeed" colspan="6" align="center"  data-toggle="modal" data-target="#friendModal" data-="#friendModal">睡眠</td>
                <td class="danger friendFeed" colspan="1" align="center">朝食</td>
                <td class="friendFeed" colspan="1" align="center"></td>
                <td class="info friendFeed" colspan="2" align="center">移動</td>
                <td class="danger friendFeed" colspan="6" align="center">仕事</td>
                <td class="friendFeed" colspan="8" align="center"></td>
            </tr>
            <tr>
                <td class="overflow" colspan="1" align="center">
                  <a href="{{ url('/user_schedule',$friend->friend_user_id) }}">
                    {{ $friend->name  }}
                  <a>
                </td>
                @for ($n=0;$n<24;$n++)
                <td class="yobiFeed" colspan="1" align="center"></td>
                @endfor
            </tr>
            @endforeach
            @endif
            </tbody>
        </table>
        </div>
        </div>
    </div>
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
                <textarea class="form-control" id="schedule-content" name="schedule_content" cols="45" rows="8" ></textarea>
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
  
  <!-- 他モーダルダイアログ -->
  <div class="modal" id="friendModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false" >
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&#215;</span><span class="sr-only">{{ __('messages.schedule_modal_close') }}</span>
          </button>
          <h4 class="modal-title">{{ __('messages.schedule_modal_disp') }}</h4>
        </div><!-- /modal-header -->
        <div class="modal-body">
          <p class="recipient"></p>
        </div>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->
  <!--(フローティングメニューに載せたいHTMLコード)-->
  <!--<div id="floating-menu">-->
  <!--   <i class="fa fa-btn fa-chevron-left"></i> {{ " "."$now"." " }}<i class="fa fa-btn fa-chevron-right"></i>-->
  <!--</div>-->
@endsection
