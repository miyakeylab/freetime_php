<!-- resources/views/offer.blade.php -->

@extends('layouts.app')
@include('layouts.head')
@include('layouts.nav')

@section('content')
    <!-- オファー -->
    <div class="container" >
        <div class="table-responsive" id="LAYER">
            <button>オファー作成</button>
        
        @if (count($offers) > 0)
        <!-- オファー一覧 -->
        <table class="table table-bordered table-condensed" style="font-size : 5px;">
            @foreach ($offers as $offer)
            <tr>
                <td colspan="2" align="center">{{ $offer->state }}</td>
                <td colspan="2" align="center">{{ $offer->content }}</td>
            </tr>
            @endforeach
        </table>
        @endif
        </div>
    </div>
@endsection