<?php
//1.lấy danh sách users
function get_list_users($where = ""){
	if (!empty($where)) {
        $where = "WHERE {$where}";
    }
    $result = db_fetch_array("SELECT * FROM `tbl_user` {$where}");
	return $result;
}

//2.lấy tổng số các user
function num_rows($table){
	$num_rows = db_num_rows("SELECT * FROM `{$table}`");
	return $num_rows;
}
//3.lấy tổng số các user theo quyền
function num_rows_by_role($role){
	$num_rows = db_num_rows("SELECT * FROM `tbl_user` WHERE `role` = {$role}");
	return $num_rows;
}
// 4.lấy danh sách user theo số lượng quy định, để phân trang
function list_item($table, $start, $num_per_page, $where = ""){
	if (!empty($where)) {
        $where = "WHERE {$where}";
    }
	$list_item = db_fetch_array("SELECT * FROM `{$table}` {$where}  LIMIT {$start}, {$num_per_page}");
	return $list_item;
}

//5.lấy user theo username
function get_user_by_username($username){
	$item = db_fetch_row("SELECT * FROM `tbl_user` WHERE `username` = '{$username}'");
	return $item;
}
//6.lấy user theo user_id
function get_user_by_id($user_id){
	$item = db_fetch_row("SELECT * FROM `tbl_user` WHERE `user_id` = '{$user_id}'");
	return $item;
}
//7.thêm user vào database
function add_user($data){
	return db_insert('tbl_user',$data);
}

//8.xóa user khỏi database
function delete_user($user_id){
	db_delete("tbl_user", "`user_id` = '{$user_id}'");
}
//9.kiểm tra xem username và email tồn tại trên database chưa
function user_exists($username, $email){
	$check_user = db_num_rows("SELECT * FROM `tbl_user` WHERE `email` = '{$email}' OR `username` = '{$username}'");
	if($check_user > 0){
		return true;
	}else{
		return false;
	}
}


//10.kiểm tra đăng nhập

function check_login($username, $password){
	$check_user = db_num_rows("SELECT * FROM `tbl_user` WHERE `username` = '{$username}' AND `password` = '{$password}'");
	if($check_user > 0){
		return true;
	}else{
		return false;
	}
}

//thông tin info_user() để ở gọi chung cho cả web. xuất hiện khi có session["is_login"]

//==
//11.RESET LẤY LẠI PASS WORD
//==
//11.1 kiểm tra xem email tồn tại không?
function email_exists($email){
	$check_email = db_num_rows("SELECT * FROM `tbl_user` WHERE `email` = '{$email}'");

	if($check_email > 0){
		return true;
	}else{
		return false;
	}
}


//11.2 update lại password
function update_pass($data, $pass_old){
	db_update("tbl_user", $data, "`password`='{$pass_old}'");
}
//12. update thông tin theo user_id
function update_info($data, $user_id){
	db_update("tbl_user", $data, "`user_id`={$user_id}");
}
//==
//13. thay đổi mật khẩu, check pass_old đúng thì cho update lại pass
//==
function check_pass_old($pass_old){
	$check = db_num_rows("SELECT * FROM `tbl_user` WHERE `password` = '{$pass_old}'");
	if($check > 0){
		return true;
	}else{
		return false;
	}
}
?>