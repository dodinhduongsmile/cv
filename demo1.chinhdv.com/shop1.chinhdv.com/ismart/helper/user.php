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


//thông tin user
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
// lấy liên hệ
function phone($code){
	$item = db_fetch_row("SELECT * FROM `tbl_block` WHERE `code_block` = '{$code}'");
	return $item['content_block'];
}
function block_title($code){
	$item = db_fetch_row("SELECT * FROM `tbl_block` WHERE `code_block` = '{$code}'");
	return $item['name_block'];
}
?>