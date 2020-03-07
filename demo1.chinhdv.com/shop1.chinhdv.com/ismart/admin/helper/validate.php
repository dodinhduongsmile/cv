<?php
// is_username() hàm kiểm tra xem username có đúng định dạng k, đúng trả về true, không đúng trả về false
function is_username($username){
	$pattern = "/^[A-Za-z0-9_\.]{5,32}$/";
	if(!preg_match($pattern, $username, $matchs)){
		return false;
	}
	return true;
}

// is_password() hàm kiểm tra xem password có đúng định dạng k
function is_password($password){
	// $pattern = "/^([A-Z]){1}([\w_\.!@#$%^&*()]+){5,31}$/";
	$pattern = "/^[A-Za-z0-9_\.!@#$%^&*()]{6,32}$/";//mật khẩu dài 6-32 ký tự, hỗ trợ all chữ số và kt đặc biệt
	if(!preg_match($pattern, $password, $matchs)){
		return false;
	}
	return true;
}

// is_email
function is_email($email){
$partern = "/^[A-Za-z0-9_.]{6,32}@([a-zA-Z0-9]{2,12})(.[a-zA-Z]{2,12})+$/";
		if(preg_match($partern, $email,$matchs)){
			return true;
		}
}

// is_phone_number
function is_phone_number($is_phone_number){
	// $partern = "/^(09|08|01[2|6|8|9])+([0-9]{8})$/"; //09 -10 số, 01 -11 số
	$partern = "/^((09|03)[2|6|7|4|8|9])+([0-9]{7})$/"; //10 số
		if(preg_match($partern, $is_phone_number,$matchs)){
			return true;
		}
}
//form_error
function form_error($label){
	global $error; //global biến $error bên ngoài hàm này
	if(!empty($error[$label])){echo "<p class='error'>{$error[$label]}</p>";}
}
//form_error
function form_success($label){
	global $success; //global biến $error bên ngoài hàm này
	if(!empty($success[$label])){echo "<p class='success'>{$success[$label]}</p>";}
}
//set_value
function set_value($label){ //cái $label chỉ là 1 trường "fullname" chứ chưa phải biến, nên thêm $ mới thành biến. vì nó dùng luôn biến label nên mới phải thêm $$label
	global $$label;
	if(!empty($$label)){return $$label;}
}
function set_cookie($label){ 
	if(!empty($_COOKIE[$label])){return $_COOKIE[$label];}
}
?>