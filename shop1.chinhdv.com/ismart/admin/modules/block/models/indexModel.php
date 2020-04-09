<?php

//lấy tổng số các item theo table
function num_rows($table){
	$num_rows = db_num_rows("SELECT * FROM `{$table}`");
	return $num_rows;
}
//lấy danh sách item theo table  VÀ sắp xếp tăng dần mục menu_order
function get_list_item($table){
	$item = db_fetch_array("SELECT * FROM `{$table}` ORDER BY `menu_order` ASC");
	return $item;
}
//lấy danh sách item theo table - điều kiện level = 0, VÀ sắp xếp tăng dần mục menu_order
function get_list_item_level($table, $level){
	$item = db_fetch_array("SELECT * FROM `{$table}` WHERE `level` = '{$level}' ORDER BY `menu_order` ASC");
	return $item;
}
// lấy danh sách item theo số lượng quy định trong 1 bảng
function list_item($table, $start, $num_per_page){
	$list_item = db_fetch_array("SELECT * FROM `{$table}`  LIMIT {$start}, {$num_per_page}");
	return $list_item;
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
//lấy user theo username
function get_user_by_username($username){
	$item = db_fetch_row("SELECT * FROM `tbl_user` WHERE `username` = '{$username}'");
	return $item;
}
// xóa item theo id khỏi database
function delete_item_by_id($table,$id){
	db_delete($table, "`id` = '{$id}'");
}
//level của danh mục
function get_level_by($menu_parent){
	$list_menu_cat = get_list_item('tbl_menu');
	$level = 0;
	foreach($list_menu_cat as $item){
        if($item['id'] == $menu_parent){
            $level = $item['level'] + 1;
        }
    }
    return $level;
}
?>