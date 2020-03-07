<?php

function construct() {
//    echo "DÙng chung, load đầu tiên";
    load_model('index');
    
}
//Upload ảnh
function uploadAction() {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Bước 1: Tạo thư mục lưu file
    $error = array();
    $target_dir = "upload/thumb/";
    $target_file = $target_dir . basename($_FILES['file']['name']);
    // Kiểm tra kiểu file hợp lệ
    $type_file = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    $type_fileAllow = array('png', 'jpg', 'jpeg', 'gif');
    if (!in_array(strtolower($type_file), $type_fileAllow)) {
        $error['file'] = "File bạn vừa chọn hệ thống không hỗ trợ, bạn vui lòng chọn hình ảnh";
    }
    //Kiểm tra kích thước file
    $size_file = $_FILES['file']['size'];
    if ($size_file > 5242880) {
        $error['file'] = "File bạn chọn không được quá 5MB";
    }
//Kiểm tra file đã tồn tại trê hệ thống
    // if (file_exists($target_file)) {
    //     $error['file'] = "File bạn chọn đã tồn tại trên hệ thống";
    // }

    if (empty($error)) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $flag = true;
            echo json_encode(array('status' => 'add_ok','file_path' => $target_file));
        } else {
            echo json_encode(array('status' => 'error move file'));
        }
    } else {
        echo json_encode(array('status' => $error['file']));
    }
}
}
function mainAction() {

	load('helper', 'pagging');
//PHÂN TRANG
//số lượng bản ghi trên mỗi trang
$num_per_page = 8;
//tổng số bản ghi
$total_row = num_rows('tbl_post');//tổng số bản ghi tbl_post 
//=>tổng số trang
$num_page = ceil($total_row / $num_per_page);

//chỉ số trang hiện tại
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 

//chỉ số bản ghi bắt đầu mỗi trang
$start = ($page - 1) * $num_per_page;

$list_post = list_item('tbl_post', $start, $num_per_page);
$get_pagging = get_pagging($num_page, $page, "?mod=post&action=main");

//load view, truyền data sang view
   $data["get_pagging"] = $get_pagging;
//END PHÂN TRANG
$data['list_post'] =$list_post;

load_view('index',$data);
}

function status1Action() {
 //1.PHÂN TRANG
    load('helper', 'pagging');
$num_per_page = 8;
$total_row = num_rows_by_status(1);
$num_page = ceil($total_row / $num_per_page);
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 
$start = ($page - 1) * $num_per_page;

$list_post = list_item('tbl_post', $start, $num_per_page, "`status` = 1");
$get_pagging = get_pagging($num_page, $page, "?mod=post&action=status1");
//END PHÂN TRANG
//load view, truyền data sang view
$data["get_pagging"] = $get_pagging;
$data['list_post'] =$list_post;
load_view('status1',$data);
}
function status2Action() {
 //1.PHÂN TRANG
    load('helper', 'pagging');
$num_per_page = 8;
$total_row = num_rows_by_status(2);
$num_page = ceil($total_row / $num_per_page);
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 
$start = ($page - 1) * $num_per_page;

$list_post = list_item('tbl_post', $start, $num_per_page, "`status` = 2");
$get_pagging = get_pagging($num_page, $page, "?mod=post&action=status2");
//END PHÂN TRANG
//load view, truyền data sang view
$data["get_pagging"] = $get_pagging;
$data['list_post'] =$list_post;
load_view('status2',$data);
}
function status3Action() {
 //1.PHÂN TRANG
    load('helper', 'pagging');
$num_per_page = 8;
$total_row = num_rows_by_status(3);
$num_page = ceil($total_row / $num_per_page);
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 
$start = ($page - 1) * $num_per_page;

$list_post = list_item('tbl_post', $start, $num_per_page, "`status` = 3");
$get_pagging = get_pagging($num_page, $page, "?mod=post&action=status3");
//END PHÂN TRANG
//load view, truyền data sang view
$data["get_pagging"] = $get_pagging;
$data['list_post'] =$list_post;
load_view('status3',$data);
}
function addAction() {
    global $error, $title, $slug, $success,$desc,$content,$thumb;
    load('helper', 'validate');
    
    if(isset($_POST['btn_submit'])){
        $error = array();//phất cờ
        $success = array();
    #1.validation title
        if(empty($_POST['title'])){
            $error['title'] = 'không được để trống title';
        }else{
            $title = htmlentities($_POST['title']);// htmlentities chuyển các ký tự thành html, chống hack
        }
    #2.validation slug
        if(empty($_POST['slug'])){
            $error['slug'] = 'không được để trống slug';
        }else{
            if(exists_url($_POST['slug'])){
                $error['slug'] = "đã tồn tại đường dẫn trên hệ thống";
            }else{
                $slug = htmlentities($_POST['slug']);// htmlentities chuyển các ký tự thành html, chống hack
            }
        }     
    #3.validation desc, content => cho phép trống thì phải sửa ở database là có thể null, nếu không sẽ lỗi nếu 2 cái này trống     
        $desc = htmlentities($_POST['desc']);
        $content = htmlentities($_POST['content']);

    #4.validate url file
            $thumb = $_POST['thumbnail_url'];
    #5.category
        $category = $_POST['parent-Cat'];
    #6. status
        if(empty($_POST['status'])){
            $error['status'] = "không được để trống trạng thái";
        }else{
            $status = $_POST['status'];
        }
    #7. ngày,tác giả
        $created_date = date('d-m-Y',time());
        $author = $_SESSION["user_login"];
    //6.kết luận
        if(empty($error)){
            $data = array(
                'post_title' => $title,
                'post_slug' => $slug,
                'post_des' => $desc,
                'post_content' => $content,
                'post_thumb' => $thumb,
                'cat_id' => $category,
                'created_date' =>$created_date ,
                'author' => $author,
                'status' => $status
            );
            add_item('tbl_post', $data);
            $success['ok'] = "đã thêm thành công";
        }


    }
// XỬ LÝ DANH MỤC BÀI POST
    $list_post_cat = get_list_item('tbl_post_cat');

    $data['list_post_cat'] = $list_post_cat;
    load_view('add',$data);
}

function editAction() {
    global $error, $title, $slug,$success,$desc,$content;
    load('helper', 'validate');
    
   $id = $_GET['id'];
   $post_item =  get_item_by_id('tbl_post',$id);
//VALIDATE
   if(isset($_POST['btn_submit'])){
        $error = array();//phất cờ
        $success = array();
    #1.validation title
        if(empty($_POST['title'])){
            $error['title'] = 'không được để trống title';
        }else{
            $title = htmlentities($_POST['title']);// htmlentities chuyển các ký tự thành html, chống hack
        }
    #2.validation slug
        if(empty($_POST['slug'])){
            $error['slug'] = 'không được để trống slug';
        }else{
            if(exists_url($_POST['slug'])){
                $error['slug'] = "đã tồn tại đường dẫn trên hệ thống";
            }else{
                $slug = htmlentities($_POST['slug']);// htmlentities chuyển các ký tự thành html, chống hack
            }
        }       
    #3.validation desc, content => cho phép trống thì phải sửa ở database là có thể null, nếu không sẽ lỗi nếu 2 cái này trống     
        $desc = htmlentities($_POST['desc']);
        $content = htmlentities($_POST['content']);

    #4.validate url file
        $thumb = $_POST['thumbnail_url'];
    #5.category
        $category = $_POST['parent-Cat'];
    #6. status
        if(empty($_POST['status'])){
            $error['status'] = "không được để trống trạng thái";
        }else{
            $status = $_POST['status'];
        }
    //kết luận
        if(empty($error)){
            $data = array(
                'post_title' => $title,
                'post_slug' => $slug,
                'post_des' => $desc,
                'post_content' => $content,
                'post_thumb' => $thumb,
                'cat_id' => $category,
                'status' => $status
            );
            update_info_by_id('tbl_post',$data, $id);
            $success['ok'] = "đã cập nhật thành công";
        }
    }
// XỬ LÝ DANH MỤC BÀI POST
    $list_post_cat = get_list_item('tbl_post_cat');

//LOAD VIEW
   $data['list_post_cat'] = $list_post_cat;
   $data['post_item'] = $post_item;
   load_view('edit',$data);
}

function deleteAction(){
    $id = $_GET["id"];
   $post_item =  get_item_by_id('tbl_post',$id);
   $thumbnail_url = $post_item['post_thumb'];
   $status = $post_item['status'];
    $role = $_SESSION['role'];
    if($role == 1){
        if($status != 1){
            //Thay đổi status để đưa vào thùng rác
            $data = array('status' => 1);
            change_status($data, $id);
            echo   "Bạn đã xóa thành công. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
        }else{
            delete_item_by_id('tbl_post',$id);
            if(!empty($thumbnail_url)){unlink($thumbnail_url);};
            echo   "Bạn đã xóa thành công. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
        }
        
    }else{
        echo "Bạn đel có quyền xóa. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
    }
}

function postcatAction(){
    load('helper', 'pagging');
//PHÂN TRANG
$num_rows = num_rows('tbl_post_cat');//tổng số bản ghi tbl_post 
$num_per_page = 8;
$total_row = $num_rows;
$num_page = ceil($total_row / $num_per_page);
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 
$start = ($page - 1) * $num_per_page;

$list_post_cat = list_item('tbl_post_cat', $start, $num_per_page);
$get_pagging = get_pagging($num_page, $page, "?mod=post&action=postcat");

//load view, truyền data sang view
   $data["get_pagging"] = $get_pagging;
//END PHÂN TRANG
$data['list_post_cat'] =$list_post_cat;
$data['get_pagging'] = $get_pagging;
    load_view('postcat',$data);
}

function addcatAction(){
    global $error, $title, $slug,$success;
    load('helper', 'validate');
 //VALIDATE
    if(isset($_POST['btn_submit'])){
        $error = array();//phất cờ
        $success = array();
    #validation title
        if(empty($_POST['title'])){
            $error['title'] = 'không được để trống title';
        }else{
            $title = htmlentities($_POST['title']);// htmlentities chuyển các ký tự thành html, chống hack
        }
    #2.validation slug
        if(empty($_POST['slug'])){
            $error['slug'] = 'không được để trống slug';
        }else{
            if(exists_slug("tbl_post_cat", "`url` = '{$_POST['slug']}'")){
                $error['slug'] = "đã tồn tại đường dẫn trên hệ thống";
            }else{
                $slug = htmlentities($_POST['slug']);// htmlentities chuyển các ký tự thành html, chống hack
            }
        }         
    #category
        $parent_Cat = $_POST['parent_Cat'];

    #level
        $level = get_level_by($parent_Cat);
        
    //kết luận
        if(empty($error)){
            $data = array(
                'cat_title' => $title,
                'url' => $slug,
                'level' => $level,
                'parent_id' => $parent_Cat
            );
            add_item('tbl_post_cat',$data);
            $success['ok'] = "đã thêm thành công";
        }
    }
// XỬ LÝ DANH MỤC BÀI POST
$list_post_cat = get_list_item('tbl_post_cat');

//LOAD VIEW
$data['list_post_cat'] =$list_post_cat;
    load_view('addcat',$data);
}

function editcatAction(){
 global $error, $title, $slug,$success;
    load('helper', 'validate');
    $cat_id = $_GET['cat_id'];
 //VALIDATE
    if(isset($_POST['btn_submit'])){
        $error = array();//phất cờ
        $success = array();
    #validation title
        if(empty($_POST['title'])){
            $error['title'] = 'không được để trống title';
        }else{
            $title = htmlentities($_POST['title']);// htmlentities chuyển các ký tự thành html, chống hack
        }
    #2.validation slug
        if(empty($_POST['slug'])){
            $error['slug'] = 'không được để trống slug';
        }else{
            if(exists_slug("tbl_post_cat", "`url` = '{$_POST['slug']}'")){
                $error['slug'] = "đã tồn tại đường dẫn trên hệ thống";
            }else{
                $slug = htmlentities($_POST['slug']);// htmlentities chuyển các ký tự thành html, chống hack
            }
        }         
    #category
        $parent_Cat = $_POST['parent_Cat'];
    #level
        $level = get_level_by($parent_Cat);
        
    //kết luận
        if(empty($error)){
            $data = array(
                'cat_title' => $title,
                'url' => $slug,
                'level' => $level
            );
            update_info_by_cat_id('tbl_post_cat',$data, $cat_id);
            $success['ok'] = "chỉnh sửa thành công";
        }
    }
// XỬ LÝ DANH MỤC BÀI POST
$list_post_cat = get_list_item('tbl_post_cat');
$post_cat = get_item_by_cat_id('tbl_post_cat', $cat_id);
//LOAD VIEW
$data['list_post_cat'] =$list_post_cat;
$data['post_cat'] =$post_cat;
    load_view('editcat',$data);
}

function deletecatAction(){
    $cat_id = $_GET["cat_id"];

    $role = $_SESSION['role'];
    if($role == 1){
        delete_item_by_cat_id('tbl_post_cat',$cat_id);
        echo  "Bạn đã xóa thành công. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
    }else{
        echo "Bạn đel có quyền xóa. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
    }
}