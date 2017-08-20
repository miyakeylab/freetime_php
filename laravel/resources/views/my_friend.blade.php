<!-- resources/views/my_schedule.blade.php -->

@extends('layouts.app')

@section('content')
    <!-- Bootstrap の定形コード... -->
    <div class="panel-body" >
        <div class="table-responsive" id="LAYER">
            <button>友達追加</button>
            @if (count($friends) > 0)
        <table class="table table-bordered table-condensed" style="font-size : 5px;">
            @foreach ($friends as $friend)

            <tr>
                <?php for ($i=0;$i<24;$i++): ?>
                <td colspan="2" align="center">{{ $friend-> }}</td>
                <?php endfor;?>
            </tr>
        </table>
        @endif
        </div>
    </div>
@endsection