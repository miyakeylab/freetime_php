<!-- resources/views/my_schedule.blade.php -->

@extends('layouts.app')
@include('layouts.head')
@include('layouts.nav')

@section('content')
    <div class="panel-body">
        <button type="submit" class="btn btn-success" id="staticModalButton">
        <i class="fa fa-btn fa-calendar"></i> スケジュール新規作成</button>
        <div class="padding-top-10">

        <div class='table-responsive'>
        <table class="table table-striped sticky-header" style="font-size : 5px;">
            <thead>
            <tr>
                <th colspan="1" align="center">{{ $now }}</th>
                @for ($i=0;$i<24;$i++)
                @if ($i === $hour )
                <th class="info" colspan="1" align="center">{{ "NOW" }}</th>
                @else
                <th colspan="1" align="center">{{ $i.":00" }}</th>
                @endif
                @endfor
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="1" align="center">
                    <img class="media-object" src="{{url('css/assets/img/user_icon/no_icon.jpg')}}">
                </td>
                <td class="info" colspan="6" align="center"><a href="#staticModal" data-toggle="modal" data-whatever="睡眠">睡眠</a></td>
                
                @for ($n=0;$n<18;$n++)
                @if ($n === 1)
                <td class="myFeed" colspan="1" align="center" id="{{ 'td-'.$n }}" ><img class="media-object" src="{{url('css/assets/img/favicon.ico')}}"></td>
                @else
                <td class="myFeed" colspan="1" align="center" ></td>
                @endif
                @endfor
            </tr>
            <tr>
                <td colspan="1" align="center">
                    ユーザー名
                </td>
                @for ($n=0;$n<24;$n++)
                <th colspan="1" align="center"></th>
                @endfor
            </tr>
            @for ($i=0;$i<24;$i++)
            <tr>
                <td colspan="1" align="center">
                    <img class="media-object" src="{{url('css/assets/img/user_icon/no_icon.jpg')}}">
                </td>
                <td class="info friendFeed" colspan="6" align="center">睡眠</td>
                <td class="friendFeed" colspan="1" align="center">朝食</td>
                <td class="friendFeed" colspan="1" align="center"></td>
                <td class="friendFeed" colspan="2" align="center">移動</td>
                <td class="danger friendFeed" colspan="6" align="center">仕事</td>
                <td class="friendFeed" colspan="8" align="center"></td>
            </tr>
            <tr>
                <td colspan="1" align="center">
                    ユーザー名
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
    </div>
  <!-- 自モーダルダイアログ -->
  <div class="modal" id="staticModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="POST" action="{{ url('my_schedule/set') }}">
            {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&#215;</span><span class="sr-only">閉じる</span>
          </button>
          <h4 class="modal-title">スケジュール登録</h4>
        </div><!-- /modal-header -->
          <div class="panel panel-default">
                <div class="panel-heading">日時</div>
                <div class="panel-body">
           <div class="padding-top-5"></div>
            <label for="schedule-start" class="col-md-4 control-label">開始</label>
            <div class="col-md-4 input-group date" >
                <input class="form-control" type="text" id="schedule-start">
                <span class="input-group-addon"><span class="add-on glyphicon glyphicon-th"></span></span>
            </div>
            <div class="padding-top-5"></div>
            <label for="schedule-end" class="col-md-4 control-label">終了</label>
            <div class="col-md-4 input-group date" >
                <input class="form-control" type="text" id="schedule-end">
                <span class="input-group-addon"><span class="add-on glyphicon glyphicon-th"></span></span>
            </div>
            </div>
            </div>
        <div class="modal-body">
          <div class="panel panel-default">
            <div class="panel-heading">内容</div>
            <div class="panel-body">
            <label for="schedule-content" class="col-md-4 control-label">内容</label>
            <div class="col-md-6"  >
                <textarea class="form-control" id="schedule-content" cols="45" rows="8" ></textarea>
            </div>
            </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
          <button type="submit" class="btn btn-primary">登録</button>
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
            <span aria-hidden="true">&#215;</span><span class="sr-only">閉じる</span>
          </button>
          <h4 class="modal-title">スケジュール表示</h4>
        </div><!-- /modal-header -->
        <div class="modal-body">
          <p class="recipient">本文</p>
        </div>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->
  <!--(フローティングメニューに載せたいHTMLコード)-->
  <div id="floating-menu">
     <i class="fa fa-btn fa-chevron-up"></i>
     <div class="padding-top-5"></div>
     <i class="fa fa-btn fa-chevron-left"></i> <i class="fa fa-btn fa-chevron-right"></i>
     <div class="padding-top-5"></div>
     <i class="fa fa-btn fa-chevron-down"></i> 
  </div>
@endsection
