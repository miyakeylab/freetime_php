<!-- resources/views/my_schedule.blade.php -->

@extends('layouts.app')

@section('content')
    <!-- Bootstrap の定形コード... -->
    <div class="panel-body">
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
        <table class="table table-bordered table-condensed demo2" style="font-size : 5px;">
            <thread>
            <tr>
                <th colspan="2" align="center">8/22</th>
                <?php for ($i=0;$i<24;$i++): ?>
                <th colspan="2" align="center"><?=$i?>:00</th>
                <?php endfor;?>
            </tr>
            </thread>
            <tbody>
            <tr>
                <td colspan="2" align="center">
                    <img class="media-object" src="{{url('css/assets/img/user_icon/no_icon.jpg')}}">
                </td>
                <td class="info" colspan="12" align="center">睡眠</td>
                <td colspan="36" align="center"><img class="media-object" src="{{url('css/assets/img/favicon.ico')}}"></td>
            </tr>
            <?php for ($i=0;$i<24;$i++): ?>
            <tr>
                <td colspan="2" align="center">
                    <img class="media-object" src="{{url('css/assets/img/user_icon/no_icon.jpg')}}">
                </td>
                <td class="info" colspan="12" align="center">睡眠</td>
                <td colspan="1" align="center">朝食</td>
                <td colspan="1" align="center"></td>
                <td colspan="2" align="center">移動</td>
                <td class="danger" colspan="6" align="center">仕事</td>
                <td colspan="26" align="center"></td>
            </tr>
            <?php endfor;?>
            </tbody>
        </table>
        </div>
        <div class="table-responsive" >       
        <div id="schedule-table">
            <div class="schedule-row">
                <div>8/22</div>
                @for ($i=0;$i<24;$i++)
                <div><?=$i?>:00</div>
                @endfor
            </div>
            @for ($k=0;$k<24;$k++)
            <div class="schedule-row-main">
                <div>
                <img class="media-object" src="{{url('css/assets/img/user_icon/no_icon.jpg')}}">
                </div>
                @for ($i=0;$i<24;$i++)
                @if($i === 2 )
                <div>work</div>
                @else
                <div></div>
                @endif
                @endfor
            </div>
            <div class="schedule-row-main">
                <div>ユーザー名
                </div>
                @for ($i=0;$i<24;$i++)
                <div></div>
                @endfor
            </div>
            @endfor
        </div>
        </div>
    </div>
@endsection