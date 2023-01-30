<?php

// echo gettype($list_product_cat);


//lấy thông tin danh mục sản phẩm theo id
function get_info_cat($cat_id){
	$item = db_fetch_row("SELECT * FROM `tbl_list_product_cat` WHERE `cat_id` = {$cat_id}");
	
	return $item;
}
// function get_info_cat($cat_id){
// 	global $list_product_cat;

// 		if(array_key_exists($cat_id, $list_product_cat)){
// 			$list_product_cat[$cat_id]["url"] = "?mod=product&act=main&cat_id={$cat_id}";
// 			return $list_product_cat[$cat_id];
// 		}else{
// 			return false;
// 		}
// 	}
// };

//lấy danh sách sản phẩm theo cat_id
function get_list_product_by_cat_id($cat_id){
	$result = db_fetch_array("SELECT * FROM `tbl_list_product` WHERE `cat_id` = {$cat_id}");
	return $result;
}

// function get_list_product_by_cat_id($cat_id){
// 	global $list_product;
// 	$result = array();//mảng chứa danh sách sản phẩm theo cat_id

// 		foreach( $list_product as $item){
// 			if($item["cat_id"] == $cat_id){
// 				$item["url"] = "?mod=product&act=detail&id={$item['id']}";
// 				$result[] = $item;
// 			}
// 		}
// 		return $result;
// 	}
// };
//lấy thông tin bài viết (sản phẩm ) theo id
function get_product_by_id($id){
$item = db_fetch_row("SELECT * FROM `tbl_list_product` WHERE `id` = {$id}");
	return $item;
}
// function get_product_by_id($id){
// 	global $list_product;
// 	if(array_key_exists($id, $list_product)){
// 		$list_product[$id]["url_add_cart"] = "?mod=cart&act=add&id={$id}";
// 		$list_product[$id]["url_product"] = "?mod=product&act=detail&id={$id}";
// 		return $list_product[$id];
// 	}
// 	return false;
// }
?>