<?php

function construct() {
//    echo "DÙng chung, load đầu tiên";
    load_model('index');
    
}

function detailAction() {
	//lấy id page
$id = (int)$_GET["id"];
    $page = get_item_by_id('tbl_page',$id);

	$data["page"] = $page;
    load_view('index', $data);
}

