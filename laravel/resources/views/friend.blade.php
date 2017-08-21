<!-- resources/views/friend.blade.php -->

@extends('layouts.app')

@section('content')
    <!-- 友達 -->
    <div class="panel-body" >
        <div class="table-responsive" id="LAYER">
            <button>友達追加</button>
        
        @if (count($friends) > 0)
        <!-- 友達一覧 -->
        <table class="table table-bordered " style="font-size : 5px;">
            @foreach ($friends as $friend)
            <tr>
                <td colspan="2" align="center">{{ $friend->friend_user_id }}</td>
                <td colspan="2" align="center">{{ $friend->name }}</td>
            </tr>
            @endforeach
        </table>
        @endif
        </div>
    </div>
@endsection