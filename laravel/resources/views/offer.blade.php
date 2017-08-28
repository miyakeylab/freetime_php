<!-- resources/views/offer.blade.php -->

@extends('layouts.app')
@include('layouts.head')
@include('layouts.nav')

@section('content')
    <!-- オファー -->
    <div class="container" >
        <button type="submit" class="btn btn-success" >
        <i class="fa fa-btn fa-envelope-o"></i> オファー作成</button>
        <div class="padding-top-10">
        <div class="table-responsive">
        @if (count($offers) > 0)
        <!-- オファー一覧 -->
        <table class="table table-bordered table-condensed" style="font-size : 5px;">
            @foreach ($offers as $offer)
            <tr>
                <td colspan="2" align="center">{{ Config::get('const.OFFER_STRING')[$offer->state] }}</td>
                <td colspan="2" align="center">{{ $offer->content }}</td>
            </tr>
            @endforeach
        </table>
        @endif
        </div>
    </div>
@endsection