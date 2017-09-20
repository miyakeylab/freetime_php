/**
 * group_schedule 処理
 */
$(function () {
   
      // JavaScript で表示
    $('#groupfriendModal').on('click', function() {
      $('#groupfriendAddModal').modal();
    });  
    
    /**
     * グループリクエスト用モーダル
     */ 
    $('#groupfriendAddModal').on('show.bs.modal', function(event) {

    });
    // ダイアログ表示直後にフォーカスを設定する
    $('#groupfriendAddModal').on('shown.bs.modal', function(event) {
      $(this).find('.modal-footer .btn-default').focus();
    });
    $('#groupfriendAddModal').on('click', '.modal-footer .btn-primary', function() {
      $('#groupfriendAddModal').modal('hide');
    });
    
    // ダイアログ表示前にJavaScriptで操作する
    $('#staticModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var hour_start = button.data('start');
      var hour_end = button.data('end');
      var title = button.data('title');
      var content = button.data('content');
      console.log(hour_start);
      var modal = $(this);
      modal.find('#schedule-start').val(hour_start);
      modal.find('#schedule-end').val(hour_end);
      modal.find('#schedule-title').val(title);  
      modal.find('#schedule-content').val(content); 
    });
    // ダイアログ表示直後にフォーカスを設定する
    $('#staticModal').on('shown.bs.modal', function(event) {
      $(this).find('.modal-footer .btn-default').focus();
    });
    $('#staticModal').on('click', '.modal-footer .btn-primary', function() {
      $('#staticModal').modal('hide');
    });    
});  
  