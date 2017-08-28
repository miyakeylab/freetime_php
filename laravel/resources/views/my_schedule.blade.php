<!-- resources/views/my_schedule.blade.php -->

@extends('layouts.app')
@include('layouts.head')
@include('layouts.nav')

@section('content')
    <div class="panel-body">
        <button type="submit" class="btn btn-success">
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
                <td class="info" colspan="6" align="center">睡眠</td>
                <td colspan="18" align="center"><img class="media-object" src="{{url('css/assets/img/favicon.ico')}}"></td>
            </tr>
            <tr>
                <td colspan="1" align="center">
                    ユーザー名
                </td>
                <?php for ($n=0;$n<24;$n++): ?>
                <th colspan="1" align="center"></th>
                <?php endfor;?>
            </tr>
            <?php for ($i=0;$i<24;$i++): ?>
            <tr>
                <td colspan="1" align="center">
                    <img class="media-object" src="{{url('css/assets/img/user_icon/no_icon.jpg')}}">
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
                    ユーザー名
                </td>
                <?php for ($n=0;$n<24;$n++): ?>
                <th colspan="1" align="center"></th>
                <?php endfor;?>
            </tr>
            <?php endfor;?>
            </tbody>
        </table>
        </div>
    </div>
@endsection
