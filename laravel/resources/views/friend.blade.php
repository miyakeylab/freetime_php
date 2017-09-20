<!-- resources/views/friend.blade.php -->

@extends('layouts.app')
@include('layouts.head', ['page' => 2])
@include('layouts.nav')


@section('content')
    <!-- 友達 -->
    <div class="container" >

        <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
        <div class="panel-heading">{{ __('messages.friend_list') }}</div>
        <div class="panel-body">
        @if (count($friends) > 0)
            <?php $i=0; ?>
            <!-- 友達一覧 -->
            @foreach ($friends as $friend)
            <?php if($i !== 0){ ?>
            <hr class="style-one">
            <?php } ?>
            <?php $i++; ?>
            <div class="media">
                <!-- 1.画像の配置 -->
                <a class="media-left" href="{{ url('/user_schedule',$friend->friend_user_id) }}">
                    <img class="media-object user_icon_size" src="{{url($friend->user_img)}}">
                </a>
                <!-- 2.画像の説明 -->
                <div class="media-body">
                    @if($friend->name !== "")
                    <a href="{{ url('/user_schedule',$friend->friend_user_id) }}">
                    <h4 class="media-heading">{{ $friend->name }}</h4>
                    </a>
                    @endif
                    <p>{{ $friend->user_content."/".__('messages.user_sex')[$friend->user_sex]."/".$friend->user_birthday }}</p>
                </div>
            </div>
            @endforeach
            
        @endif
        </div>
        </div>
        </div>
        </div>
        
        <!--　友達申請　-->
        <div class="row">
        <div class="col-md-8 col-md-offset-2">        
        <div class="panel panel-default">
        <div class="panel-heading">{{ __('messages.friend_request_list') }}</div>
        <div class="panel-body">
        @if (count($friendOffers) > 0)
            <?php $i=0; ?>
            <!-- 友達一覧 -->
            @foreach ($friendOffers as $friendOffer)
            <?php if($i !== 0){ ?>
            <hr class="style-one">
            <?php } ?>
            <?php $i++; ?>
            <div class="media">
                <!-- 1.画像の配置 -->
                <a class="media-left" href="{{ url('/user_schedule',$friendOffer->user_id) }}">
                    <img class="media-object user_icon_size" src="{{url($friendOffer->user_img)}}">
                </a>
                <!-- 2.画像の説明 -->
                <div class="media-body">
                    @if($friendOffer->name !== "")
                    <a href="{{ url('/user_schedule',$friendOffer->user_id) }}">
                    <h4 class="media-heading">{{ $friendOffer->name }}</h4>
                    </a>
                    @endif
                    <p>{{ $friendOffer->content }}</p>
                </div>
                <div class="media-right">
                    <form class="form-horizontal" method="POST" action="{{ url('friend/reaponse/ok') }}">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-success">
                        <i class="fa fa-btn fa-user-plus"></i>{{ __('messages.friend_add') }}</button>
                        <input type="hidden" name="friend_res_ok_id" value="{{$friendOffer->master_id}}" />  
                    </form>
                    <div class="padding-top-10">
                        <form class="form-horizontal" method="POST" action="{{ url('friend/reaponse/ng') }}">
                            {{ csrf_field() }}                
                            <button type="submit" class="btn btn-danger">
                            <i class="fa fa-btn fa-frown-o"></i>{{ __('messages.friend_ng_Button') }}</button>
                            <input type="hidden" name="friend_res_ng_id" value="{{$friendOffer->master_id}}" />  
                        </form>
                    </div>
                </div>
            </div>

            @endforeach
        @endif
        </div>
        </div>            
        </div>
        </div>
        <!--　ユーザー一覧　-->
        <div class="row">
        <div class="col-md-8 col-md-offset-2">          
        <div class="panel panel-default">
        <div class="panel-heading">{{ __('messages.friend_user_list') }}</div>
        <div class="panel-body">
        @if (count($users) > 0)
            <?php $i=0; ?>
            <!-- 友達一覧 -->
            @foreach ($users as $user)
            <?php if($i !== 0){ ?>
            <hr class="style-one">
            <?php } ?>
            <?php $i++; ?>
            <div class="media">
                <!-- 1.画像の配置 -->
                <a class="media-left" href="{{ url('/user_schedule',$user->id) }}">
                    <img class="media-object user_icon_size" src="{{url($user->user_img)}}">
                </a>
                <!-- 2.画像の説明 -->
                <div class="media-body">
                    @if($user->name !== "")
                    <a href="{{ url('/user_schedule',$user->id) }}">
                    <h4 class="media-heading">{{ $user->name }}</h4>
                    </a>
                    @endif
                </div>
                <div class="media-right">
                    @if(in_array( $user->id, $RequestingUsers) === false)
                        @if(in_array( $user->id, $ResUsers) === false)
                            <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#friendOfferModal" data-name="{{ $user->name }}" data-id="{{ $user->id }}" >
                            <i class="fa fa-btn fa-user-plus"></i>{{ __('messages.friend_request_Button') }}</button>
                        @else
                            <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#friendOfferModal" data-name="{{ $user->name }}" data-id="{{ $user->id }}" disabled>
                             {{ __('messages.friend_request_receiving') }}</button>
                        @endif
                    @else
                        <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#friendOfferModal" data-name="{{ $user->name }}" data-id="{{ $user->id }}" disabled>
                         {{ __('messages.friend_request_pending') }}</button>
                    @endif
                </div>
            </div>
            @endforeach
        @endif
        </div>
        </div>
        </div>
        </div>
     </div>
     
　<!-- 申請モーダルダイアログ -->
  <div class="modal" id="friendOfferModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="POST" action="{{ url('friend/offer') }}">
            {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&#215;</span><span class="sr-only">{{ __('messages.schedule_close') }}</span>
          </button>
          <h4 class="modal-title">{{ __('messages.friend_request_Button') }}</h4>
        </div><!-- /modal-header -->

        <div class="modal-body">
          <div class="panel panel-default">
            <div class="panel-heading">{{ __('messages.schedule_modal_content_title') }}</div>
            <div class="panel-body">
            <p class="friend_user_name"></p>
            <label for="friend-offer-content" class="col-md-4 control-label">{{ __('messages.friend_request_message') }}</label>
            <div class="col-md-6"  >
                <textarea class="form-control" id="friend-offer-content" name="friendoffer_content" cols="45" rows="3" ></textarea>
            </div>
            <input class="user_id" type="hidden" name="friendoffer_id" id="friendoffer_id" />      
            </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('messages.schedule_modal_close') }}</button>
          <button type="submit" class="btn btn-primary">{{ __('messages.friend_request_Button') }}</button>
        </div>
        </form>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->
     
@endsection