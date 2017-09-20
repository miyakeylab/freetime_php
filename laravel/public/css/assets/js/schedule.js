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
      console.log(category);
      var modal = $(this);
      modal.find('#schedule-start').val(hour_start);
      modal.find('#schedule-end').val(hour_end);
      modal.find('#schedule-title').val(title);  
      modal.find('#schedule-content').val(content);
      
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
