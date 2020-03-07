<?php
function construct() {
//    echo "DÙng chung, load đầu tiên";
  load_model('index');
  load('helper','validate');

}

function indexAction() {

//1.phân trang
// global $num_page, $page, $cat_id;// k cần global các thông số này ra bên ngoài, vì bên ngoài không có chỗ nào cần dùng tới Biến $num_page.., mà chỗ hàm get_pagging đó chỉ là tham số thôi.
//load thư viện
load('helper', 'pagging');
//số lượng bản ghi trên mỗi trang
$num_per_page = 8;
//tổng số bản ghi
$total_row = num_rows('tbl_user');//tổng số bản ghi tbl_user 
//=>tổng số trang
$num_page = ceil($total_row / $num_per_page);

//chỉ số trang hiện tại
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 

//chỉ số bản ghi bắt đầu mỗi trang
$start = ($page - 1) * $num_per_page;

$list_user = list_item('tbl_user', $start, $num_per_page);
$get_pagging = get_pagging($num_page, $page, "?mod=user&controller=team");

//load view, truyền data sang view
   $data["get_pagging"] = $get_pagging;
	$data['list_user'] =$list_user;
//END PHÂN TRANG

	load_view('teamIndex',$data);
}

function role1Action(){

//1.phân trang
// global $num_page, $page, $cat_id;// k cần global các thông số này ra bên ngoài, vì bên ngoài không có chỗ nào cần dùng tới Biến $num_page.., mà chỗ hàm get_pagging đó chỉ là tham số thôi.
//load thư viện
load('helper', 'pagging');
//số lượng bản ghi trên mỗi trang
$num_per_page = 8;
//tổng số bản ghi
$total_row = num_rows_by_role(1);//tổng số bản ghi tbl_user có role = 1
//=>tổng số trang
$num_page = ceil($total_row / $num_per_page);

//chỉ số trang hiện tại
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 

//chỉ số bản ghi bắt đầu mỗi trang
$start = ($page - 1) * $num_per_page;

$list_user_admin = list_item('tbl_user', $start, $num_per_page, "`role` = 1");
$get_pagging = get_pagging($num_page, $page, "?mod=user&controller=team&action=role1");

//load view, truyền data sang view
   $data["get_pagging"] = $get_pagging;
  $data['list_user_admin'] =$list_user_admin;
//END PHÂN TRANG

  load_view('teamRole1',$data);
}
function role2Action(){

//1.phân trang
//load thư viện
load('helper', 'pagging');
$num_per_page = 8;
$total_row = num_rows_by_role(2);//tổng số bản ghi tbl_user có role = 1
$num_page = ceil($total_row / $num_per_page);
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 
$start = ($page - 1) * $num_per_page;
$list_user_role = list_item('tbl_user', $start, $num_per_page, "`role` = 2");
$get_pagging = get_pagging($num_page, $page, "?mod=user&controller=team&action=role2");

//load view, truyền data sang view
   $data["get_pagging"] = $get_pagging;
  $data['list_user_role'] =$list_user_role;
//END PHÂN TRANG

  load_view('teamRole2',$data);
}
function role3Action(){

//1.phân trang
//load thư viện
load('helper', 'pagging');
$num_per_page = 8;
$total_row = num_rows_by_role(3);//tổng số bản ghi tbl_user có role = 1
$num_page = ceil($total_row / $num_per_page);
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 
$start = ($page - 1) * $num_per_page;
$list_user_role = list_item('tbl_user', $start, $num_per_page, "`role` = 3");
$get_pagging = get_pagging($num_page, $page, "?mod=user&controller=team&action=role3");

//load view, truyền data sang view
   $data["get_pagging"] = $get_pagging;
  $data['list_user_role'] =$list_user_role;
//END PHÂN TRANG

  load_view('teamRole3',$data);
}
function addAction(){
	global $error,$success, $pass_old,$pass_new, $cofirm_pass;
  

  if(isset($_POST['btn_add'])){
    $success = array();
    $error = array();
    //validation
  #username
  if(empty($_POST["username"])){
    $error["username"] = "không được để trống username";//hạ cờ
  }else{
    if(!is_username($_POST["username"])){
      $error['username'] = "username không đúng định dạng";
    }else{
      $username = $_POST["username"];
    }
  }
  #email
  	if(empty($_POST["email"])){
    $error["email"] = "không được để trống email";//hạ cờ
  }else{
    if(!is_email($_POST["email"])){
      $error['email'] = "email không đúng định dạng";
    }else{
      $email = $_POST["email"];
    }
  }
  #cấp
  	$role = $_POST['role'];
  #password
    if(empty($_POST['password'])){
      $error['password'] = "không được để trống password";
    }else{
      if(!is_password($_POST['password'])){
        $error["password"] = "password không đúng định dạng";
      }else{
        $password = md5($_POST['password']);
      }
    }


    if(empty($error)){
      //xử lý không có lỗi
      if(!user_exists($username, $email)){
      	$created_date = date('d-m-Y', time());
      $who_create = $_SESSION['user_login'];
        //INSERT USER
        $dataa = array(
        	'username' => $username,
        	'email' => $email,
        	'role' => $role,
          	'password' => $password,
          	'created_date' => $created_date,
          	'who_create' => $who_create
        );
        add_user($dataa);
        $success['ok'] = "đã thêm {$username} thành công";
    }else{
      $error["account"] = "email hoặc username đã tồn tại trên hệ thống";
    }
  }
}
  
load_view("add");
}




?>