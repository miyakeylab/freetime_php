/**
 * schedule 処理
 */
$(function () {
    // テーブル処理
    $(document).ready(TableInit);
      $('#td-1').on('click', function() {
      $('#staticModal').modal();
    });  
    // JavaScript で表示
    $('#staticModalButton').on('click', function() {
      $('#staticModal').modal();
    });
    // ダイアログ表示前にJavaScriptで操作する
    $('#staticModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var recipient = button.data('whatever');
      var modal = $(this);
      modal.find('.modal-body .recipient').text(recipient);
      //modal.find('.modal-body input').val(recipient);
    });
    // ダイアログ表示直後にフォーカスを設定する
    $('#staticModal').on('shown.bs.modal', function(event) {
      $(this).find('.modal-footer .btn-default').focus();
    });
    $('#staticModal').on('click', '.modal-footer .btn-primary', function() {
      $('#staticModal').modal('hide');
      
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
}
