<?php
function show_gender($gender){
	$list_gender = array(
		"made" => "nam",
		"femade" => "nữ"
	);
	if(array_key_exists($gender, $list_gender)){
		return $list_gender[$gender];
	}
};

//hiển thị (lấy) danh sách sản phẩm theo số lượng quy định
// function get_user($start = 1, $num_per_page = 10, $where = ""){
// 	if(!empty($where)){
// 		$where = "WHERE {$where}";
// 	}
// 	$result = db_fetch_array("SELECT * FROM `tbl_list_product` {$where} LIMIT {$start}, {$num_per_page}");
// 	return $result;
// }

//thông tin user khi đã login
function info_user($label = '$id'){
	if(isset($_SESSION["is_login"])){
		$user_login = $_SESSION['user_login'];
		$user = db_fetch_row("SELECT * FROM `tbl_user` WHERE `username`='{$user_login}'");
		return $user[$label];
	}else{
		return false;
	}
};

//kiểm tra login chưa
function is_login(){
	if(isset($_SESSION["is_login"])){
		return true;
	}else{
		return false;
	}
}
?>