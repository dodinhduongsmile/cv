<?php
// http://localhost/unitop/backend/lession/section26/projectmvc.vn/?mod=user&controller=index&action=addd

function construct() {
    load_model('index');
    load('helper', 'validate');

}

function indexAction() {
	load('helper', 'pagging');
//PHÂN TRANG
$num_rows = num_rows('tbl_slide');//tổng số bản ghi tbl_post 
// echo $num_rows;
//số lượng bản ghi trên mỗi trang
$num_per_page = 8;
//tổng số bản ghi
$total_row = $num_rows;
//=>tổng số trang
$num_page = ceil($total_row / $num_per_page);

//chỉ số trang hiện tại
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 

//chỉ số bản ghi bắt đầu mỗi trang
$start = ($page - 1) * $num_per_page;

$list_slide = list_item('tbl_slide',$start, $num_per_page);
$get_pagging = get_pagging($num_page, $page, "?mod=slide&action=index");

//load view, truyền data sang view
   $data["get_pagging"] = $get_pagging;
//END PHÂN TRANG
$data['list_slide'] =$list_slide;

    load_view('index',$data);

}

function addAction() {
    global $error, $title, $slug;

    $success = array();
    if(isset($_POST['btn_submit'])){
        $error = array();//phất cờ
    #validation title
        if(empty($_POST['title'])){
            $error['title'] = 'không được để trống title';
        }else{
            $title = htmlentities($_POST['title']);// htmlentities chuyển các ký tự thành html, chống hack
        }
    #validation slug

        $slug = htmlentities($_POST['slug']);// htmlentities chuyển các ký tự thành html, chống hack
      
    #validation desc => cho phép trống thì phải sửa ở database là có thể null, nếu không sẽ lỗi nếu 2 cái này trống     
        $desc = htmlentities($_POST['desc']);
        

    #validate img
    	if(empty($_POST['thumbnail_url'])){
            $error['thumbnail_url'] = 'không được để trống img';
        }else{
            $thumb = $_POST['thumbnail_url'];// htmlentities chuyển các ký tự thành html, chống hack
        }
            // $thumb = $_POST['thumbnail_url'];
    #status
        $status = $_POST['status'];

    #order
    	if(empty($_POST['num_order'])){
            $error['num_order'] = 'không được để trống thứ tự ảnh';
        }else{
            $slide_order = $_POST['num_order'];// htmlentities chuyển các ký tự thành html, chống hack
        }
    	// $slide_order = $_POST['num_order'];

        $created_date = date('d-m-Y',time());
        $author = $_SESSION["user_login"];
    //kết luận
        if(empty($error)){
            $data = array(
                'slide_title' => $title,
                'slide_url' => $slug,
                'slide_des' => $desc,
                'slide_img' => $thumb,
                'slide_status' => $status,
                'slide_order' => $slide_order,
                'created_date' =>$created_date ,
                'author' => $author
            );
            add_item('tbl_slide', $data);
            $success['ok'] = "đã thêm thành công";
        }


    }
// XỬ LÝ DANH MỤC BÀI POST

    $data['success'] = $success;
    load_view('add',$data);
}

function editAction() {
    global $error, $title, $slug;
    $id = $_GET['id'];
    $slide_item = get_item_by_id('tbl_slide',$id);
    $success = array();
    if(isset($_POST['btn_submit'])){
        $error = array();//phất cờ
    #validation title
        if(empty($_POST['title'])){
            $error['title'] = 'không được để trống title';
        }else{
            $title = htmlentities($_POST['title']);// htmlentities chuyển các ký tự thành html, chống hack
        }
    #validation slug

        $slug = htmlentities($_POST['slug']);// htmlentities chuyển các ký tự thành html, chống hack
      
    #validation desc => cho phép trống thì phải sửa ở database là có thể null, nếu không sẽ lỗi nếu 2 cái này trống     
        $desc = htmlentities($_POST['desc']);
        

    #validate img
    	if(empty($_POST['thumbnail_url'])){
            $error['thumbnail_url'] = 'không được để trống img';
        }else{
            $thumb = $_POST['thumbnail_url'];// htmlentities chuyển các ký tự thành html, chống hack
        }
            // $thumb = $_POST['thumbnail_url'];
    #status
        $status = $_POST['status'];

    #order
    	if(empty($_POST['num_order'])){
            $error['num_order'] = 'không được để trống thứ tự ảnh';
        }else{
            $slide_order = $_POST['num_order'];// htmlentities chuyển các ký tự thành html, chống hack
        }
    	// $slide_order = $_POST['num_order'];

        $created_date = date('d-m-Y',time());
        $author = $_SESSION["user_login"];
    //kết luận
        if(empty($error)){
            $data = array(
                'slide_title' => $title,
                'slide_url' => $slug,
                'slide_des' => $desc,
                'slide_img' => $thumb,
                'slide_status' => $status,
                'slide_order' => $slide_order,
                'created_date' =>$created_date ,
                'author' => $author
            );
            update_info_by_id('tbl_slide', $data,$id);
            $success['ok'] = "đã cập nhật thành công";
        }


    }
// XỬ LÝ DANH MỤC BÀI POST

    $data['success'] = $success;
    $data['slide_item'] = $slide_item;
    load_view('edit',$data);
}
function deleteAction(){
    $id = $_GET["id"];
    $user = get_user_by_username($_SESSION['user_login']);
    $role = $user['role'];
    if($role == 1){
        delete_item_by_id('tbl_slide',$id);
        echo   "Bạn đã xóa thành công. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
    }else{
        echo "Bạn đel có quyền xóa. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
    }
}