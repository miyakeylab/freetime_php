<!-- resources/views/my_schedule.blade.php -->

@extends('layouts.app')

@section('content')
    <!-- Bootstrap の定形コード... -->
    <div class="panel-body" >
        <div class="table-responsive" id="LAYER">
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
        </table>
        
        </div>
    </div>
@endsection