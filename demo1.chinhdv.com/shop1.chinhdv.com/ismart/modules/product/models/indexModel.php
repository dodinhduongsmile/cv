<?php
//lấy danh sách item theo table
function get_list_item($table){
	$item = db_fetch_array("SELECT * FROM `{$table}`");
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

//lấy thông tin bài viết (sản phẩm ) theo id
function get_item_by_id($table,$id){
$item = db_fetch_row("SELECT * FROM `{$table}` WHERE `id` = {$id}");
	return $item;
}

//tổng số bản ghi theo cat_id
function num_rows($table,$cat_id){
	$num_rows = db_num_rows("SELECT * FROM `{$table}` WHERE `cat_id`={$cat_id}");
	return $num_rows;
}
//Đếm số sản phẩm là cháu
function num_row_by_cat_parent($cat_id) {
    return db_num_rows("SELECT `tbl_product`.*, `tbl_product_cat`.`cat_title`, `tbl_product_cat`.`cat_parent` FROM `tbl_product` LEFT JOIN `tbl_product_cat` ON `tbl_product`.`cat_id` = `tbl_product_cat`.`cat_id` WHERE `cat_parent` = {$cat_id}");
}

// lấy danh sách sản phẩm theo cat_id số lượng quy định
function list_product($cat_id, $start, $num_per_page){
	$list_product = db_fetch_array("SELECT * FROM `tbl_product` WHERE `cat_id`={$cat_id} LIMIT {$start}, {$num_per_page}");
	return $list_product;
}
//1.Lấy danh sách sản phẩm là con cấp 1(cat_parent =1) của danh mục chính(cat_parent=0)
function list_product_by_cat_parent($cat_id, $start, $num_per_page) {
    $list_product = db_fetch_array("SELECT `tbl_product`.*, `tbl_product_cat`.`cat_title`, `tbl_product_cat`.`cat_parent` FROM `tbl_product` LEFT JOIN `tbl_product_cat` ON `tbl_product`.`cat_id` = `tbl_product_cat`.`cat_id` WHERE `cat_parent` = {$cat_id} LIMIT {$start}, {$num_per_page}");
    return $list_product;
}
// lấy danh sách sản phẩm theo cat_id , tăng dần
function list_product_sort($cat_id, $cot){
	$list_product = db_fetch_array("SELECT * FROM `tbl_product` WHERE `cat_id`={$cat_id} ORDER BY `{$cot}`");
	return $list_product;
}
// lấy danh sách sản phẩm theo cat_id , giảm dần
function list_product_rsort($cat_id, $cot){
	$list_product = db_fetch_array("SELECT * FROM `tbl_product` WHERE `cat_id`={$cat_id}  ORDER BY `{$cot}` DESC");
	return $list_product;
}
//4.Hàm kiểm tra thông tin search 
function check_search($search) {
    $sql = "SELECT * FROM `tbl_product` WHERE `product_title` LIKE '%{$search}%' OR `product_des` LIKE '%{$search}%' OR `price` LIKE '%{$search}%' OR `old_price` LIKE '%{$search}%'";
    $check = db_num_rows($sql);
    if ($check > 0)
        return true;
    return false;
}

//5. Hàm tìm kiếm thông tin theo username, display_name, email
function get_result_search($search) {
   $sql = "SELECT * FROM `tbl_product` WHERE `product_title` LIKE '%{$search}%' OR `product_des` LIKE '%{$search}%' OR `price` LIKE '%{$search}%' OR `old_price` LIKE '%{$search}%'";
    $result = db_fetch_array($sql);
    return $result;
}

//Lọc sản phẩm theo giá tiền
//a.----- Lọc sản phẩm với giá tiền nhỏ hơn $price
function get_product_filter_price_round($price) {
    return db_fetch_array("SELECT * FROM `tbl_product` WHERE `price` < '{$price}'");
}
//b.----- Lọc sản phẩm trong khoảng giá $price_1, $price_2
function get_product_filter_price($price_1, $price_2) {
    return db_fetch_array("SELECT * FROM `tbl_product` WHERE `price` BETWEEN {$price_1} AND {$price_2}");
}
//a.----- Lọc sản phẩm với giá tiền > hơn $price
function get_product_filter_price_ceil($price) {
    return db_fetch_array("SELECT * FROM `tbl_product` WHERE `price` > '{$price}'");
}
?>
