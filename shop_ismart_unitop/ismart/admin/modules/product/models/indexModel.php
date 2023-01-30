<?php
//lấy danh sách item theo table
function get_list_item($table){
	$item = db_fetch_array("SELECT * FROM `{$table}`");
	return $item;
}
// lấy danh sách item theo số lượng quy định trong 1 bảng
function list_item($table, $start, $num_per_page){

	$list_item = db_fetch_array("SELECT * FROM `{$table}` ORDER BY `cat_order`  LIMIT {$start}, {$num_per_page}");
	return $list_item;
}
// lấy danh sách item theo số lượng quy định trong 1 bảng
function list_item_status($table, $start, $num_per_page, $where=""){
	if(!empty($where)){
		$where = "WHERE {$where}";
	}
	$list_item = db_fetch_array("SELECT * FROM `{$table}` {$where}  LIMIT {$start}, {$num_per_page}");
	return $list_item;
}
//danh sách sản phẩm có thông tin của cả tbl_product và tbl_product_cat
function list_product_join($start, $num_per_page){
	$list_item = db_fetch_array("SELECT `tbl_product`.*, `tbl_product_cat`.`cat_title` FROM `tbl_product` LEFT JOIN `tbl_product_cat` ON `tbl_product`.`cat_id` = `tbl_product_cat`.`cat_id` LIMIT {$start}, {$num_per_page}");
	return $list_item;
}
//lấy nội dung item trong table theo id
function get_item_by_id($table,$id){
	$item = db_fetch_row("SELECT * FROM `{$table}` WHERE `id` = {$id}");
	return $item;
}
//lấy nội dung item trong table theo cat_id (trường hợp danh mục thì mới dùng cái cat_id)
function get_item_by_catid($table,$cat_id){
	$item = db_fetch_row("SELECT * FROM `{$table}` WHERE `cat_id` = {$cat_id}");
	
	return $item;
}
//lấy tổng số các item theo table
function num_rows($table){
	$num_rows = db_num_rows("SELECT * FROM `{$table}`");
	return $num_rows;
}
//5.lấy tổng số các item theo status
function num_rows_by_status($status){
	$num_rows = db_num_rows("SELECT * FROM `tbl_product` WHERE `product_status` = {$status}");
	return $num_rows;
}
// thêm item vào databáe
function add_item($table, $data){
	db_insert($table,$data);
}
//update ITEM theo id
function update_info_by_id($table, $data, $id){
	db_update($table, $data, "`id`={$id}");
}
//update ITEM theo cat_id
function update_info_by_catid($table, $data, $cat_id){
	db_update($table, $data, "`cat_id`={$cat_id}");
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
// xóa item theo cat_id khỏi database
function delete_item_by_catid($table,$cat_id){
	db_delete($table, "`cat_id` = '{$cat_id}'");
}
//6. Kiểm tra tồn tại url chưa
function exists_url($product_slug){
	$check = db_num_rows("SELECT * FROM `tbl_product` WHERE `product_slug` = '{$product_slug}'");
    if ($check > 0)
        return true;
    return false;
}
//6. Kiểm tra tồn tại url chưa
function exists_url1($product_slug){
	$check = db_num_rows("SELECT * FROM `tbl_product` WHERE `product_slug` = '{$product_slug}'");
    if ($check > 1)
        return true;
    return false;
}
//6. Kiểm tra tồn tại url ở tbl_product_cat chưa
function exists_slug($url_slug){
	$check = db_num_rows("SELECT * FROM `tbl_product_cat` WHERE `url` = '{$url_slug}'");
    if ($check > 0)
        return true;
    return false;
}
//6. Kiểm tra tồn tại url ở tbl_product_cat chưa (dùng cho editAction vì nó tồn tại 1 lần rồi nên phải >1)
function exists_slug1($url_slug){
	$check = db_num_rows("SELECT * FROM `tbl_product_cat` WHERE `url` = '{$url_slug}'");
    if ($check > 1)
        return true;
    return false;
}
//11. Hàm thay đổi giá trị status khi thực hiện xoá
function change_status($data, $id) {
    return db_update('tbl_product', $data, "`id` = {$id}");
}
//level của danh mục
function get_level_by($parent_Cat){
	$list_product_cat = get_list_item('tbl_product_cat');
	$level = 0;
	foreach($list_product_cat as $item){
        if($item['cat_id'] == $parent_Cat){
            $level = $item['level'] + 1;
        }
    }
    return $level;
}
?>
