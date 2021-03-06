/**
 * friend 処理
 */
$(function () {
    // テーブル処理
    $(document).ready(TableInit);
    
    /**
     * 友達リクエスト用モーダル
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
      //modal.find('.modal-body input').val(recipient);
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

}