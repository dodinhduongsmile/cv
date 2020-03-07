<?php
function construct() {
    load_model('index');
    load('helper', 'format');
}

function indexAction() {

//1.PHÂN TRANG
 load('helper', 'pagging');
//1.1số lượng bản ghi trên mỗi trang
$num_per_page = 8;
//1.2tổng số bản ghi
$total_row = num_rows('tbl_checkout');
//1.3tổng số trang
$num_page = ceil($total_row / $num_per_page);
//1.4chỉ số trang hiện tại
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 
//1.5chỉ số bản ghi bắt đầu mỗi trang
$start = ($page - 1) * $num_per_page;

$list_order = list_item_pagging('tbl_checkout', $start, $num_per_page);
$get_pagging = get_pagging($num_page, $page, "?mod=order&controller=index&action=index");

//load view, truyền data sang view
$data["get_pagging"] = $get_pagging;
$data['list_order'] =$list_order;
load_view('index',$data);

}

function status3Action() {

//1.PHÂN TRANG
 load('helper', 'pagging');
//1.1số lượng bản ghi trên mỗi trang
$num_per_page = 8;
//1.2tổng số bản ghi
$total_row = num_rows_by_status(3);;
//1.3tổng số trang
$num_page = ceil($total_row / $num_per_page);
//1.4chỉ số trang hiện tại
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 
//1.5chỉ số bản ghi bắt đầu mỗi trang
$start = ($page - 1) * $num_per_page;

$list_order = list_item_pagging('tbl_checkout', $start, $num_per_page,"`status` = 3");
$get_pagging = get_pagging($num_page, $page, "?mod=order&controller=index&action=status3");

//load view, truyền data sang view
$data["get_pagging"] = $get_pagging;
$data['list_order'] =$list_order;
load_view('status3',$data);
}
function status2Action() {

//1.PHÂN TRANG
 load('helper', 'pagging');
//1.1số lượng bản ghi trên mỗi trang
$num_per_page = 8;
//1.2tổng số bản ghi
$total_row = num_rows_by_status(2);;
//1.3tổng số trang
$num_page = ceil($total_row / $num_per_page);
//1.4chỉ số trang hiện tại
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 
//1.5chỉ số bản ghi bắt đầu mỗi trang
$start = ($page - 1) * $num_per_page;

$list_order = list_item_pagging('tbl_checkout', $start, $num_per_page,"`status` = 2");
$get_pagging = get_pagging($num_page, $page, "?mod=order&controller=index&action=status2");

//load view, truyền data sang view
$data["get_pagging"] = $get_pagging;
$data['list_order'] =$list_order;
load_view('status2',$data);
}
function status1Action() {

//1.PHÂN TRANG
 load('helper', 'pagging');
//1.1số lượng bản ghi trên mỗi trang
$num_per_page = 8;
//1.2tổng số bản ghi
$total_row = num_rows_by_status(1);;
//1.3tổng số trang
$num_page = ceil($total_row / $num_per_page);
//1.4chỉ số trang hiện tại
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 
//1.5chỉ số bản ghi bắt đầu mỗi trang
$start = ($page - 1) * $num_per_page;

$list_order = list_item_pagging('tbl_checkout', $start, $num_per_page,"`status` = 1");
$get_pagging = get_pagging($num_page, $page, "?mod=order&controller=index&action=status1");

//load view, truyền data sang view
$data["get_pagging"] = $get_pagging;
$data['list_order'] =$list_order;
load_view('status1',$data);
}
function status4Action() {

//1.PHÂN TRANG
 load('helper', 'pagging');
//1.1số lượng bản ghi trên mỗi trang
$num_per_page = 8;
//1.2tổng số bản ghi
$total_row = num_rows_by_status(4);;
//1.3tổng số trang
$num_page = ceil($total_row / $num_per_page);
//1.4chỉ số trang hiện tại
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 
//1.5chỉ số bản ghi bắt đầu mỗi trang
$start = ($page - 1) * $num_per_page;

$list_order = list_item_pagging('tbl_checkout', $start, $num_per_page,"`status` = 4");
$get_pagging = get_pagging($num_page, $page, "?mod=order&controller=index&action=status4");

//load view, truyền data sang view
$data["get_pagging"] = $get_pagging;
$data['list_order'] =$list_order;
load_view('status4',$data);
}

function editAction(){
	global $success;
	load('helper', 'validate');
	$id = $_GET['id'];
	$order = get_item_by_id('tbl_checkout', $id);

	//VALIDATE
   if(isset($_POST['btn_submit'])){
        $success = array();
    #price
        $price = $_POST['price'];

      $count = $_POST['count'];
    #validation desc, content => cho phép trống thì phải sửa ở database là có thể null, nếu không sẽ lỗi nếu 2 cái này trống     
        $content = $_POST['content'];
    #status
        $status = $_POST['status'];
    //kết luận
        if($_SESSION['role'] == 1){
            $data = array(
                'product' => $content,
                'total_price' => $price,
                'count_product' => $count,
                'status' => $status
            );
            update_info_by_id('tbl_checkout', $data, $id);
            $success['ok'] = "chỉnh sửa thành công";
        }else{
        	$success['ok'] = "Bạn không có quyền chỉnh sửa";
        }
    }
    $data['order'] = $order;
	load_view('edit',$data);
}

function deleteAction(){
    $id = $_GET["id"];
    $order =  get_item_by_id('tbl_checkout',$id);

    $status = $order['status'];
    $role = $_SESSION['role'];
    if($role == 1){
        if($status != 1){
            //Thay đổi status để đưa vào thùng rác
            $data = array('status' => 1);
            change_status($data, $id);
            echo   "Bạn đã xóa thành công. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
        }else{
            delete_item_by_id('tbl_checkout',$id);
            echo   "Bạn đã xóa thành công. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
        }
    }else{
        echo "Bạn đel có quyền xóa. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
    }
}


function customAction() {
 //1.PHÂN TRANG
 load('helper', 'pagging');
//1.1số lượng bản ghi trên mỗi trang
$num_per_page = 8;
//1.2tổng số bản ghi
$total_row = num_rows('tbl_product');;
//1.3tổng số trang
$num_page = ceil($total_row / $num_per_page);
//1.4chỉ số trang hiện tại
$page = isset($_GET["page"])?(int)$_GET["page"]:1; 
//1.5chỉ số bản ghi bắt đầu mỗi trang
$start = ($page - 1) * $num_per_page;

$list_custom = list_item_pagging('tbl_checkout', $start, $num_per_page);
$get_pagging = get_pagging($num_page, $page, "?mod=order&controller=index&action=custom");

//load view, truyền data sang view
$data["get_pagging"] = $get_pagging;
$data['list_custom'] =$list_custom;
load_view('custom',$data);
}
function deletecustomAction(){
	$id = $_GET["id"];
    $role = $_SESSION['role'];
    if($role == 1){
        delete_item_by_id('tbl_checkout',$id);
        echo   "Bạn đã xóa thành công. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
	}else{
        echo "Bạn đel có quyền xóa. Vui lòng quay lại <a href='javascript: history.go(-1)'> Mời quay lại</a>";
    }
}

function searchAction(){
global $error,$success;
load('helper', 'validate');
$result = array();
	if(isset($_POST['sm_search'])){
		$error = array();
		$key = $_POST['s'];
		if(check_search($key)){
			$result = get_result_search($key);
			$count_search = count($result);
			$success['search'] = "Có {$count_search} kết quả phù hợp với từ khóa: {$key}";
		}else{
			$error['search'] = "không có kết quả cho từ khóa: {$key}";

		}
	}
	$data['result'] = $result;
	load_view('search',$data);
}
