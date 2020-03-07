<?php
//lấy danh sách item theo table
function get_list_item($table){
	$item = db_fetch_array("SELECT * FROM `{$table}`");
	return $item;
}
//lấy danh sách slide đã kích hoạt
function get_list_slide($table){
	$item = db_fetch_array("SELECT * FROM `{$table}` WHERE `slide_status` = 1");
	return $item;
}
//lấy thông tin -danh mục sản phẩm theo id
function get_info_cat($table,$cat_id){
	$item = db_fetch_row("SELECT * FROM `{$table}` WHERE `cat_id` = {$cat_id}");
	return $item;
}

//lấy danh sách sản phẩm theo cat_id
function list_item_by_cat_id($table, $cat_id){
	$result = db_fetch_array("SELECT * FROM `{$table}` WHERE `cat_id` = {$cat_id}");
	return $result;
}

//lấy danh sách sản phẩm theo id
function list_item_by_id($table, $id){
	$result = db_fetch_array("SELECT * FROM `{$table}` WHERE `id` = {$id}");
	return $result;
}

//lấy thông tin bài viết (sản phẩm ) theo id
function get_item_by_id($table,$id){
$item = db_fetch_row("SELECT * FROM `{$table}` WHERE `id` = {$id}");
	return $item;
}

function list_cat_by_level($level){
	$result = db_fetch_array("SELECT * FROM `tbl_product_cat` WHERE `level` = {$level} AND `showhome` = 1");
	return $result;
}
//1.Lấy danh sách sản phẩm là con cấp 1(cat_parent =1) của danh mục chính(cat_parent=0)
function list_product_by_cat_parent($cat_id) {
    $list_product = db_fetch_array("SELECT `tbl_product`.*, `tbl_product_cat`.`cat_title`, `tbl_product_cat`.`cat_parent` FROM `tbl_product` LEFT JOIN `tbl_product_cat` ON `tbl_product`.`cat_id` = `tbl_product_cat`.`cat_id` WHERE `cat_parent` = {$cat_id}");
    return $list_product;
}
?>