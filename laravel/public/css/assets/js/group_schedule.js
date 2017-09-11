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
});  
  