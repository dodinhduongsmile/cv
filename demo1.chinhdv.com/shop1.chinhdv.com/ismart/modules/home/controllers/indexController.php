<?php
function construct() {
//    echo "DÙng chung, load đầu tiên";
    load_model('index');
}

function indexAction() {

    
#LẤY DANH SÁCH SLIDE ĐÃ ACTIVE
$slide = get_list_slide('tbl_slide');

#danh sách all tbl_product
$list_product = get_list_item('tbl_product');

#lấy danh sách các tbl_product  theo cat_id fix luôn.
$list_cat = list_cat_by_level(0); //và showhome = 1

//ĐỔ DỮ LIỆU SANG VIEW
    $data['slide'] = $slide;
    $data['list_product'] = $list_product;
   $data["list_cat"] = $list_cat;
   
//LOAD VIEW
   load_view('index',$data);
}



