<?php
//lấy nội dung item trong table theo id
function get_item_by_id($table,$id){
	$item = db_fetch_row("SELECT * FROM `{$table}` WHERE `id` = {$id}");
	
	return $item;
}


?>
