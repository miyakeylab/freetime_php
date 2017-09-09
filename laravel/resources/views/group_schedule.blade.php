<!-- resources/views/group_schedule.blade.php -->

@extends('layouts.app')
@include('layouts.head', ['page' => 1])
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
                <button type="submit" class="btn btn-success" id="staticModalButton">
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
@endsection