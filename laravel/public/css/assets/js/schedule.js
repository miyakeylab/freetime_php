/**
 * schedule 処理
 */
$(function () {
    // テーブル処理
    $(document).ready(TableInit);

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
