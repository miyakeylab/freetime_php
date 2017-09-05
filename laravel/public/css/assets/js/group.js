/**
 * group 処理
 */
$(function () {
    // 初期化処理
    $(document).ready(Init);
    
      // JavaScript で表示
    $('#groupModalButton').on('click', function() {
      $('#groupModal').modal();
    });  
    
    /**
     * グループリクエスト用モーダル
     */ 
    $('#groupModal').on('show.bs.modal', function(event) {

    });
    // ダイアログ表示直後にフォーカスを設定する
    $('#groupModal').on('shown.bs.modal', function(event) {
      $(this).find('.modal-footer .btn-default').focus();
    });
    $('#groupModal').on('click', '.modal-footer .btn-primary', function() {
      $('#groupModal').modal('hide');
    });   
});  
  
/**
 * 初期化
 * */
function Init(){

}