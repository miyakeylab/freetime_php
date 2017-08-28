<!-- resources/views/user_schedule.blade.php -->

@extends('layouts.app')
@include('layouts.head')
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
                <p>{{ $user->user_content."/".$user->user_sex."/".$user->user_birthday }}</p>
            </div>
        </div>
        
        <div class='table-responsive'>

        <script type="text/javascript">
        $(document).ready(function(){

          var $table = $('table');
          $table.floatThead({
              top:50,
              responsiveContainer: function($table){
                  return $table.closest('.table-responsive');
              }
          });
        });
        </script>
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
            @for ($i=1;$i<31;$i++)
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
@endsection