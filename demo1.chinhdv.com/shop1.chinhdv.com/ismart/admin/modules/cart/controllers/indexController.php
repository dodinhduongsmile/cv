<?php

function construct() {
		load('helper', 'format');
//    echo "DÙng chung, load đầu tiên";
    load_model('index');
    
}

function addAction() {
		//lấy id sp
$id = (int)$_GET["id"];
add_cart($id);
redirect("?mod=cart&controller=index&action=show");
  		
}

function showAction() {

    load_view('show');
}

function deleteAction() {
   $id = (int)$_GET["id"];//lấy id sp
delete_cart($id);
redirect("?mod=cart&controller=index&action=show");
}

function deleteallAction(){
	delete_cart();
redirect("?mod=cart&controller=index&action=show");
}

function updateAction(){
	if(isset($_POST["btn_update_cart"])){

	update_cart($_POST["qty"]);
	redirect("?mod=cart&controller=index&action=show");

	// show_array($_POST);
}
}
function checkoutAction(){
	$list_checkout = get_list_buy_cart();
	$data["list_checkout"] =$list_checkout;
	
	load_view('checkout',$data);
}