<?php
//1.lấy danh sách item theo table
function get_list_item($table){
	$item = db_fetch_array("SELECT * FROM `{$table}`");
	return $item;
}
//2. lấy danh sách item theo số lượng quy định trong 1 bảng
function list_item($table, $start, $num_per_page, $where = ""){
	if (!empty($where)) {
        $where = "WHERE {$where}";
    }
	$list_item = db_fetch_array("SELECT * FROM `{$table}` {$where}  LIMIT {$start}, {$num_per_page}");
	return $list_item;
}
//3.lấy nội dung item trong table theo id
function get_item_by_id($table,$id){
	$item = db_fetch_row("SELECT * FROM `{$table}` WHERE `id` = {$id}");
	
	return $item;
}
//3.lấy nội dung item trong table theo id
function get_item_by_cat_id($table,$cat_id){
	$item = db_fetch_row("SELECT * FROM `{$table}` WHERE `cat_id` = {$cat_id}");
	
	return $item;
}
//4.lấy tổng số các item theo table
function num_rows($table){
	$num_rows = db_num_rows("SELECT * FROM `{$table}`");
	return $num_rows;
}

//5.lấy tổng số các item theo status
function num_rows_by_status($status){
	$num_rows = db_num_rows("SELECT * FROM `tbl_post` WHERE `status` = {$status}");
	return $num_rows;
}

//6. Kiểm tra tồn tại url chưa
function exists_url($post_slug){
	$check = db_num_rows("SELECT * FROM `tbl_post` WHERE `post_slug` = '{$post_slug}'");
    if ($check > 1)
        return true;
    return false;
}
//6.1. tổng quát Kiểm tra tồn tại url chưa
function exists_slug($table,$where){
	if (!empty($where)) {
        $where = "WHERE {$where}";
    }
	$check = db_num_rows("SELECT * FROM `{$table}` {$where}");
    if ($check > 1)
        return true;
    return false;
}
//7. thêm item vào databáe
function add_item($table, $data){
	db_insert($table,$data);
}
//8.update ITEM theo id
function update_info_by_id($table, $data, $id){
	db_update($table, $data, "`id`={$id}");
}
//8.1.update ITEM theo id
function update_info_by_cat_id($table, $data, $cat_id){
	db_update($table, $data, "`cat_id`={$cat_id}");
}
//DELETE ITEM
//9.lấy user theo username
function get_user_by_username($username){
	$item = db_fetch_row("SELECT * FROM `tbl_user` WHERE `username` = '{$username}'");
	return $item;
}
// 10.xóa item theo id khỏi database
function delete_item_by_id($table,$id){
	db_delete($table, "`id` = '{$id}'");
}
// 10.1.xóa item theo cat_id khỏi database
function delete_item_by_cat_id($table, $cat_id){
	db_delete($table, "`cat_id` = '{$cat_id}'");
}
//11. Hàm thay đổi giá trị status khi thực hiện xoá
function change_status($data, $id) {
    return db_update('tbl_post', $data, "`id` = {$id}");
}
//
function get_level_by($parent_Cat){
	$list_post_cat = get_list_item('tbl_post_cat');
	$level = 0;
	foreach($list_post_cat as $item){
        if($item['cat_id'] == $parent_Cat){
            $level = $item['level'] + 1;
        }
    }
    return $level;
}
?>
