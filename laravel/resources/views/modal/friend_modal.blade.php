@section('friend_modal')
  <!-- 他モーダルダイアログ -->
  <div class="modal" id="friendModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false" >
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="POST" action="{{ url('schedule_main/share') }}">
            {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&#215;</span><span class="sr-only">{{ __('messages.schedule_modal_close') }}</span>
          </button>
          <h4 class="modal-title">{{ __('messages.schedule_modal_disp') }}</h4>
        </div><!-- /modal-header -->
        <div class="modal-body">
        <div class="panel panel-default">
              <div class="panel-heading">{{ __('messages.schedule_modal_date') }}</div>
              <div class="panel-body">
         <div class="padding-top-5"></div>
          <label for="friend-schedule-start" class="col-md-4 control-label">{{ __('messages.schedule_modal_start') }}</label>
          <div class="col-md-5 input-group date" >
              <input class="form-control" type="text" id="friend-schedule-start" name="friend_schedule_start" readonly="readonly" />
          </div>
          <div class="padding-top-5"></div>
          <label for="friend-schedule-end" class="col-md-4 control-label">{{ __('messages.schedule_modal_end') }}</label>
          <div class="col-md-5 input-group date" >
              <input class="form-control" type="text" id="friend-schedule-end" name="friend_schedule_end" readonly="readonly" />
          </div>
          </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">{{ __('messages.schedule_modal_content_title') }}</div>
            <div class="panel-body">
            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2"  >
                <input type="text" class="form-control" id="friend-schedule-title" name="friend_schedule_title" readonly="readonly" ></textarea>
            </div>
            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2"  >
                <textarea class="form-control" id="friend-schedule-content" name="friend_schedule_content" cols="45" rows="4" readonly="readonly" ></textarea>
            </div>
            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2"  >
            
            <div class="checkbox-inline">
              <input type="radio" value="Default" name="friend_colors" id="friend-colors_default">
                <label for="colors_default" ><span class="badge badge-default">FreeTime</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Primary" name="friend_colors" id="friend-colors_primary" >
                <label for="colors_primary"><span class="badge badge-primary">Work</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Success" name="friend_colors" id="friend-colors_success" >
                <label for="colors_success"><span class="badge badge-success">Play</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Info" name="friend_colors" id="friend-colors_info" >
                <label for="colors_info"><span class="badge badge-info">Sleep</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Warning" name="friend_colors" id="friend-colors_warning" >
                <label for="colors_warning"><span class="badge badge-warning">Etc</span></label>
            </div>
            <div class="checkbox-inline">
              <input type="radio" value="Danger" name="friend_colors" id="friend-colors_danger" >
                <label for="colors_danger"><span class="badge badge-danger">Block</span></label>
            </div> 
            </div>
            </div>
            </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('messages.schedule_modal_close_button') }}</button>
              <button type="submit" class="btn btn-primary">{{ __('messages.schedule_modal_share') }}</button>
            </div>
            <input type="hidden" name="now_day" value="{{ $now }}" />
            <input type="hidden" name="my_timezone" value="{{ $my_timezone }}" /> 
          </form>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->
@endsection