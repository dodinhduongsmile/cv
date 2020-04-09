<?php

// lấy danh sách item theo số lượng quy định trong 1 bảng
function list_item($table, $start, $num_per_page){
	$list_item = db_fetch_array("SELECT * FROM `{$table}`  LIMIT {$start}, {$num_per_page}");
	return $list_item;
}
//lấy tổng số các item theo table
function num_rows($table){
	$num_rows = db_num_rows("SELECT * FROM `{$table}`");
	return $num_rows;
}
// thêm item vào databáe
function add_item($table, $data){
	db_insert($table,$data);
}

//lấy nội dung item trong table theo id
function get_item_by_id($table,$id){
	$item = db_fetch_row("SELECT * FROM `{$table}` WHERE `id` = {$id}");
	
	return $item;
}
//update ITEM theo id
function update_info_by_id($table, $data, $id){
	db_update($table, $data, "`id`={$id}");
}
//DELETE ITEM
//lấy user theo username
function get_user_by_username($username){
	$item = db_fetch_row("SELECT * FROM `tbl_user` WHERE `username` = '{$username}'");
	return $item;
}
// xóa item theo id khỏi database
function delete_item_by_id($table,$id){
	db_delete($table, "`id` = '{$id}'");
}
//6. Kiểm tra tồn tại url chưa
function exists_url($page_slug){
	$check = db_num_rows("SELECT * FROM `tbl_page` WHERE `page_slug` = '{$page_slug}'");
    if ($check > 1)
        return true;
    return false;
}
?>
