<?php

function construct() {
//    echo "DÙng chung, load đầu tiên";
    load_model('index');
    
}

function indexAction() {

//load thư viện
load('helper', 'pagging');

//===
//phần phân trang pagging
//===
//phân trang (mấy cái này xử lý bên Indexmodel cũng đc - thích viết ở đây)

$num_rows = num_rows('tbl_post');
//số lượng bản ghi trên mỗi trang
$num_per_page = 6;

//tổng số bản ghi
$total_row = $num_rows;
//=>tổng số trang
$num_page = ceil($total_row / $num_per_page);

//chỉ số trang hiện tại
$page = isset($_GET["page"])?(int)$_GET["page"]:1; //tồn tại $_GET["page"] thì $page = $_GET["page"], không tồn tại thì $page =1
//chỉ số bản ghi bắt đầu mỗi trang
$start = ($page - 1) * $num_per_page;

$list_post = list_item('tbl_post', $start, $num_per_page, "`status` = 3");

$get_pagging = get_pagging($num_page, $page, "?mod=post&controller=index&action=index");
//load view

   $data["get_pagging"] = $get_pagging;
   $data["list_post"] = $list_post;
    load_view('index', $data);
}

function detailAction(){
	$id = $_GET['id'];
	$post = get_item_by_id('tbl_post',$id);

	$data['post'] = $post;
	load_view('detail',$data);
}

