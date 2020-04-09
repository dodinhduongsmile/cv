<?php

function construct() {
  load_model('index');
  load('helper','validate');

}
function indexAction() {
//xử lý action=index
  redirect("?mod=user&action=update");
}


function loginAction() {
  //LOGIN

global $error, $username, $password;//global để làm việc với validate
    // echo "xử lý login";
if(isset($_POST["btn_login"])){
  //phất cờ
  $error = array();
#chuẩn hóa username
  if(empty($_POST["username"])){
    $error["username"] = "không được để trống username";//hạ cờ
  }else{
    if(!is_username($_POST["username"])){
      $error['username'] = "username không đúng định dạng";
    }else{
      $username = $_POST["username"];
    }
    
  }
#chuẩn hóa password
  if(empty($_POST["password"])){
    // hạ cờ
    $error["password"] = "không được để trống password";
  }else{
    if(!is_password($_POST["password"])){
      $error['password'] = "password không đúng định dạng";
    }else{
      $password = md5($_POST["password"]);
      // echo $password;
    }
  } 

  #kết luận
  if(empty($error)){
    //xử lý không có lỗi

      if(check_login($username, $password)){
        //1. lấy thông tin user
        $info_user = get_user_by_username($username);
        //2. lưu phiên đăng nhập
        $_SESSION['is_login']=true;
        $_SESSION["user_login"] = $info_user['username'];
        $_SESSION["role"] = $info_user['role'];
        echo $_SESSION["user_login"];
        //3. Lưu cookie Ghi nhớ mật khẩu 
          if (isset($_POST['remember_me'])) {
              setcookie('is_login', true, time() + 3600);
              setcookie('user_login', $info_user['username'], time() + 3600);
          }else{
              setcookie('is_login', true, time() - 3600);
              setcookie('user_login', $info_user['username'], time() - 3600);
          }
          //echo "Đăng nhập thành công";
        //4.chuyển hướng vào trong hệ thống khi đã đăng nhập
        redirect();
      }else{
        $error["account"] = "tên đăng nhập hoặc mật khẩu không đúng";
      }
}
}
load_view('login');
}

function logoutAction(){
  //ĐĂNG XUẤT TÀI KHOẢN
  unset($_SESSION["is_login"]);
  unset($_SESSION["user_login"]);

  redirect("?mod=user&action=login");
  //khi chưa login mà người dùng cố tình vào trang khác thì sẽ tự chuyển hướng vào login. viết ở router
}

function resetAction(){
  global $error, $pass_old,$pass_new, $cofirm_pass,$success;
  
  if(isset($_POST['btn_submit'])){
    $success = array();
    $error = array();
    //validation
  #pass_old
    if(empty($_POST['pass_old'])){
      $error['pass_old'] = "không được để trống pass cũ";
    }else{
      if(!is_password($_POST['pass_old'])){
        $error["pass_old"] = "password không đúng định dạng";
      }else{
        $pass_old = md5($_POST['pass_old']);
      }
    }
  #pass_new
    if(empty($_POST['pass_new'])){
      $error['pass_new'] = "không được để trống pass mới";
    }else{
      if(!is_password($_POST['pass_new'])){
        $error["pass_new"] = "pass_new không đúng định dạng";
      }else{
        $pass_new = md5($_POST['pass_new']);
      }
    }
  #cofirm_pass
    if(empty($_POST['confirm_pass'])){
      $error['confirm_pass'] = "không được để trống pass mới";
    }else{
      if(!is_password($_POST['confirm_pass'])){
        $error["confirm_pass"] = "confirm_pass không đúng định dạng";
      }else{
        $confirm_pass = md5($_POST['confirm_pass']);
      }
    }
  #so sánh 2 pass mới
    if($pass_new !== $confirm_pass){
      $error["other"] = "2 mật khẩu cần giống nhau";
    }

    if(empty($error)){
      //xử lý không có lỗi
      if(check_pass_old($pass_old)){
        //xử lý nếu mật khẩu cũ đúng
        //update pass mới
        $dataa = array(
          'password' => $pass_new
        );
        update_pass($dataa, $pass_old);
        $success['ok'] = "đã thay đổi mật khẩu thành công";
      }else{
        $error['pass_old'] = "mật khẩu cũ không chính xác";
      }
    }
  }
  
load_view('reset',$data);
}


function okAction(){
  load_view("ok");
}

function updateAction(){
  global $email, $tel, $error,$success;

  $user = get_user_by_username($_SESSION['user_login']);

  $user_id = $user['user_id'];

  if(isset($_POST["btn_update"])){
  //phất cờ
      $error = array();
        $success = array();
$fullname = htmlentities($_POST["fullname"]);//htmlentities hàm chuyển đổi các ký tự thành html
$address = htmlentities($_POST["address"]);
#chuẩn hóa email
      if(!is_email($_POST["email"])){
        $error["email"] = "email không đúng định dạng";
      }else{
        $email = $_POST["email"];
      } 
#chuẩn hóa phone
      if(!is_phone_number($_POST["tel"])){
        $error["tel"] = "tel không đúng định dạng";
      }else{
        $tel = $_POST["tel"];
      } 


      if(empty($error)){
        $dataa = array(
          'fullname' => $fullname,
          'email' => $email,
          'phone_number' => $tel,
          'address' => $address
        );
        update_info($dataa, $user_id);

        $success["ok"] = "Đã cập nhật thành công";
      }
    }
  $data['user'] = $user;
  load_view('update',$data);

}

function editAction(){
  global $email, $tel, $error,$success;
  $user_id = $_GET['id'];
  $user = get_user_by_id($user_id);
  
  $role = $_SESSION['role'];
  $success = array();

if($role == 1 ){
  //xử lý nếu có quyền admin
  if(isset($_POST["btn_update"])){
  //phất cờ
      $error = array();

$fullname = htmlentities($_POST["fullname"]);//htmlentities hàm chuyển đổi các ký tự thành html
$address = htmlentities($_POST["address"]);
#chuẩn hóa email
      if(!is_email($_POST["email"])){
        $error["email"] = "email không đúng định dạng";
      }else{
        $email = $_POST["email"];
      } 
#chuẩn hóa phone
      
        $tel = $_POST["tel"];
     
#cấp
      $role = $_POST['role'];

      if(empty($error)){
        $dataa = array(
          'fullname' => $fullname,
          'email' => $email,
          'phone_number' => $tel,
          'role' => $role,
          'address' => $address
        );
        update_info($dataa, $user_id);

        $success["ok"] = "Đã cập nhật thành công";
      }
    }
  $data['user'] = $user;

  load_view('edit',$data);
}else{
  echo   "Bạn không có quyền xem và sửa. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
}

}

function deleteAction(){
  $user_id = $_GET["id"];
  $role = $_SESSION['role'];

  if($role == 1 ){
    delete_user($user_id);
    echo   "Bạn đã xóa thành công. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
  }else{
    echo   "Bạn đel có quyền xóa. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
  }
}

