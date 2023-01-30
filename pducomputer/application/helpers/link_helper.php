<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('site_admin_url')) {
    function site_admin_url($uri = '')
    {
        return BASE_ADMIN_URL . $uri;
    }
}
if (!function_exists('get_url_page')) {
    function get_url_page($optional){
        $linkReturn = BASE_URL.$optional->slug.'.html';
        return $linkReturn;
    }
}
if (!function_exists('get_url_codesale')) {
    function get_url_codesale($optional){
        $linkReturn = BASE_URL.'voucher'.$optional->id.'_'.$optional->slug.'.html';
        return $linkReturn;
    }
}
if (!function_exists('get_url_category_post')) {
    function get_url_category_codesale($optional,$page=''){
        $linkReturn = BASE_URL.'vouchers_'.$optional->slug.'.html';
        if(!empty($page)) $linkReturn.="/page";
        return $linkReturn;
    }
}

if (!function_exists('cutString')){
    function cutString($chuoi,$max){
        $length_chuoi = strlen($chuoi);
        if($length_chuoi <= $max){
            return $chuoi;
        }else{
            return mb_substr($chuoi,0,$max,'UTF-8').'...';
        }
    }
}

if (!function_exists('get_url_product_type')) {
    function get_url_product_type($optional,$page=''){
        $optional = (object)$optional;
        $linkReturn = BASE_URL.'dh'.$optional->id.'_'.$optional->slug.'.html';
        if(!empty($page)) $linkReturn.="/page";
        return $linkReturn;
    }
}

//url chỗ thêm danh mục sản phẩm trong menu ở admin
if (!function_exists('get_url_category_product')) {
    function get_url_category_product($optional,$page=''){
        $linkReturn = BASE_URL.'pd'.$optional->id.'_'.$optional->slug.'.html';
        if(!empty($page)) $linkReturn.="/page";
        return $linkReturn;
    }
}



//tạo url danh mục sản phẩm ở menu, vì nó cần tiền tố pd nữa
if (!function_exists('get_url_category_product_menu')) {
    function get_url_category_product_menu($optional){
        if (isset($optional->slug)) {
            return BASE_URL.'pd'.$optional->id.'_'.$optional->slug.'.html';
        }
        if (empty($optional->link)) {
            return base_url();
        }
        $linkReturn = BASE_URL.$optional->link.'.html';
        return $linkReturn;
    }
}

if (!function_exists('get_url_category_post')) {
    function get_url_category_post($optional,$page=''){
        $linkReturn = BASE_URL.'ac'.$optional->id.'_'.$optional->slug.'.html';
        if(!empty($page)) $linkReturn.="/page";
        return $linkReturn;
    }
}
if (!function_exists('get_url_post')) {
    function get_url_post($optional){
        $linkReturn = BASE_URL.'ad'.$optional->id.'_'.$optional->slug.'.html';
        return $linkReturn;
    }
}
//link product có tiền tố pc, định nghĩa ở router, nếu muốn sửa
if (!function_exists('get_url_product')) {
    function get_url_product($optional){
        $linkReturn = BASE_URL.'pdu'.$optional->id.'_'.$optional->slug.'.html';
        return $linkReturn;
    }
}


if (!function_exists('get_url_bao_gia')) {
    function get_url_bao_gia($optional,$page=''){
        $linkReturn = BASE_URL.'am_'.$optional->slug.'.html';
        if(!empty($page)) $linkReturn.="/page";
        return $linkReturn;
    }
}


// link edu
if (!function_exists('get_url_category_edu')) {
    function get_url_category_edu($optional,$page=''){
        $linkReturn = BASE_URL.'edu'.$optional->id.'_'.$optional->slug.'.html';
        if(!empty($page)) $linkReturn.="/page";
        return $linkReturn;
    }
}
if (!function_exists('get_url_edu')) {
    function get_url_edu($optional){
        $linkReturn = BASE_URL.'ed'.$optional->id.'_'.$optional->slug.'.html';
        return $linkReturn;
    }
}
if (!function_exists('get_all_url_detail')) {
    function get_all_url_detail($type,$id,$slug){

        $urlcate = [
          "edu" => "ed",
          "product" => "pdu",
          "post" => "ad",
          "sale" => "voucher"
        ];
        $link = base_url($urlcate[$type].$id."_".$slug.'.html');
        return $link;
    }
}