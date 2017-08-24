<!-- resources/views/my_schedule.blade.php -->

@extends('layouts.app')

@section('content')
    <!-- Bootstrap の定形コード... -->
    <div class="panel-body">
        <div class="table-responsive" >
        <table class="table table-bordered table-condensed" style="font-size : 5px;">
            <tr>
                <?php for ($i=0;$i<48;$i++): ?>
                <th></th>
                <?php endfor;?>
            </tr>
            <tr>
                <?php for ($i=0;$i<24;$i++): ?>
                <td colspan="2" align="center"><?=$i?>:00</td>
                <?php endfor;?>
            </tr>
            <tr>
                <td class="info" colspan="12" align="center">睡眠</td>
                <td colspan="36" align="center"></td>
            </tr>
            <tr>
                <td class="info" colspan="12" align="center">睡眠</td>
                <td colspan="1" align="center">朝食</td>
                <td colspan="1" align="center"></td>
                <td colspan="2" align="center">移動</td>
                <td class="danger" colspan="6" align="center">仕事</td>
                <td colspan="26" align="center"></td>
            </tr>
        </table>
        </div>
        
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
@endsection