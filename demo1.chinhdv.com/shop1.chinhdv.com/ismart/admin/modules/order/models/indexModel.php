<?php
//lấy danh sách item theo table
function get_list_item($table){
	$item = db_fetch_array("SELECT * FROM `{$table}`");
	return $item;
}
// lấy danh sách item theo số lượng quy định trong 1 bảng
function list_item_pagging($table, $start, $num_per_page, $where=""){
	if(!empty($where)){
		$where = "WHERE {$where}";
	}
	$list_item = db_fetch_array("SELECT * FROM `{$table}` {$where}  LIMIT {$start}, {$num_per_page}");
	return $list_item;
}
//lấy tổng số các item theo table
function num_rows($table){
	$num_rows = db_num_rows("SELECT * FROM `{$table}`");
	return $num_rows;
}
//5.lấy tổng số các item đơn hàng theo trạng thái
function num_rows_by_status($status){
	$num_rows = db_num_rows("SELECT * FROM `tbl_checkout` WHERE `status` = {$status}");
	return $num_rows;
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
// xóa item theo id khỏi database
function delete_item_by_id($table,$id){
	db_delete($table, "`id` = '{$id}'");
}
//11. Hàm thay đổi giá trị status khi thực hiện xoá
function change_status($data, $id) {
    return db_update('tbl_checkout', $data, "`id` = {$id}");
}

//4.Hàm kiểm tra thông tin search 
function check_search($search) {
    $sql = "SELECT * FROM `tbl_checkout` WHERE `fullname` LIKE '%{$search}%' OR `email` LIKE '%{$search}%' OR `phone` LIKE '%{$search}%' OR `code` LIKE '%{$search}%'";
    $check = db_num_rows($sql);
    if ($check > 0)
        return true;
    return false;
}

//5. Hàm tìm kiếm thông tin theo username, display_name, email
function get_result_search($search) {
    $sql = "SELECT * FROM `tbl_checkout` WHERE `fullname` LIKE '%{$search}%' OR `email` LIKE '%{$search}%' OR `phone` LIKE '%{$search}%' OR `code` LIKE '%{$search}%' ";
    $result = db_fetch_array($sql);
    return $result;
    
}
?>