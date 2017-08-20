<!-- resources/views/my_group.blade.php -->

@extends('layouts.app')

@section('content')
    <!-- グループ -->
    <div class="panel-body" >
        <div class="table-responsive" id="LAYER">
            <button>グループ新規作成</button>
        
        @if (count($groups) > 0)
        <!-- グループ一覧 -->
        <table class="table table-bordered table-condensed" style="font-size : 5px;">
            @foreach ($groups as $group)
            <tr>
                <td colspan="2" align="center">{{ $group->group_name }}</td>
            </tr>
            @endforeach
        </table>
        @endif
        </div>
    </div>
@endsection