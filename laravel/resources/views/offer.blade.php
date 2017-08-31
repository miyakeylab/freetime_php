<!-- resources/views/offer.blade.php -->

@extends('layouts.app')
@include('layouts.head')
@include('layouts.nav')

@section('content')
    <!-- オファー -->
    <div class="container" >
        <div class="col-md-8 col-md-offset-2"> 
        <button type="submit" class="btn btn-success" >
        <i class="fa fa-btn fa-envelope-o"></i> オファー作成</button>
        <div class="padding-top-10"></div>
        </div>
        @if (count($offers) > 0)
        <div class="row">
        <div class="col-md-8 col-md-offset-2">  
        <div class="panel panel-default">
        <div class="panel-heading">受領オファー一覧</div>
        <div class="panel-body">
            <!-- 受領オファー一覧 -->
            <?php $i = 0; ?>
            @foreach ($offers as $offer)
            <?php if($i !== 0){ ?>
            <hr class="style-one">
            <?php } ?>
            <?php $i++; ?>
            <div class="media">
                <!-- 1.画像の配置 -->
                <a class="media-left" href="#">
                   {{ Config::get('const.OFFER_STRING')[$offer->state] }}
                </a>
                <!-- 2.画像の説明 -->
                <div class="media-body">
                    <h4 class="media-heading">{{ $offer->content }}</h4>
                </div>
                <div class="media-right">
                    <button type="submit" class="btn btn-danger">
                    <i class="fa fa-btn fa-frown-o"></i> 拒否</button>
                </div>
            </div>
            @endforeach
            </div>
            </div>           
            </div>
        </div>
        @endif
        
        @if (count($offers) > 0)
        <div class="row">
        <div class="col-md-8 col-md-offset-2">  
        <div class="panel panel-default">
        <div class="panel-heading">申請中オファー一覧</div>
        <div class="panel-body">
            <!-- 受領オファー一覧 -->
            <?php $i = 0; ?>
            @foreach ($offers as $offer)
            <?php if($i !== 0){ ?>
            <hr class="style-one">
            <?php } ?>
            <?php $i++; ?>
            <div class="media">
                <!-- 1.画像の配置 -->
                <a class="media-left" href="#">
                   {{ Config::get('const.OFFER_STRING')[$offer->state] }}
                </a>
                <!-- 2.画像の説明 -->
                <div class="media-body">
                    <h4 class="media-heading">{{ $offer->content }}</h4>
                </div>
            </div>
            @endforeach
            </div>
            </div>           
            </div>
        </div>
        @endif
        </div>
    </div>
@endsection