<?php
//lấy thông tin bài viết (sản phẩm ) theo id
function get_product_by_id($id){
$item = db_fetch_row("SELECT * FROM `tbl_product` WHERE `id` = {$id}");
	return $item;
}
//3. Lấy ra thông tin đơn hàng theo code
function get_order_by_code($code) {
    return db_fetch_row("SELECT * FROM `tbl_checkout` WHERE `code` = '{$code}'");
}
?>
