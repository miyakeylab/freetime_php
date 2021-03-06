<!-- resources/views/schedule_main.blade.php -->

@extends('layouts.app_main')
@include('layouts.head', ['page' => 1])
@include('layouts.nav')

@section('content')
    <div class="panel-body">
        <div class="col-xs-12 padding-bottom-10">
          <form method="POST" action="{{ url('schedule_main/prev') }}" style="display: inline" name="prevForm">
            {{ csrf_field() }}
            <a href="javascript:document.prevForm.submit()"><i class="fa fa-btn fa-chevron-left"></i></a>
            <input type="hidden" name="now_day" value="{{ $now }}" /> 
            <input type="hidden" name="my_timezone" value="{{ $my_timezone }}"/> 
          </form><b>{{ " "."$now"." " }}</b>
          <form method="POST" action="{{ url('schedule_main/next') }}" style="display: inline" name="nextForm">
            {{ csrf_field() }}
            <a href="javascript:document.nextForm.submit()"><i class="fa fa-btn fa-chevron-right"></i></a>
            <input type="hidden" name="now_day" value="{{ $now }}" /> 
            <input type="hidden" name="my_timezone" value="{{ $my_timezone }}" /> 
          </form>
        </div>
        <button type="submit" class="btn btn-success col-xs-6" 
        data-toggle="modal" 
        data-target="#inputModal" 
        data-start="{{ $now.' '.str_pad($hour, 2, 0, STR_PAD_LEFT).':00' }}" 
        data-end="{{ $now.' '.str_pad(($hour+1), 2, 0, STR_PAD_LEFT).':00' }}" 
        data-title=""
        data-content=""
        data-category="0"
        style="width: 200px">
          <!-- スケジュール作成ボタン -->
        <i class="fa fa-btn fa-calendar"></i>{{ __('messages.schedule_create_button') }}</button>
        <!-- タイムゾーン -->
        <div class="form-group col-xs-6">
          <form method="POST" action="{{ url('timezone') }}" style="display: inline" name="timezoneForm">
            {{ csrf_field() }}
            <select class="form-control my-timezone-size" id="timezone" name="timezone" style="width: 200px" onChange="this.form.submit()">
            <?php $timezone = 0; ?> 
            @foreach (Config::get('const.TIME_ZONE_NAME') as $timeName )
             @if ($timezone != $my_timezone)
              <option value="{{ $timezone }}">{{ __('messages.TIME_ZONE_NAME')[$timezone] }}</option>
              @else
              <option value="{{ $timezone }}" selected>{{ __('messages.TIME_ZONE_NAME')[$timezone] }}</option>
              @endif
              <?php $timezone++; ?> 
            @endforeach
            </select>
            <input type="hidden" name="now_day" value="{{ $now }}" /> 
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
                <th colspan="1" align="center" bgcolor="#f5f547"><font color="#FF0000"><b>{{"NOW"}}</b></font></th>
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
                          $str_3 = new \Carbon\Carbon($now_pre.' '.str_pad(0, 2, 0, STR_PAD_LEFT).':00'); 
                          $str_4 = new \Carbon\Carbon($now_pre.' '.str_pad(23, 2, 0, STR_PAD_LEFT).':00');
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
                            if(($hourDiff + $n) > 24)
                            {
                              $hourDiff = (24 - $n);
                            }
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
                        <td class="myFeed shcedule-font {{  $color  }}" colspan="{{ $hourDiff }}" align="center" data-toggle="modal" 
                        data-target="#staticModal" 
                        data-start="{{ $now_start }}" 
                        data-end="{{ $now_end }}"
                        data-title="{{ $schedule->title }}"
                        data-content="{{ $schedule->content }}"
                        data-category="{{ $schedule->category_id }}" 
                        data-id="{{ $schedule->id }}"><span class="{{ 'overflowStr_'.$hourDiff }}" style="display:block;">{{ $schedule->title }}</span></td>
                        
                        @else
                         <?php $count[$n] +=1; ?>
                        @endif
                      @elseif($now_start->gte($str_3)=== true && $now_start->lt($str_4)===true && $n == 0)
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
                            $now_start_pre = new \Carbon\Carbon($str_1);
                            ?>
                        @if($now_start_pre->isSameDay($now_end) == true)
                            <?php $hourDiff = $now_start_pre->diffInHours($now_end);
                           
                              if(($hourDiff + $n) > 24)
                              {
                                $hourDiff = (24 - $n);
                              }
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
                          <td class="myFeed shcedule-font {{  $color  }}" colspan="{{ $hourDiff }}" align="center" data-toggle="modal" 
                          data-target="#staticModal" 
                          data-start="{{ $now_start }}" 
                          data-end="{{ $now_end }}"
                          data-title="{{ $schedule->title }}"
                          data-content="{{ $schedule->content }}"
                          data-category="{{ $schedule->category_id }}"
                          data-id="{{ $schedule->id }}"><span class="{{ 'overflowStr_'.$hourDiff }}" style="display:block;">{{ $schedule->title }}</span></td>
                          
                          @endif
                        @endif
                      @endif
                    @endforeach
                    
                    @if($result === 0)
                      <td class="myFeed" colspan="1" align="center" data-toggle="modal" 
                      data-target="#inputModal" 
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
                    <span class="overflowStrName" style="display:block;"><b>{{ $user->user_name }}</b></span>
                  </a>
                </td>
                @for ($n=0;$n<24;$n++)
                  @if($count[$n] != 0 )
                  
                  <td class="yobiFeed" colspan="1" align="center">
                    <a data-target="#someModal" data-toggle="modal" class="modal-open" href="#">{{ "+".$count[$n] }}</a>
                  </td>
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
                          $str_3 = new \Carbon\Carbon($now_pre.' '.str_pad(0, 2, 0, STR_PAD_LEFT).':00'); 
                          $str_4 = new \Carbon\Carbon($now_pre.' '.str_pad(23, 2, 0, STR_PAD_LEFT).':00');
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
                            if(($hourDiff + $n) > 24)
                            {
                              $hourDiff = (24 - $n);
                            }
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
                        <td class="friendFeed shcedule-font {{  $color  }}" colspan="{{ $hourDiff }}" align="center" data-toggle="modal" 
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
                      @elseif($now_start->gte($str_3)=== true && $now_start->lt($str_4)===true && $n == 0)
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
                            $now_start_pre = new \Carbon\Carbon($str_1);
                        ?>
                        @if($now_start_pre->isSameDay($now_end) == true)
                        <?php
                            $hourDiff = $now_start_pre->diffInHours($now_end);
                            if(($hourDiff + $n) > 24)
                            {
                              $hourDiff = (24 - $n);
                            }
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
                        <td class="friendFeed shcedule-font {{  $color  }}" colspan="{{ $hourDiff }}" align="center" data-toggle="modal" 
                        data-target="#groupModal" 
                        data-start="{{ $now_start }}" 
                        data-end="{{ $now_end }}"
                        data-title="{{ $schedule->title }}"
                        data-content="{{ $schedule->content }}"
                        data-category="{{ $schedule->category_id }}"
                        data-groupid="{{ $group->master_id }}"><span class="{{ 'overflowStr_'.$hourDiff }}" style="display:block;">{{ $schedule->title }}</span></td>
                        
                        @endif 
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
                    <b>{{ $group->group_name  }}</b>
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
                          $str_3 = new \Carbon\Carbon($now_pre.' '.str_pad(0, 2, 0, STR_PAD_LEFT).':00'); 
                          $str_4 = new \Carbon\Carbon($now_pre.' '.str_pad(23, 2, 0, STR_PAD_LEFT).':00');
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
                            if(($hourDiff + $n) > 24)
                            {
                              $hourDiff = (24 - $n);
                            }
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
                        <td class="friendFeed shcedule-font {{  $color  }}" colspan="{{ $hourDiff }}" align="center" data-toggle="modal" 
                        data-target="#friendModal" 
                        data-start="{{ $now_start }}" 
                        data-end="{{ $now_end }}"
                        data-title="{{ $schedule->title }}"
                        data-content="{{ $schedule->content }}"
                        data-category="{{ $schedule->category_id }}"><span class="{{ 'overflowStr_'.$hourDiff }}" style="display:block;">{{ $schedule->title }}</span></td>
                        
                        @else
                         <?php $count_friend[$n] +=1; ?>
                        @endif
                      @elseif($now_start->gte($str_3)=== true && $now_start->lt($str_4)===true && $n == 0)
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
                            $now_start_pre = new \Carbon\Carbon($str_1);
                        ?>
                        @if($now_start_pre->isSameDay($now_end) == true)
                        <?php
                            $hourDiff = $now_start_pre->diffInHours($now_end);
                            if(($hourDiff + $n) > 24)
                            {
                              $hourDiff = (24 - $n);
                            }
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
                        <td class="friendFeed shcedule-font {{  $color  }}" colspan="{{ $hourDiff }}" align="center" data-toggle="modal" 
                        data-target="#friendModal" 
                        data-start="{{ $now_start }}" 
                        data-end="{{ $now_end }}"
                        data-title="{{ $schedule->title }}"
                        data-content="{{ $schedule->content }}"
                        data-category="{{ $schedule->category_id }}"><span class="{{ 'overflowStr_'.$hourDiff }}" style="display:block;">{{ $schedule->title }}</span></td>
                        
                        @endif
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
                    <span class="overflowStrName" style="display:block;"><b>{{ $friend->name  }}</b></span>
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
  <!-- 複数スケジュールダイアログ -->
  <div class="modal" id="someModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
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
          </div>
          </div>
        <div class="modal-footer">
        </div>
        <!-- hidden -->
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->  
  
  
  <!--(フローティングメニューに載せたいHTMLコード)-->
  <!--<div id="floating-menu">-->
  <!--   <i class="fa fa-btn fa-chevron-left"></i> {{ " "."$now"." " }}<i class="fa fa-btn fa-chevron-right"></i>-->
  <!--</div>-->
@endsection


@include('modal.input_modal', ['now' => $now,'my_timezone' => $my_timezone,])

@include('modal.change_modal', ['now' => $now,'my_timezone' => $my_timezone,])
@include('modal.offer_modal', ['now' => $now,'my_timezone' => $my_timezone,])
@include('modal.group_modal', ['now' => $now,'my_timezone' => $my_timezone,])
@include('modal.friend_modal', ['now' => $now,'my_timezone' => $my_timezone,])