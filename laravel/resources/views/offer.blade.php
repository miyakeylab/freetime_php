<!-- resources/views/offer.blade.php -->

@extends('layouts.app')
@include('layouts.head', ['page' => 1])
@include('layouts.nav')

@section('content')
    <!-- オファー -->
    <div class="container" >
        <div class="col-md-8"> 
        <button type="submit" class="btn btn-success" 
        data-toggle="modal" 
        data-target="#staticModal" 
        data-start="" 
        data-end="" 
        data-title=""
        data-content=""
        data-category="0"
        >            
        <i class="fa fa-btn fa-envelope-o"></i>{{ __('messages.offerCerate') }}</button>
        <div class="padding-top-10"></div>
        </div>
        <div class="row">
        <div class="col-md-6">  
        <div class="panel panel-default">
        <div class="panel-heading">{{ __('messages.recOfferList') }}</div>
        <div class="panel-body fixed-panel-user">
        @if (count($offers) > 0)
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
                   
                </a>
                <!-- 2.画像の説明 -->
                <div class="media-body">
                    <h4 class="media-heading">{{ $offer->title }}</h4>
                    <p>{{ __('messages.offerTimeStart').' '.$offer->start_time.' 〜 '.__('messages.offerTimeEnd').' '.$offer->end_time }}</p>
                    <p>{{ $offer->user_name  }}</p>
                </div>
                <div class="media-right">
                     <form class="form-horizontal" method="POST" action="{{ url('offer/reaponse/ok') }}">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-success">
                        <i class="fa fa-btn fa-user-plus"></i>{{ __('messages.offerOkButton') }}</button>
                        <input type="hidden" name="offer_res_ok_id" value="{{ $offer->master_id }}" />  
                    </form>
                    <div class="padding-top-10">
                        <form class="form-horizontal" method="POST" action="{{ url('offer/reaponse/ng') }}">
                            {{ csrf_field() }}                
                            <button type="submit" class="btn btn-danger">
                            <i class="fa fa-btn fa-frown-o"></i>{{ __('messages.offerNgButton') }}</button>
                            <input type="hidden" name="offer_res_ng_id" value="{{ $offer->master_id }}" />  
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
        </div>
        </div>           
        </div>

        <div class="col-md-6">  
        <div class="panel panel-default">
        <div class="panel-heading">{{ __('messages.reqOfferList') }}</div>
        <div class="panel-body fixed-panel-user">
                    
        @if (count($offerReqs) > 0)
            <!-- 申請中オファー一覧 -->
            <?php $i = 0; ?>
            @foreach ($offerReqs as $offer)
            <?php if($i !== 0){ ?>
            <hr class="style-one">
            <?php } ?>
            <?php $i++; ?>
            <div class="media">
                <!-- 1.画像の配置 -->
                <a class="media-left" href="#">
                </a>
                <!-- 2.画像の説明 -->
                <div class="media-body">
                    <h4 class="media-heading">{{ $offer->title }}</h4>
                    <p>{{ __('messages.offerTimeStart').' '.$offer->start_time.' 〜 '.__('messages.offerTimeEnd').' '.$offer->end_time }}</p>
                    <p>{{ $offer->user_name  }}</p>
                    <p>{{ __('messages.offer_state')[$offer->state] }}</p>
                </div>
            </div>
            @endforeach
            
        @endif
        </div>
        </div>           
        </div>
        </div>
        </div>
    </div>
    
  <!-- オファーモーダルダイアログ -->
  <div class="modal" id="staticModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="POST" action="{{ url('offer/set') }}">
            {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&#215;</span><span class="sr-only">{{ __('messages.schedule_close') }}</span>
          </button>
          <h4 class="modal-title">{{ __('messages.offerCerate') }}</h4>
        </div><!-- /modal-header -->
          <div class="panel panel-default">
                <div class="panel-heading">{{ __('messages.schedule_modal_date') }}</div>
                <div class="panel-body">
           <div class="padding-top-5"></div>
            <label for="schedule-start" class="col-md-4 control-label">{{ __('messages.schedule_modal_start') }}</label>
            <div class="col-md-5 input-group date" >
                <input class="form-control" type="text" id="schedule-start" name="schedule_start" />
                <span class="input-group-addon"><span class="add-on glyphicon glyphicon-th"></span></span>
            </div>
            <div class="padding-top-5"></div>
            <label for="schedule-end" class="col-md-4 control-label">{{ __('messages.schedule_modal_end') }}</label>
            <div class="col-md-5 input-group date" >
                <input class="form-control" type="text" id="schedule-end" name="schedule_end" />
                <span class="input-group-addon"><span class="add-on glyphicon glyphicon-th"></span></span>
            </div>
            </div>
            </div>
        <div class="modal-body">
          <div class="panel panel-default">
            <div class="panel-heading">{{ __('messages.schedule_modal_content_title') }}</div>
            <div class="panel-body">
            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2"  >
                <input type="text" class="form-control" id="schedule-title" name="schedule_title" ></textarea>
            </div>
            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2"  >
                <textarea class="form-control" id="schedule-content" name="schedule_content" cols="45" rows="4" ></textarea>
            </div>
            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2"  >
            
            <div class="checkbox-inline">
              <input type="radio" value="Default" name="colors" id="colors_default" >
                <label for="colors_default" ><span class="badge badge-default">FreeTime</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Primary" name="colors" id="colors_primary">
                <label for="colors_primary"><span class="badge badge-primary">Work</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Success" name="colors" id="colors_success">
                <label for="colors_success"><span class="badge badge-success">Play</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Info" name="colors" id="colors_info">
                <label for="colors_info"><span class="badge badge-info">Sleep</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Warning" name="colors" id="colors_warning">
                <label for="colors_warning"><span class="badge badge-warning">Etc</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Danger" name="colors" id="colors_danger">
                <label for="colors_danger"><span class="badge badge-danger">Block</span></label>
            </div> 
            </div>
            </div>
            </div>
          <div class="panel panel-default">
            <!-- 友達一覧 -->
            <div class="panel-heading">{{ __('messages.friend_user_list') }}</div>
            <div class="panel-body fixed-panel">
            
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
                <a class="media-left">
                    <img class="media-object user_icon_size" src="{{url($friend->user_img)}}">
                </a>
                <!-- 2.画像の説明 -->
                <div class="media-body">
                    @if($friend->name !== "")
                    <h4 class="media-heading">{{ $friend->name }}</h4>
                    @endif
                    <div class="checkbox">
        				<label>
        					<input type="checkbox" name="addUser[]" value="{{ $friend->friend_user_id }}"> {{ __('messages.offerCheck') }}
        				</label>
        			</div>
                </div>
                <div class="media-right">

                </div>
            </div>
            @endforeach
        @endif
        </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('messages.schedule_modal_close_button') }}</button>
          <button type="submit" class="btn btn-primary">{{ __('messages.offerCerate') }}</button>
        </div>
        </form>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->
@endsection