<?php
// http://localhost/unitop/backend/lession/section26/projectmvc.vn/?mod=user&controller=index&action=addd

function construct() {
    load_model('index');
    load('helper', 'format');
    load('helper', 'validate');

}
//Upload ảnh
function uploadAction() {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Bước 1: Tạo thư mục lưu file
    $error = array();
    $target_dir = "upload/thumb_product/";
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
$total_row = num_rows('tbl_product');;
//=>tổng số trang
$num_page = ceil($total_row / $num_per_page);

//chỉ số trang hiện tại
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 

//chỉ số bản ghi bắt đầu mỗi trang
$start = ($page - 1) * $num_per_page;

$list_product = list_product_join($start, $num_per_page);
$get_pagging = get_pagging($num_page, $page, "?mod=product&action=main");

//load view, truyền data sang view
   $data["get_pagging"] = $get_pagging;
//END PHÂN TRANG
$data['list_product'] =$list_product;
    load_view('index',$data);

}
function status3Action() {
 //1.PHÂN TRANG
    load('helper', 'pagging');
$num_per_page = 8;
$total_row = num_rows_by_status(3);
$num_page = ceil($total_row / $num_per_page);
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 
$start = ($page - 1) * $num_per_page;

$list_product = list_item_status('tbl_product', $start, $num_per_page, "`product_status` = 3");
$get_pagging = get_pagging($num_page, $page, "?mod=product&action=status3");
//END PHÂN TRANG
//load view, truyền data sang view
$data["get_pagging"] = $get_pagging;

$data['list_product'] =$list_product;
load_view('status3',$data);
}
function status2Action() {
 //1.PHÂN TRANG
    load('helper', 'pagging');
$num_per_page = 8;
$total_row = num_rows_by_status(2);
$num_page = ceil($total_row / $num_per_page);
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 
$start = ($page - 1) * $num_per_page;

$list_product = list_item_status('tbl_product', $start, $num_per_page, "`product_status` = 2");
$get_pagging = get_pagging($num_page, $page, "?mod=product&action=status2");
//END PHÂN TRANG
//load view, truyền data sang view
$data["get_pagging"] = $get_pagging;

$data['list_product'] =$list_product;
load_view('status2',$data);
}
function status1Action() {
 //1.PHÂN TRANG
    load('helper', 'pagging');
$num_per_page = 8;
$total_row = num_rows_by_status(1);
$num_page = ceil($total_row / $num_per_page);
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 
$start = ($page - 1) * $num_per_page;

$list_product = list_item_status('tbl_product', $start, $num_per_page, "`product_status` = 1");
$get_pagging = get_pagging($num_page, $page, "?mod=product&action=status1");
//END PHÂN TRANG
//load view, truyền data sang view
$data["get_pagging"] = $get_pagging;

$data['list_product'] =$list_product;
load_view('status1',$data);
}
function addAction() {
    global $error,$success, $title, $slug, $price,$old_price,$thumb,$content,$desc;
    
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
            if(exists_url($_POST['slug'])){
                $error['slug'] = "đã tồn tại đường dẫn trên hệ thống";
            }else{
                $slug = htmlentities($_POST['slug']);// htmlentities chuyển các ký tự thành html, chống hack
            }
        } 
    #price
      if(empty($_POST['price'])){
        $error['price'] = "không được để trống giá";
      }else{
        $price = (int)$_POST['price'];
      }

      $old_price = (int)$_POST['old_price'];
    #validation desc, content => cho phép trống thì phải sửa ở database là có thể null, nếu không sẽ lỗi nếu 2 cái này trống     
        $desc = htmlentities($_POST['desc']);
        $content = htmlentities($_POST['content']);

    #validate url file
            $thumb = $_POST['thumbnail_url'];
    #category
        $category = $_POST['parent_Cat'];
    #product_status
        $product_status = $_POST['product_status'];

        $created_date = date('d-m-Y',time());
        $author = $_SESSION["user_login"];
    //kết luận
        if(empty($error)){
            $data = array(
                'product_title' => $title,
                'product_slug' => $slug,
                'product_des' => $desc,
                'product_content' => $content,
                'price' => $price,
                'old_price' => $old_price,
                'product_thumb' => $thumb,
                'cat_id' => $category,
                'product_status' => $product_status,
                'created_date' =>$created_date ,
                'author' => $author
            );
            add_item('tbl_product', $data);
            $success['ok'] = "đã thêm thành công";
        }


    }
// XỬ LÝ DANH MỤC BÀI POST
    $list_product_cat = get_list_item('tbl_product_cat');

    $data['list_product_cat'] = $list_product_cat;

    load_view('add',$data);
}

function editAction() {
     global $error,$success, $title, $slug, $price,$old_price,$thumb,$content,$desc;
   
    
   $id = $_GET['id'];
   $product_item =  get_item_by_id('tbl_product',$id);
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
            if(exists_url1($_POST['slug'])){
                $error['slug'] = "đã tồn tại đường dẫn trên hệ thống";
            }else{
                $slug = htmlentities($_POST['slug']);// htmlentities chuyển các ký tự thành html, chống hack
            }
        } 
    #price
      if(empty($_POST['price'])){
        $error['price'] = "không được để trống giá";
      }else{
        $price = (int)$_POST['price'];
      }

      $old_price = (int)$_POST['old_price'];
    #validation desc, content => cho phép trống thì phải sửa ở database là có thể null, nếu không sẽ lỗi nếu 2 cái này trống     
        $desc = htmlentities($_POST['desc']);
        $content = htmlentities($_POST['content']);

    #validate url file
            $thumb = $_POST['thumbnail_url'];
    #category
        $category = $_POST['parent-Cat'];
    #product_status
        $product_status = $_POST['product_status'];
    //kết luận
        if(empty($error)){
            $data = array(
                'product_title' => $title,
                'product_slug' => $slug,
                'product_des' => $desc,
                'product_content' => $content,
                'price' => $price,
                'old_price' => $old_price,
                'product_thumb' => $thumb,
                'cat_id' => $category,
                'product_status' => $product_status
            );
            update_info_by_id('tbl_product', $data, $id);
            $success['ok'] = "chỉnh sửa thành công";
        }
    }
// XỬ LÝ DANH MỤC BÀI POST
    $list_product_cat = get_list_item('tbl_product_cat');

//LOAD VIEW
   $data['list_product_cat'] = $list_product_cat;
   $data['product_item'] = $product_item;
   load_view('edit',$data);
}

function deleteAction(){
    $id = $_GET["id"];
    $product_item =  get_item_by_id('tbl_product',$id);
    $thumbnail_url = $product_item['product_thumb'];
    $product_status = $product_item['product_status'];
    $role = $_SESSION['role'];
    if($role == 1){
        if($product_status != 1){
            //Thay đổi status để đưa vào thùng rác
            $data = array('product_status' => 1);
            change_status($data, $id);
            echo   "Bạn đã xóa thành công. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
        }else{
            delete_item_by_id('tbl_product',$id);
            if(!empty($thumbnail_url)){unlink($thumbnail_url);};
            echo   "Bạn đã xóa thành công. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
        }

    }else{
        echo "Bạn đel có quyền xóa. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
    }
}

//==
//XỬ LÝ PHẦN DANH MỤC
//===
function productcatAction(){
    load('helper', 'pagging');
//PHÂN TRANG

$num_per_page = 10;
$total_row = num_rows('tbl_product_cat');
$num_page = ceil($total_row / $num_per_page);
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 
$start = ($page - 1) * $num_per_page;

$list_product_cat = list_item('tbl_product_cat', $start, $num_per_page);
$get_pagging = get_pagging($num_page, $page, "?mod=product&action=productcat");

//load view, truyền data sang view
   $data["get_pagging"] = $get_pagging;
//END PHÂN TRANG
$data['list_product_cat'] =$list_product_cat;
$data['get_pagging'] = $get_pagging;
    load_view('productcat',$data);
}

function addcatAction(){
    global $error,$success, $title, $slug,$cat_order;
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
            if(exists_slug($_POST['slug'])){
                $error['slug'] = "đã tồn tại đường dẫn trên hệ thống";
            }else{
                $slug = htmlentities($_POST['slug']);// htmlentities chuyển các ký tự thành html, chống hack
            }
        }     
    #category
        $parent_Cat = $_POST['parent_Cat'];
    #level
        $level = get_level_by($parent_Cat);

        $cat_order = $_POST['cat_order'];
    //kết luận
        if(empty($error)){
            $data = array(
                'cat_title' => $title,
                'url' => $slug,
                'level' => $level,
                'cat_order' =>$cat_order,
                'cat_parent' =>$parent_Cat
            );
            add_item('tbl_product_cat',$data);
            $success['ok'] = "đã thêm thành công";
        }
    }
// XỬ LÝ DANH MỤC BÀI POST
$list_product_cat = get_list_item('tbl_product_cat');

//LOAD VIEW
$data['list_product_cat'] =$list_product_cat;
$data['success'] =$success;
    load_view('addcat',$data);
}

function editcatAction(){
global $error, $title, $slug,$success;
   
    
   $cat_id = $_GET['id'];
   $product_cat_item =  get_item_by_catid('tbl_product_cat',$cat_id);
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
            if(exists_slug1($_POST['slug'])){
                $error['slug'] = "đã tồn tại đường dẫn trên hệ thống";
            }else{
                $slug = htmlentities($_POST['slug']);// htmlentities chuyển các ký tự thành html, chống hack
            }
        }         
    #category
        $parent_Cat = $_POST['parent_Cat'];
    #level
        $level = get_level_by($parent_Cat);
        $cat_order = $_POST['cat_order'];
    #showhome
            $showhome = isset($_POST['showhome'])?$_POST['showhome']:1;//ở addcatAction không cần có vì xét ở database mặc định là =1
    //kết luận
        if(empty($error)){
            $data = array(
                'cat_title' => $title,
                'url' => $slug,
                'level' => $level,
                'cat_order' =>$cat_order,
                'cat_parent' =>$parent_Cat,
                'showhome' => $showhome
            );
            update_info_by_catid('tbl_product_cat',$data, $cat_id);
            $success['ok'] = "đã chỉnh sửa thành công";
        }
    }
// XỬ LÝ DANH MỤC PRODUCT
    $list_product_cat = get_list_item('tbl_product_cat');

//LOAD VIEW
   $data['list_product_cat'] = $list_product_cat;
   $data['product_cat_item'] = $product_cat_item;
   load_view('editcat',$data);
}

function deletecatAction(){
    $cat_id = $_GET["id"];
    $role = $_SESSION['role'];
    if($role == 1){
        delete_item_by_catid('tbl_product_cat',$cat_id);
        echo   "Bạn đã xóa thành công. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
    }else{
        echo "Bạn đel có quyền xóa. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
    }
}
