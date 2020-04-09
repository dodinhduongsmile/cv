<?php
// http://localhost/unitop/backend/lession/section26/projectmvc.vn/?mod=user&controller=index&action=addd

function construct() {
//    echo "DÙng chung, load đầu tiên";
    load_model('index');
    load('helper', 'validate');

}
function mainAction(){
 load('helper', 'pagging');
//PHÂN TRANG
$num_rows = num_rows('tbl_block');//tổng số bản ghi tbl_post 
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

$list_block = list_item('tbl_block',$start, $num_per_page);
$get_pagging = get_pagging($num_page, $page, "?mod=block&action=main");

//load view, truyền data sang view
   $data["get_pagging"] = $get_pagging;
//END PHÂN TRANG
$data['list_block'] =$list_block;

    load_view('index',$data);
}

function addAction() {
	 global $error, $title, $slug,$success;
    
    
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
    #des
    	$desc = htmlentities($_POST['desc']);
    	$created_date = date('d-m-Y',time());
        $author = $_SESSION["user_login"];
    //kết luận
        if(empty($error)){
            $data = array(
                'name_block' => $title,
                'code_block' => $slug,
                'content_block' => $desc,
                'created_date' => $created_date,
                'author' => $author
            );
            add_item('tbl_block',$data);
            $success['ok'] = "đã thêm thành công";
        }
    }

//LOAD VIEW
    load_view('add');
}

function editAction(){
	global $error, $title, $slug;
   
    $success = array();
   $id = $_GET['id'];
   $block_item =  get_item_by_id('tbl_block',$id);
//VALIDATE
    if(isset($_POST['btn_submit'])){
        $error = array();//phất cờ
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
    #des
    	$desc = htmlentities($_POST['desc']);
    	$created_date = date('d-m-Y',time());
        $author = $_SESSION["user_login"];
    //kết luận
        if(empty($error)){
            $data = array(
                'name_block' => $title,
                'code_block' => $slug,
                'content_block' => $desc,
                'created_date' => $created_date,
                'author' => $author
            );
            update_info_by_id('tbl_block',$data,$id);
            $success['ok'] = "đã thêm thành công";
        }
    }


//LOAD VIEW

   $data['block_item'] = $block_item;
   $data['success'] = $success;
   load_view('edit',$data);
}
function deleteAction(){
    $id = $_GET["id"];

    $role = $_SESSION['role'];
    if($role == 1){
        delete_item_by_id('tbl_block',$id);
        echo   "Bạn đã xóa thành công. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
    }else{
        echo "Bạn đel có quyền xóa. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
    }
}

//==
//MENU DÙNG LUÔN MODEL INDEX
//==
function menuAction(){
global $error, $title, $url_static,$success;
    
 //VALIDATE
    if(isset($_POST['sm_add'])){
        $error = array();//phất cờ
         $success = array();
    #validation title
        if(empty($_POST['title'])){
            $error['title'] = 'không được để trống title';
        }else{
            $title = htmlentities($_POST['title']);// htmlentities chuyển các ký tự thành html, chống hack
        }
    #validation slug
        if(empty($_POST['url_static'])){
            $error['url_static'] = 'không được để trống url_static';
        }else{
            $url_static = htmlentities($_POST['url_static']);// htmlentities chuyển các ký tự thành html, chống hack
        }       
    #parent
    	$menu_parent = $_POST['parent_id'];
    #menu_order
    	if(empty($_POST['menu_order'])){
            $error['menu_order'] = 'không được để trống thứ tự';
        }else{
            $menu_order = $_POST['menu_order'];// htmlentities chuyển các ký tự thành html, chống hack
        }    
    	

    	#level
        $level = get_level_by($menu_parent);
    //kết luận
        if(empty($error)){
            $data = array(
                'menu_name' => $title,
                'menu_url' => $url_static,
                'menu_parent' =>$menu_parent,
                'menu_order' => $menu_order,
                'level' => $level
            );
            add_item('tbl_menu',$data);
            $success['ok'] = "đã thêm thành công";
        }
    }

//LOAD VIEW

//=======
	$list_menu = get_list_item('tbl_menu');

	$data['list_menu'] =$list_menu;

	load_view('menu',$data);
}

function editmenuAction(){
global $error, $title, $url_static,$success;
    $id = $_GET['id'];
    $menu_item = get_item_by_id('tbl_menu',$id);
    
 //VALIDATE
    if(isset($_POST['sm_add'])){
        $error = array();//phất cờ
        $success = array();
    #validation title
        if(empty($_POST['title'])){
            $error['title'] = 'không được để trống title';
        }else{
            $title = htmlentities($_POST['title']);// htmlentities chuyển các ký tự thành html, chống hack
        }
    #validation slug
        if(empty($_POST['url_static'])){
            $error['url_static'] = 'không được để trống url_static';
        }else{
            $url_static = htmlentities($_POST['url_static']);// htmlentities chuyển các ký tự thành html, chống hack
        }       
    #parent
    	$menu_parent = $_POST['parent_id'];
    #menu_order
    	#menu_order
    	if(empty($_POST['menu_order'])){
            $error['menu_order'] = 'không được để trống thứ tự menu';
        }else{
            $menu_order = $_POST['menu_order'];
        } 

    	$level = 0;
    	if($menu_parent > 0){
    		$level += 1;
    	}
    //kết luận
        if(empty($error)){
            $data = array(
                'menu_name' => $title,
                'menu_url' => $url_static,
                'menu_parent' =>$menu_parent,
                'menu_order' => $menu_order,
                'level' => $level
            );
            update_info_by_id('tbl_menu',$data,$id);
            $success['ok'] = "đã update thành công";
        }
    }

//LOAD VIEW
$list_menu = get_list_item('tbl_menu');

    $data['list_menu'] =$list_menu;
	$data['menu_item'] =$menu_item;
	load_view('editmenu',$data);
}
function deletemenuAction(){
    $id = $_GET["id"];
    $role = $_SESSION['role'];
    if($role == 1){
        delete_item_by_id('tbl_menu',$id);
        echo   "Bạn đã xóa thành công. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
    }else{
        echo "Bạn đel có quyền xóa. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
    }
}