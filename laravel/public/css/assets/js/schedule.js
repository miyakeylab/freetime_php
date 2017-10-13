/**
 * schedule 処理
 */
$(function () {
    // テーブル処理
    $(document).ready(TableInit);
    
    /**
     * スケジュールボタン
     */
    // ダイアログ表示前にJavaScriptで操作する
    $('#staticModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var hour_start = button.data('start');
      var hour_end = button.data('end');
      var title = button.data('title');
      var content = button.data('content');
      var category = button.data('category');
      var id = button.data('id');
      
      var modal = $(this);
      modal.find('#schedule-start').val(hour_start);
      modal.find('#schedule-end').val(hour_end);
      modal.find('#schedule-title').val(title);  
      modal.find('#schedule-content').val(content);
      modal.find('#schedule-id_mod').val(id);
      modal.find('#schedule-id_del').val(id);
      switch (category) {
        case 0:
          modal.find('#colors_default').prop('checked','checked');
          break;
        case 1:
          modal.find('#colors_primary').prop('checked','checked');
          break;
        case 2:
          modal.find('#colors_success').prop('checked','checked');
          break;
        case 3:
          modal.find('#colors_info').prop('checked','checked');
          break;
        case 4:
          modal.find('#colors_warning').prop('checked','checked');
          break;
        case 5:
          modal.find('#colors_danger').prop('checked','checked');
          break;
        default:
          modal.find('#colors_default').prop('checked','checked');
          break;
      }
      
    });
    // ダイアログ表示直後にフォーカスを設定する
    $('#staticModal').on('shown.bs.modal', function(event) {
      $(this).find('.modal-footer .btn-default').focus();
    });
    $('#staticModal').on('click', '.modal-footer .btn-primary', function() {
      $('#staticModal').modal('hide');
    });
    /**
     * スケジュールボタン
     */
    // ダイアログ表示前にJavaScriptで操作する
    $('#inputModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var hour_start = button.data('start');
      var hour_end = button.data('end');
      var title = button.data('title');
      var content = button.data('content');
      var category = button.data('category');
      var id = button.data('id');
      
      var modal = $(this);
      modal.find('#schedule-start_in').val(hour_start);
      modal.find('#schedule-end_in').val(hour_end);
      modal.find('#schedule-title_in').val(title);  
      modal.find('#schedule-content_in').val(content);
      modal.find('#schedule-id_in').val(id);

      switch (category) {
        case 0:
          modal.find('#colors_default_in').prop('checked','checked');
          break;
        case 1:
          modal.find('#colors_primary_in').prop('checked','checked');
          break;
        case 2:
          modal.find('#colors_success_in').prop('checked','checked');
          break;
        case 3:
          modal.find('#colors_info_in').prop('checked','checked');
          break;
        case 4:
          modal.find('#colors_warning_in').prop('checked','checked');
          break;
        case 5:
          modal.find('#colors_danger_in').prop('checked','checked');
          break;
        default:
          modal.find('#colors_default_in').prop('checked','checked');
          break;
      }
      
    });
    // ダイアログ表示直後にフォーカスを設定する
    $('#inputModal').on('shown.bs.modal', function(event) {
      $(this).find('.modal-footer .btn-default').focus();
    });
    $('#inputModal').on('click', '.modal-footer .btn-primary', function() {
      $('#inputModal').modal('hide');
    });    
    /**
     * グループスケジュールボタン
     */
    // ダイアログ表示前にJavaScriptで操作する
    $('#groupModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var hour_start = button.data('start');
      var hour_end = button.data('end');
      var title = button.data('title');
      var content = button.data('content');
      var category = button.data('category');
      var group_id = button.data('groupid');
      console.log(category);
      var modal = $(this);
      modal.find('#schedule-start').val(hour_start);
      modal.find('#schedule-end').val(hour_end);
      modal.find('#schedule-title').val(title);  
      modal.find('#schedule-content').val(content);
      modal.find('#group_id').val(group_id);
      
      switch (category) {
        case 0:
          modal.find('#colors_default').prop('checked','checked');
          break;
        case 1:
          modal.find('#colors_primary').prop('checked','checked');
          break;
        case 2:
          modal.find('#colors_success').prop('checked','checked');
          break;
        case 3:
          modal.find('#colors_info').prop('checked','checked');
          break;
        case 4:
          modal.find('#colors_warning').prop('checked','checked');
          break;
        case 5:
          modal.find('#colors_danger').prop('checked','checked');
          break;
        default:
          modal.find('#colors_default').prop('checked','checked');
          break;
      }
      
    });
    // ダイアログ表示直後にフォーカスを設定する
    $('#groupModal').on('shown.bs.modal', function(event) {
      $(this).find('.modal-footer .btn-default').focus();
    });
    $('#groupModal').on('click', '.modal-footer .btn-primary', function() {
      $('#groupModal').modal('hide');
    });    
    /**
     * 友達スケジュールボタン
     */
    // $('.friendFeed').on('click', function() {
    //   $('#friendModal').modal();
    // });     
        // ダイアログ表示前にJavaScriptで操作する
    $('#friendModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var hour_start = button.data('start');
      var hour_end = button.data('end');
      var title = button.data('title');
      var content = button.data('content');
      var category = button.data('category');
      console.log(hour_start);
      var modal = $(this);
      modal.find('#friend-schedule-start').val(hour_start);
      modal.find('#friend-schedule-end').val(hour_end);
      modal.find('#friend-schedule-title').val(title);  
      modal.find('#friend-schedule-content').val(content);
      
      switch (category) {
        case 0:
          modal.find('#friend-colors_default').prop('checked','checked');
          break;
        case 1:
          modal.find('#friend-colors_primary').prop('checked','checked');
          break;
        case 2:
          modal.find('#friend-colors_success').prop('checked','checked');
          break;
        case 3:
          modal.find('#friend-colors_info').prop('checked','checked');
          break;
        case 4:
          modal.find('#friend-colors_warning').prop('checked','checked');
          break;
        case 5:
          modal.find('#friend-colors_danger').prop('checked','checked');
          break;
        default:
          modal.find('#friend-colors_default').prop('checked','checked');
          break;
      }
    });
    // ダイアログ表示直後にフォーカスを設定する
    $('#friendModal').on('shown.bs.modal', function(event) {
      $(this).find('.modal-footer .btn-default').focus();
    });
    $('#friendModal').on('click', '.modal-footer .btn-primary', function() {
      $('#friendModal').modal('hide');
    });
    
    /**
     * オファーボタン
     */
    // ダイアログ表示前にJavaScriptで操作する
    $('#offerModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var hour_start = button.data('start');
      var hour_end = button.data('end');
      var title = button.data('title');
      var content = button.data('content');
      var category = button.data('category');
      var user_name = button.data('username');
      var id = button.data('userid');
      console.log(hour_start);
      var modal = $(this);
      modal.find('#offer-schedule-start').val(hour_start);
      modal.find('#offer-schedule-end').val(hour_end);
      modal.find('#offer-schedule-title').val(title);  
      modal.find('#offer-schedule-content').val(content);
      modal.find('#friend_user_name').text(user_name);
      modal.find('#offer_friend_id').val(id);
      
      switch (category) {
        case 0:
          modal.find('#offer-colors_default').prop('checked','checked');
          break;
        case 1:
          modal.find('#offer-colors_primary').prop('checked','checked');
          break;
        case 2:
          modal.find('#offer-colors_success').prop('checked','checked');
          break;
        case 3:
          modal.find('#offer-colors_info').prop('checked','checked');
          break;
        case 4:
          modal.find('#offer-colors_warning').prop('checked','checked');
          break;
        case 5:
          modal.find('#offer-colors_danger').prop('checked','checked');
          break;
        default:
          modal.find('#offer-colors_default').prop('checked','checked');
          break;
      }
    });
    // ダイアログ表示直後にフォーカスを設定する
    $('#offerModal').on('shown.bs.modal', function(event) {
      $(this).find('.modal-footer .btn-default').focus();
    });
    $('#offerModal').on('click', '.modal-footer .btn-primary', function() {
      $('#offerModal').modal('hide');
    });  
    /**
     * 友達スケジュールモーダル表示前処理
     */
    $('#friendOfferModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var friendName = button.data('name');
      var id_data = button.data('id');
      var modal = $(this);
      // 名前
      modal.find('.modal-body .friend_user_name').text(friendName);
      // ユーザーID
      modal.find('.modal-body .user_id').val(id_data);
      
    });
    // ダイアログ表示直後にフォーカスを設定する
    $('#friendOfferModal').on('shown.bs.modal', function(event) {
      $(this).find('.modal-footer .btn-default').focus();
    });
    $('#friendOfferModal').on('click', '.modal-footer .btn-primary', function() {
      $('#friendOfferModal').modal('hide');
    });
    
    /**
     * スケジュールボタン
     */
    // ダイアログ表示前にJavaScriptで操作する
    $('#someModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var modal = $(this);
    });
    // ダイアログ表示直後にフォーカスを設定する
    $('#someModal').on('shown.bs.modal', function(event) {
      $(this).find('.modal-footer .btn-default').focus();
    });
    $('#someModal').on('click', '.modal-footer .btn-primary', function() {
      $('#someModal').modal('hide');
    });        
});  
  
/**
 * テーブル初期化
 * */
function TableInit(){
  var $table = $('table');
  $table.floatThead({
      top:50,
      responsiveContainer: function($table){
          return $table.closest('.table-responsive');
      }
  });
  
  $('.date').datetimepicker({ format : 'YYYY/MM/DD HH:mm',
                              sideBySide: true });
}
