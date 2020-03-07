<?php
// lấy danh sách item theo số lượng quy định trong 1 bảng
function list_item($table, $start, $num_per_page, $where){
	if(!empty($where)){
		$where = "WHERE {$where}";
	}
	$list_item = db_fetch_array("SELECT * FROM `{$table}` {$where} LIMIT {$start}, {$num_per_page}");
	return $list_item;
}
//lấy tổng số các item theo table
function num_rows($table){
	$num_rows = db_num_rows("SELECT * FROM `{$table}`");
	return $num_rows;
}

//lấy nội dung item trong table theo id
function get_item_by_id($table,$id){
	$item = db_fetch_row("SELECT * FROM `{$table}` WHERE `id` = {$id}");
	
	return $item;
}
?>
