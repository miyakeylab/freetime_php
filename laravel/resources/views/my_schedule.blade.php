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
        data-content=""
        data-category="0"
        style="width: 200px">
        <i class="fa fa-btn fa-calendar"></i>{{ __('messages.schedule_create_button') }}</button>

        <div class="form-group col-xs-6">
          <form method="POST" action="{{ url('timezone') }}" style="display: inline" name="timezoneForm">
            {{ csrf_field() }}
            <select class="form-control my-timezone-size" id="timezone" name="timezone" style="width: 200px" onChange="this.form.submit()">
            <?php $timezone = 0; ?> 
            @foreach (Config::get('const.TIME_ZONE_NAME') as $timeName )
             @if ($timezone != $my_timezone)
              <option value="{{ $timezone }}">{{$timeName}}</option>
              @else
              <option value="{{ $timezone }}" selected>{{$timeName}}</option>
              @endif
              <?php $timezone++; ?> 
            @endforeach
            </select>
            <input type="hidden" name="now_day" value="{{ $now }}" /> 
          </form>
        </div>      
        <div class="col-xs-12">
          <form method="POST" action="{{ url('my_schedule/prev') }}" style="display: inline" name="prevForm">
            {{ csrf_field() }}
            <a href="javascript:document.prevForm.submit()"><i class="fa fa-btn fa-chevron-left"></i></a>
            <input type="hidden" name="now_day" value="{{ $now }}" /> 
            <input type="hidden" name="my_timezone" value="{{ $my_timezone }}"/> 
          </form>{{ " "."$now"." " }}
          <form method="POST" action="{{ url('my_schedule/next') }}" style="display: inline" name="nextForm">
            {{ csrf_field() }}
            <a href="javascript:document.nextForm.submit()"><i class="fa fa-btn fa-chevron-right"></i></a>
            <input type="hidden" name="now_day" value="{{ $now }}" /> 
            <input type="hidden" name="my_timezone" value="{{ $my_timezone }}" /> 
          </form>
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
                 
                <?php $hourDiff = 0; ?>
                @for ($n=0; $n<24; $n++)
                   <?php  $str_1 = new \Carbon\Carbon($now.' '.str_pad($n, 2, 0, STR_PAD_LEFT).':00'); 
                          $str_2 = new \Carbon\Carbon($now.' '.str_pad($n+1, 2, 0, STR_PAD_LEFT).':00'); 
                          $result = 0; 
                          $count[$n] = 0; ?>
                  @if($hourDiff <= 0 )
                    <!-- スケジュール -->
                    @foreach( $mySchedule as $schedule)
                      <!-- 時間処理  -->
                      <?php 
                       $now_start = new \Carbon\Carbon($schedule->start_time_gmt);
                        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['0'] == true)
                        {
                            $now_start->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
                            $now_start->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
                        }
                        else
                        {
                            $now_start->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
                            $now_start->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
                        }
                      
                       ?>                    
                      
                      @if ($now_start->gte($str_1)=== true && $now_start->lt($str_2)===true)
                        
                        <?php $now_end = new \Carbon\Carbon($schedule->end_time_gmt); 
                            if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['0'] == true)
                            {
                                $now_end->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
                                $now_end->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
                            }
                            else
                            {
                                $now_end->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
                                $now_end->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
                            }
                      
                            $hourDiff = $now_start->diffInHours($now_end);
                        ?>   
                        
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
                        <td class="myFeed {{  $color  }}" colspan="{{ $hourDiff }}" align="center" data-toggle="modal" 
                        data-target="#staticModal" 
                        data-start="{{ $now_start }}" 
                        data-end="{{ $now_end }}"
                        data-title="{{ $schedule->title }}"
                        data-content="{{ $schedule->content }}"
                        data-category="{{ $schedule->category_id }}"><span class="{{ 'overflowStr_'.$hourDiff }}" style="display:block;">{{ $schedule->title }}</span></td>
                        
                        @else
                         <?php $count[$n] +=1; ?>
                        @endif
                      @endif
                    @endforeach
                    
                    @if($result === 0)
                      <td class="myFeed" colspan="1" align="center" data-toggle="modal" 
                      data-target="#staticModal" 
                      data-start="{{ $now.' '.str_pad($n, 2, 0, STR_PAD_LEFT).':00' }}" 
                      data-end="{{ $now.' '.str_pad(($n+1), 2, 0, STR_PAD_LEFT).':00' }}"
                      data-title=""
                      data-content=""
                      data-category="0"></td>
                    @else
                     <?php $hourDiff -= 1; ?>
                    @endif
                  @else
                    <?php $hourDiff -= 1; ?>
                    <!-- スケジュールカウント処理 -->
                    @foreach( $mySchedule as $schedule)
                      <?php $now_start = new \Carbon\Carbon($schedule->start_time_gmt);
                        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['0'] == true)
                        {
                            $now_start->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
                            $now_start->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
                        }
                        else
                        {
                            $now_start->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
                            $now_start->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
                        }
                      ?>
                      @if ($now_start->gte($str_1)=== true && $now_start->lt($str_2)===true)
                         <?php $count[$n] +=1; ?>
                      @endif
                    @endforeach
                  @endif
                @endfor
            </tr>
            <tr>
                <td colspan="1" align="center">
                  <a href="{{ url('/user_schedule',$user->user_id) }}">
                    <span class="overflowStrName" style="display:block;">{{ $user->user_name }}</span>
                  </a>
                </td>
                @for ($n=0;$n<24;$n++)
                  @if($count[$n] != 0)
                    <td class="yobiFeed" colspan="1" align="center">{{ "+".$count[$n] }}</td>
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
            <?php $groupCount = 0 ?>
            @foreach ($groups as $group)
            <?php $groupTempSch =  $groupSchedule[$groupCount] ?>
            <tr>
                <td colspan="1" align="center">
                  <a href="{{ url('/group_schedule',$group->master_id) }}">
                    <img class="media-object user_icon_size" src="{{url($group->group_img)}}" >
                  </a>
                </td>
              <?php $hourDiff = 0; ?>
                @for ($n=0; $n<24; $n++)
                   <?php  $str_1 = new \Carbon\Carbon($now.' '.str_pad($n, 2, 0, STR_PAD_LEFT).':00'); 
                          $str_2 = new \Carbon\Carbon($now.' '.str_pad($n+1, 2, 0, STR_PAD_LEFT).':00'); 
                          $result = 0; 
                          $count_group[$n] = 0; ?>
                  @if($hourDiff <= 0 )
                    <!-- スケジュール -->
                    @foreach( $groupTempSch as $schedule)
                                         
                      <?php 
                       $now_start = new \Carbon\Carbon($schedule->start_time_gmt);
                        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['0'] == true)
                        {
                            $now_start->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
                            $now_start->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
                        }
                        else
                        {
                            $now_start->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
                            $now_start->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
                        }
                      
                       ?>                      
                      @if ($now_start->gte($str_1)=== true && $now_start->lt($str_2)===true)
                        
                         <?php $now_end = new \Carbon\Carbon($schedule->end_time_gmt); 
                            if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['0'] == true)
                            {
                                $now_end->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
                                $now_end->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
                            }
                            else
                            {
                                $now_end->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
                                $now_end->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
                            }
                      
                            $hourDiff = $now_start->diffInHours($now_end);
                        ?>
                        
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
                        <td class="friendFeed {{  $color  }}" colspan="{{ $hourDiff }}" align="center" data-toggle="modal" 
                        data-target="#groupModal" 
                        data-start="{{ $now_start }}" 
                        data-end="{{ $now_end }}"
                        data-title="{{ $schedule->title }}"
                        data-content="{{ $schedule->content }}"
                        data-category="{{ $schedule->category_id }}"
                        data-groupid="{{ $group->master_id }}"><span class="{{ 'overflowStr_'.$hourDiff }}" style="display:block;">{{ $schedule->title }}</span></td>
                        
                        @else
                         <?php $count_group[$n] +=1; ?>
                        @endif
                      @endif
                    @endforeach
                    
                    @if($result === 0)
                      <td class="friendFeed" colspan="1" align="center" data-toggle="modal" 
                      data-target="#groupModal" 
                      data-start="{{ $now.' '.str_pad($n, 2, 0, STR_PAD_LEFT).':00' }}" 
                      data-end="{{ $now.' '.str_pad(($n+1), 2, 0, STR_PAD_LEFT).':00' }}"
                      data-title=""
                      data-content=""
                      data-category="0"
                      data-groupid="{{ $group->master_id }}"></td>
                    @else
                     <?php $hourDiff -= 1; ?>
                    @endif
                  @else
                    <?php $hourDiff -= 1; ?>
                    <!-- スケジュールカウント処理 -->
                    @foreach( $groupTempSch as $schedule)
                      <?php 
                       $now_start = new \Carbon\Carbon($schedule->start_time_gmt);
                        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['0'] == true)
                        {
                            $now_start->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
                            $now_start->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
                        }
                        else
                        {
                            $now_start->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
                            $now_start->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
                        }
                      
                       ?>                        
                      @if ($now_start->gte($str_1)=== true && $now_start->lt($str_2)===true)
                         <?php $count_group[$n] +=1; ?>
                      @endif
                    @endforeach
                  @endif
                @endfor
            </tr>
            <tr>
                <td class="overflow" colspan="1" align="center">
                  <a href="{{ url('/group_schedule',$group->master_id) }}">
                    {{ $group->group_name  }}
                  <a>
                </td>
                @for ($n=0;$n<24;$n++)
                  @if($count_group[$n] != 0)
                    <td class="yobiFeed" colspan="1" align="center">{{ "+".$count_group[$n] }}</td>
                  @else
                    <td class="yobiFeed" colspan="1" align="center"></td>
                  @endif
                @endfor
            </tr>
            <?php $groupCount++; ?>
            @endforeach
            @endif
            <tr>
                <td class="schedule-tr-head" colspan="25" align="center">
                  {{ __('messages.schedule_friend_list') }}
                </td>
            </tr>
            <!-- 友達  -->
            @if (count($friends) > 0)
            <?php $friendCount = 0 ?>
            @foreach ($friends as $friend)
            <?php $friendTempSch =  $friendSchedule[$friendCount] ?>
            <tr>
                <td colspan="1" align="center">
                  <a href="{{ url('/user_schedule',$friend->friend_user_id) }}">
                    <img class="media-object user_icon_size" src="{{url($friend->user_img)}}" >
                  </a>
                </td>
                <?php $hourDiff = 0; ?>
                @for ($n=0; $n<24; $n++)
                   <?php  $str_1 = new \Carbon\Carbon($now.' '.str_pad($n, 2, 0, STR_PAD_LEFT).':00'); 
                          $str_2 = new \Carbon\Carbon($now.' '.str_pad($n+1, 2, 0, STR_PAD_LEFT).':00'); 
                          $result = 0; 
                          $count_friend[$n] = 0; ?>
                  @if($hourDiff <= 0 )
                    <!-- スケジュール -->
                    @foreach( $friendTempSch as $schedule)
                                       
                      <?php 
                       $now_start = new \Carbon\Carbon($schedule->start_time_gmt);
                        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['0'] == true)
                        {
                            $now_start->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
                            $now_start->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
                        }
                        else
                        {
                            $now_start->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
                            $now_start->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
                        }
                      
                       ?>                        
                      @if ($now_start->gte($str_1)=== true && $now_start->lt($str_2)===true)
                         <?php $now_end = new \Carbon\Carbon($schedule->end_time_gmt); 
                            if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['0'] == true)
                            {
                                $now_end->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
                                $now_end->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
                            }
                            else
                            {
                                $now_end->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
                                $now_end->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
                            }
                      
                            $hourDiff = $now_start->diffInHours($now_end);
                        ?>
                        
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
                        <td class="friendFeed {{  $color  }}" colspan="{{ $hourDiff }}" align="center" data-toggle="modal" 
                        data-target="#friendModal" 
                        data-start="{{ $now_start }}" 
                        data-end="{{ $now_end }}"
                        data-title="{{ $schedule->title }}"
                        data-content="{{ $schedule->content }}"
                        data-category="{{ $schedule->category_id }}"><span class="{{ 'overflowStr_'.$hourDiff }}" style="display:block;">{{ $schedule->title }}</span></td>
                        
                        @else
                         <?php $count_friend[$n] +=1; ?>
                        @endif
                      @endif
                    @endforeach
                    
                    @if($result === 0)
                      <td class="friendFeed" colspan="1" align="center" data-toggle="modal" 
                      data-target="#offerModal" 
                      data-start="{{ $now.' '.str_pad($n, 2, 0, STR_PAD_LEFT).':00' }}" 
                      data-end="{{ $now.' '.str_pad(($n+1), 2, 0, STR_PAD_LEFT).':00' }}"
                      data-title=""
                      data-content=""
                      data-category="0"
                      data-username="{{ $friend->name }}"
                      data-userid="{{ $friend->friend_user_id }}"></td>
                    @else
                     <?php $hourDiff -= 1; ?>
                    @endif
                  @else
                    <?php $hourDiff -= 1; ?>
                    <!-- スケジュールカウント処理 -->
                    @foreach( $friendTempSch as $schedule)
                      <?php 
                       $now_start = new \Carbon\Carbon($schedule->start_time_gmt);
                        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['0'] == true)
                        {
                            $now_start->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
                            $now_start->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
                        }
                        else
                        {
                            $now_start->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
                            $now_start->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
                        }
                      
                       ?>
                      @if ($now_start->gte($str_1)=== true && $now_start->lt($str_2)===true)
                         <?php $count_friend[$n] +=1; ?>
                      @endif
                    @endforeach
                  @endif
                @endfor
            </tr>
            <tr>
                <td colspan="1" align="center">
                  <a href="{{ url('/user_schedule',$friend->friend_user_id) }}">
                    <span class="overflowStrName" style="display:block;">{{ $friend->name  }}</span>
                  <a>
                </td>
                @for ($n=0;$n<24;$n++)
                  @if($count_friend[$n] != 0)
                    <td class="yobiFeed" colspan="1" align="center">{{ "+".$count_friend[$n] }}</td>
                  @else
                    <td class="yobiFeed" colspan="1" align="center"></td>
                  @endif
                @endfor
            </tr>
            <?php $friendCount++; ?>
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
                <textarea class="form-control" id="schedule-content" name="schedule_content" cols="45" rows="4" ></textarea>
            </div>
            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2"  >
            
            <div class="checkbox-inline">
              <input type="radio" value="Default" name="colors" id="colors_default" >
                <label for="colors_default" ><span class="badge badge-default">FreeTime</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Primary" name="colors" id="colors_primary">
                <label for="colors_primary"><span class="badge badge-primary">Work</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Success" name="colors" id="colors_success">
                <label for="colors_success"><span class="badge badge-success">Play</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Info" name="colors" id="colors_info">
                <label for="colors_info"><span class="badge badge-info">Sleep</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Warning" name="colors" id="colors_warning">
                <label for="colors_warning"><span class="badge badge-warning">Etc</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Danger" name="colors" id="colors_danger">
                <label for="colors_danger"><span class="badge badge-danger">Block</span></label>
            </div> 
            </div>
            </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('messages.schedule_modal_close_button') }}</button>
          <button type="submit" class="btn btn-primary">{{ __('messages.schedule_modal_reg_button') }}</button>
        </div>
        <input type="hidden" name="now_day" value="{{ $now }}" />
        <input type="hidden" name="my_timezone" value="{{ $my_timezone }}" /> 
        </form>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->
  
  <!-- グループモーダルダイアログ -->
  <div class="modal" id="groupModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="POST" action="{{ url('my_schedule/group_set') }}">
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
              <input type="radio" value="Default" name="colors" id="colors_default" >
                <label for="colors_default" ><span class="badge badge-default">FreeTime</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Primary" name="colors" id="colors_primary">
                <label for="colors_primary"><span class="badge badge-primary">Work</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Success" name="colors" id="colors_success">
                <label for="colors_success"><span class="badge badge-success">Play</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Info" name="colors" id="colors_info">
                <label for="colors_info"><span class="badge badge-info">Sleep</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Warning" name="colors" id="colors_warning">
                <label for="colors_warning"><span class="badge badge-warning">Etc</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Danger" name="colors" id="colors_danger">
                <label for="colors_danger"><span class="badge badge-danger">Block</span></label>
            </div> 
            </div>
            </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('messages.schedule_modal_close_button') }}</button>
          <button type="submit" class="btn btn-primary">{{ __('messages.schedule_modal_reg_button') }}</button>
        </div>
        <input type="hidden" name="now_day" value="{{ $now }}" />
        <input type="hidden" name="my_timezone" value="{{ $my_timezone }}" /> 
        <input type="hidden" id="group_id" name="group_id" /> 
        </form>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->
  
  <!-- 他モーダルダイアログ -->
  <div class="modal" id="friendModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false" >
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="POST" action="{{ url('my_schedule/share') }}">
            {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&#215;</span><span class="sr-only">{{ __('messages.schedule_modal_close') }}</span>
          </button>
          <h4 class="modal-title">{{ __('messages.schedule_modal_disp') }}</h4>
        </div><!-- /modal-header -->
        <div class="panel panel-default">
              <div class="panel-heading">{{ __('messages.schedule_modal_date') }}</div>
              <div class="panel-body">
         <div class="padding-top-5"></div>
          <label for="friend-schedule-start" class="col-md-4 control-label">{{ __('messages.schedule_modal_start') }}</label>
          <div class="col-md-5 input-group date" >
              <input class="form-control" type="text" id="friend-schedule-start" name="friend_schedule_start" readonly="readonly" />
          </div>
          <div class="padding-top-5"></div>
          <label for="friend-schedule-end" class="col-md-4 control-label">{{ __('messages.schedule_modal_end') }}</label>
          <div class="col-md-5 input-group date" >
              <input class="form-control" type="text" id="friend-schedule-end" name="friend_schedule_end" readonly="readonly" />
          </div>
          </div>
          </div>
        <div class="modal-body">
          <div class="panel panel-default">
            <div class="panel-heading">{{ __('messages.schedule_modal_content_title') }}</div>
            <div class="panel-body">
            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2"  >
                <input type="text" class="form-control" id="friend-schedule-title" name="friend_schedule_title" readonly="readonly" ></textarea>
            </div>
            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2"  >
                <textarea class="form-control" id="friend-schedule-content" name="friend_schedule_content" cols="45" rows="4" readonly="readonly" ></textarea>
            </div>
            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2"  >
            
            <div class="checkbox-inline">
              <input type="radio" value="Default" name="friend_colors" id="friend-colors_default">
                <label for="colors_default" ><span class="badge badge-default">FreeTime</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Primary" name="friend_colors" id="friend-colors_primary" >
                <label for="colors_primary"><span class="badge badge-primary">Work</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Success" name="friend_colors" id="friend-colors_success" >
                <label for="colors_success"><span class="badge badge-success">Play</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Info" name="friend_colors" id="friend-colors_info" >
                <label for="colors_info"><span class="badge badge-info">Sleep</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Warning" name="friend_colors" id="friend-colors_warning" >
                <label for="colors_warning"><span class="badge badge-warning">Etc</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Danger" name="friend_colors" id="friend-colors_danger" >
                <label for="colors_danger"><span class="badge badge-danger">Block</span></label>
            </div> 
            </div>
            </div>
            </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('messages.schedule_modal_close_button') }}</button>
              <button type="submit" class="btn btn-primary">{{ __('messages.schedule_modal_share') }}</button>
            </div>
            <input type="hidden" name="now_day" value="{{ $now }}" />
            <input type="hidden" name="my_timezone" value="{{ $my_timezone }}" /> 
          </form>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->
  
  <!-- オファーモーダルダイアログ -->
  <div class="modal" id="offerModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="POST" action="{{ url('my_schedule/offer') }}">
            {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&#215;</span><span class="sr-only">{{ __('messages.schedule_close') }}</span>
          </button>
          <h4 class="modal-title">{{ __('messages.offerCerate') }}</h4>
        </div><!-- /modal-header -->
          <div class="panel panel-default">
                <div class="panel-heading">{{ __('messages.schedule_modal_date') }}</div>
                <div class="panel-body">
           <div class="padding-top-5"></div>
            <label for="offer-schedule-start" class="col-md-4 control-label">{{ __('messages.schedule_modal_start') }}</label>
            <div class="col-md-5 input-group date" >
                <input class="form-control" type="text" id="offer-schedule-start" name="schedule_start" />
                <span class="input-group-addon"><span class="add-on glyphicon glyphicon-th"></span></span>
            </div>
            <div class="padding-top-5"></div>
            <label for="offer-schedule-end" class="col-md-4 control-label">{{ __('messages.schedule_modal_end') }}</label>
            <div class="col-md-5 input-group date" >
                <input class="form-control" type="text" id="offer-schedule-end" name="schedule_end" />
                <span class="input-group-addon"><span class="add-on glyphicon glyphicon-th"></span></span>
            </div>
            </div>
            </div>
        <div class="modal-body">
          <div class="panel panel-default">
            <div class="panel-heading">{{ __('messages.schedule_modal_content_title') }}</div>
            <div class="panel-body">
            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2"  >
                <input type="text" class="form-control" id="offer-schedule-title" name="schedule_title" ></textarea>
            </div>
            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2"  >
                <textarea class="form-control" id="offer-schedule-content" name="schedule_content" cols="45" rows="4" ></textarea>
            </div>
            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2"  >
            
            <div class="checkbox-inline">
              <input type="radio" value="Default" name="colors" id="offer-colors_default" >
                <label for="offer-colors_default" ><span class="badge badge-default">FreeTime</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Primary" name="colors" id="offer-colors_primary">
                <label for="offer-colors_primary"><span class="badge badge-primary">Work</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Success" name="colors" id="offer-colors_success">
                <label for="offer-colors_success"><span class="badge badge-success">Play</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Info" name="colors" id="offer-colors_info">
                <label for="offer-colors_info"><span class="badge badge-info">Sleep</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Warning" name="colors" id="offer-colors_warning">
                <label for="offer-colors_warning"><span class="badge badge-warning">Etc</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Danger" name="colors" id="offer-colors_danger">
                <label for="offer-colors_danger"><span class="badge badge-danger">Block</span></label>
            </div> 
            </div>
            </div>
            </div>
          <div class="panel panel-default">
            <!-- 友達一覧 -->
            <div class="panel-heading"><p id="friend_user_name"></p></div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('messages.schedule_modal_close_button') }}</button>
          <button type="submit" class="btn btn-primary">{{ __('messages.offerCerate') }}</button>
        </div>
        <input type="hidden" name="now_day" value="{{ $now }}" />
        <input type="hidden" id="offer_friend_id" name="offer_friend_id" /> 
        </form>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->  
  <!--(フローティングメニューに載せたいHTMLコード)-->
  <!--<div id="floating-menu">-->
  <!--   <i class="fa fa-btn fa-chevron-left"></i> {{ " "."$now"." " }}<i class="fa fa-btn fa-chevron-right"></i>-->
  <!--</div>-->
@endsection
