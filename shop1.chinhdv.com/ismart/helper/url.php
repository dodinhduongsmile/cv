<?php

function base_url($url = "") {
    global $config;
    return $config['base_url'].$url;
}
//chuyển hướng
function redirect($url = "?"){ //gán giá trị mặc định cho $url luôn - trường hợp gọi hàm không điền tham số nó sẽ tự chạy tới trang home
	ob_start();//khai báo khi dùng hàm header
	if(!empty($url)){
		header("location:$url");
	}else{
		return false;
	}
}


?>