<?php
//lấy thông tin bài viết (sản phẩm ) theo id
function get_product_by_id($id){
$item = db_fetch_row("SELECT * FROM `tbl_list_product` WHERE `id` = {$id}");
	return $item;
}

?>
