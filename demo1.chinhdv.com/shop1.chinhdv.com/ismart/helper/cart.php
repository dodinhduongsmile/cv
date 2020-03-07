<?php

function add_cart($id){

	$item = get_product_by_id($id);

# thêm thông tin vào giỏ hàng
	$qty = 1;
if(isset($_SESSION["cart"]) && array_key_exists($id, $_SESSION["cart"]["buy"])){//kiểm tra sản phẩm có id xuất hiện chưa
	$qty = $_SESSION["cart"]["buy"][$id]["qty"] + 1; //tăng thêm 1 ở số lượng sản phẩm

}
$_SESSION["cart"]["buy"][$id] =  array(
	"id" => $item["id"],
	// "url_product" => $item["url_product"],
	"product_thumb" => $item["product_thumb"],
	"product_title" => $item["product_title"],
	"price" => $item["price"],
	"code" => $item["product_title"],
	"url" => $item["product_slug"],
	"qty" => $qty,
	"sub_total" => $item["price"] * $qty
);
#update thông tin hóa đơn
update_info_cart();
}

//update thông tin tổng đơn hàng
function update_info_cart(){
	#lưu thông tin tổng đơn hàng , duyệt mảng $_SESSION["cart"]["buy"] và tính tổng qty và sub_total
	if(isset($_SESSION["cart"])){
		$num_order = 0;
		$total = 0;
		foreach($_SESSION["cart"]["buy"] as $item){
			$num_order += $item["qty"];
			$total += $item["sub_total"];
		}
		//thông tin hóa đơn
		$_SESSION["cart"]["info"] = array(
			"num_order" => $num_order,
			"total" => $total
		);
	}
}

//lấy danh sách sản phẩm đã mua
function get_list_buy_cart(){
	if(isset($_SESSION["cart"])){//vì session là biến toàn cục global nên không cần khai báo lại trong hàm nữa
		//thêm trường mới vào mảng => duyệt mảng và thêm vào
		foreach($_SESSION["cart"]["buy"] as &$item){
			$item["url_delete_cart"] = "?mod=cart&controller=index&action=delete&id={$item['id']}"; 
		}

		return $_SESSION["cart"]["buy"];
	}else{
		return false;
	}
}

//lấy tổng số sản phẩm trong giỏ hàng
function get_num_order_cart(){
	if(isset($_SESSION["cart"])){
		return $_SESSION["cart"]["info"]["num_order"];
	}else{
		return false;
	}
}

//lấy tổng tiền trong giỏ hàng
function get_total_cart(){
	if(isset($_SESSION["cart"])){
		return $_SESSION["cart"]["info"]["total"];
	}else{
		return false;
	}
}
//xóa sản phẩm
function delete_cart($id = ""){
	if(isset($_SESSION["cart"])){
		#xóa sản phẩm có $id trong giỏ hàng,  unset session
		if(!empty($id)){
			unset($_SESSION["cart"]["buy"][$id]);
			update_info_cart();//xóa xong cập nhật lại giỏ hàng
		}else{
		#không có $id thì xóa tất cảs
		unset($_SESSION["cart"]);
		}
	}
	
}

//
function update_cart($qty){
	foreach($qty as $id => $new_qty){// duyệt mảng qty => trả về từng cặp key = $id sản phẩm value = $new_qty số lượng sản phẩm
		$_SESSION["cart"]["buy"][$id]["qty"] = $new_qty;
		$_SESSION["cart"]["buy"][$id]["sub_total"] = $new_qty * $_SESSION["cart"]["buy"][$id]["price"];
	}
	update_info_cart();
}
?>