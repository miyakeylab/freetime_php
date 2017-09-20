<!-- resources/views/user_schedule.blade.php -->

@extends('layouts.app')
@include('layouts.head', ['page' => 1])
@include('layouts.nav')

@section('content')
  
    <div class="panel-body">
        
        
        <!-- ユーザー詳細 -->
        <div class="media">
            <!-- 1.画像の配置 -->
            <a class="media-left" href="#">
                <img class="media-object" src="{{url($user->user_img)}}">
            </a>
            <!-- 2.画像の説明 -->
            <div class="media-body">
                <h4 class="media-heading">{{ $user->name }}</h4>
                <p>{{ $user->user_content."/".__('messages.user_sex')[$user->user_sex]."/".$user->user_birthday }}</p>
            </div>
        </div>
        
        <div class='table-responsive'>

        <table class="table table-striped sticky-header">
            <thead>
            <tr>
                <th colspan="1" align="center"><b>{{ $month."月" }}</b></th>
                @for ($i=0;$i<24;$i++)

                <th colspan="1" align="center"><b>{{ $i.":00" }}</b></th>
                @endfor
            </tr>
            </thead>
            <tbody>
            @for ($i=1;$i<=$maxMonth;$i++)
            <tr>
                <td colspan="1" align="center">
                    {{ $month."/".$i }} 
                </td>
                <?php $TempSch = $mySchedule[($i-1)]; ?>
                <?php $hourDiff = 0; ?>
                @for ($n=0; $n<24; $n++)
                   <?php  $str_1 = new \Carbon\Carbon($year.'/'.str_pad($month, 2, 0, STR_PAD_LEFT).'/'.str_pad($i, 2, 0, STR_PAD_LEFT).' '.str_pad($n, 2, 0, STR_PAD_LEFT).':00'); 
                          $str_2 = new \Carbon\Carbon($year.'/'.str_pad($month, 2, 0, STR_PAD_LEFT).'/'.str_pad($i, 2, 0, STR_PAD_LEFT).' '.str_pad($n+1, 2, 0, STR_PAD_LEFT).':00'); 
                          $result = 0; 
                          $count[$n] = 0; ?>
                  @if($hourDiff <= 0 )
                    <!-- スケジュール -->
                    @foreach( $TempSch as $schedule)
                      
                      <?php $now_start = new \Carbon\Carbon($schedule->start_time); ?>                    
                      
                      @if ($now_start->gte($str_1)=== true && $now_start->lt($str_2)===true)
                        
                        <?php $now_end = new \Carbon\Carbon($schedule->end_time); 
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
                        <td class="{{ $feed.' '.$color  }}" colspan="{{ $hourDiff }}" align="center" data-toggle="modal" 
                        data-target="{{ '#'.$modal }}" 
                        data-start="{{ $schedule->start_time }}" 
                        data-end="{{ $schedule->end_time }}"
                        data-title="{{ $schedule->title }}"
                        data-content="{{ $schedule->content }}"><span class="{{ 'overflowStr_'.$hourDiff }}" style="display:block;">{{ $schedule->title }}</span></td>
                        
                        @else
                         <?php $count[$n] +=1; ?>
                        @endif
                      @endif
                    @endforeach
                    
                    @if($result === 0)
                      <td class="{{ $feed }}" colspan="1" align="center" data-toggle="modal" 
                      data-target="{{ '#'.$modal }}" 
                      data-start="{{ $year.'/'.str_pad($month, 2, 0, STR_PAD_LEFT).'/'.str_pad($i, 2, 0, STR_PAD_LEFT).' '.str_pad($n, 2, 0, STR_PAD_LEFT).':00' }}" 
                      data-end="{{ $year.'/'.str_pad($month, 2, 0, STR_PAD_LEFT).'/'.str_pad($i, 2, 0, STR_PAD_LEFT).' '.str_pad(($n+1), 2, 0, STR_PAD_LEFT).':00' }}"
                      data-title=""
                      data-content=""></td>
                    @else
                     <?php $hourDiff -= 1; ?>
                    @endif
                  @else
                    <?php $hourDiff -= 1; ?>
                    <!-- スケジュールカウント処理 -->
                    @foreach( $TempSch as $schedule)
                      <?php $now_start = new \Carbon\Carbon($schedule->start_time); ?>
                      @if ($now_start->gte($str_1)=== true && $now_start->lt($str_2)===true)
                         <?php $count[$n] +=1; ?>
                      @endif
                    @endforeach
                  @endif
                @endfor
            </tr>
            <tr>
                <td colspan="1" align="center">
                </td>
                @for ($n=0;$n<24;$n++)
                  @if($count[$n] != 0)
                    <td class="yobiFeed" colspan="1" align="center">{{ "+".$count[$n] }}</td>
                  @else
                    <td class="yobiFeed" colspan="1" align="center"></td>
                  @endif
                @endfor
            </tr>
            @endfor
            </tbody>
        </table>
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
        <div class="panel panel-default">
              <div class="panel-heading">{{ __('messages.schedule_modal_date') }}</div>
              <div class="panel-body">
         <div class="padding-top-5"></div>
          <label for="schedule-start" class="col-md-4 control-label">{{ __('messages.schedule_modal_start') }}</label>
          <div class="col-md-5 input-group date" >
              <input class="form-control" type="text" id="friend-schedule-start"  readonly="readonly" />
          </div>
          <div class="padding-top-5"></div>
          <label for="schedule-end" class="col-md-4 control-label">{{ __('messages.schedule_modal_end') }}</label>
          <div class="col-md-5 input-group date" >
              <input class="form-control" type="text" id="friend-schedule-end"  readonly="readonly" />
          </div>
          </div>
          </div>
        <div class="modal-body">
          <div class="panel panel-default">
            <div class="panel-heading">{{ __('messages.schedule_modal_content_title') }}</div>
            <div class="panel-body">
            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2"  >
                <input type="text" class="form-control" id="friend-schedule-title"  readonly="readonly" ></textarea>
            </div>
            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2"  >
                <textarea class="form-control" id="friend-schedule-content"  cols="45" rows="4" readonly="readonly" ></textarea>
            </div>
            </div>
          </div>
        </div>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->
@endsection