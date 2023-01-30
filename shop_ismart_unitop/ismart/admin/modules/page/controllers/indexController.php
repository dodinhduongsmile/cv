<?php

function construct() {
    load_model('index');
    
}

function mainAction() {
		load('helper', 'pagging');
//PHÂN TRANG
//số lượng bản ghi trên mỗi trang
$num_per_page = 8;
//tổng số bản ghi
$total_row = num_rows('tbl_page');//tổng số bản ghi tbl_post 
//=>tổng số trang
$num_page = ceil($total_row / $num_per_page);
//chỉ số trang hiện tại
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 

//chỉ số bản ghi bắt đầu mỗi trang
$start = ($page - 1) * $num_per_page;

$list_page = list_item('tbl_page', $start, $num_per_page);
$get_pagging = get_pagging($num_page, $page, "?mod=page&action=main");

//load view, truyền data sang view
   $data["get_pagging"] = $get_pagging;
//END PHÂN TRANG
$data['list_page'] =$list_page;

    load_view('index',$data);
}
function detailAction() {
	//lấy id page
// $id = (int)$_GET["id"];
//     $page = get_page_by_id($id);
// 	// show_array($page);

// 	$data["page"] = $page;
//     load_view('index', $data);
}

function addAction() {
    global $error, $title, $slug,$success,$content,$desc,$thumb;
    load('helper', 'validate');
    
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
    #validation desc, content => cho phép trống thì phải sửa ở database là có thể null, nếu không sẽ lỗi nếu 2 cái này trống     
        $desc = htmlentities($_POST['desc']);
        $content = htmlentities($_POST['content']);

    #validate url file
            $thumb = $_POST['thumbnail_url'];
    #category

        $created_date = date('d-m-Y',time());
        $author = $_SESSION["user_login"];
    //kết luận
        if(empty($error)){
            $data = array(
                'page_title' => $title,
                'page_slug' => $slug,
                'page_des' => $desc,
                'page_content' => $content,
                'page_thumb' => $thumb,
                'created_date' =>$created_date ,
                'author' => $author
            );
            add_item('tbl_page', $data);
            $success['ok'] = "đã thêm thành công";
        }
    }
    load_view('add');
}

function editAction() {
   global $error, $title, $slug,$success,$content,$desc,$thumb;
    load('helper', 'validate');
    
   $id = $_GET['id'];
   $page_item =  get_item_by_id('tbl_page',$id);
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
    #validation slug
        if(empty($_POST['slug'])){
            $error['slug'] = 'không được để trống slug';
        }else{
            $slug = htmlentities($_POST['slug']);// htmlentities chuyển các ký tự thành html, chống hack
        }       
    #validation desc, content => cho phép trống thì phải sửa ở database là có thể null, nếu không sẽ lỗi nếu 2 cái này trống     
        $desc = htmlentities($_POST['desc']);
        $content = htmlentities($_POST['content']);

    #validate url file
        $thumb = $_POST['thumbnail_url'];
    //kết luận
        if(empty($error)){
            $data = array(
                'page_title' => $title,
                'page_slug' => $slug,
                'page_des' => $desc,
                'page_content' => $content,
                'page_thumb' => $thumb
            );
            update_info_by_id('tbl_page',$data, $id);
            $success['ok'] = "đã cập nhật thành công";
        }
    }

//LOAD VIEW

   $data['page_item'] = $page_item;
   load_view('edit',$data);
}

function deleteAction(){
    $id = $_GET["id"];
    $role = $_SESSION['role'];
    if($role == 1){
        delete_item_by_id('tbl_page',$id);
        echo   "Bạn đã xóa thành công. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
    }else{
        echo "Bạn đel có quyền xóa. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
    }

}
