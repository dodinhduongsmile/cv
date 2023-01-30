<?php
function construct() {
    load_model('index');


}

function indexAction() {
//load thư viện
load('helper', 'pagging');
#1.lấy cat_id
$cat_id = (int)$_GET["cat_id"];

#2.thông tin danh mục sp(dúng join)
$info_cat = get_info_cat('tbl_product_cat',$cat_id);
$level = $info_cat['level'];

//3.1số lượng bản ghi trên mỗi trang
$num_per_page = 8;
$url = base_url("?mod=product&controller=index&action=index&cat_id={$cat_id}");
if($level == 0){
  //lấy danh sách sản phẩm là con cấp 1.
  //3.phân trang (mấy cái này xử lý bên Indexmodel cũng đc - thích viết ở đây)
  //3.2tổng số bản ghi
  $total_row = num_row_by_cat_parent($cat_id);
  // echo "số trang".$total_row;
  //3.3tổng số trang
  $num_page = ceil($total_row / $num_per_page);
  //3.4chỉ số trang hiện tại
  $page = isset($_GET["page"])?(int)$_GET["page"]:1;
  //3.5chỉ số bản ghi bắt đầu mỗi trang
  $start = ($page - 1) * $num_per_page;

  $list_product = list_product_by_cat_parent($cat_id, $start, $num_per_page, $url);
  $get_pagging = get_pagging($num_page, $page, "");
}else if($level != 0){
  //lấy danh sách sản phẩm là con cấp 1.
  //3.phân trang (mấy cái này xử lý bên Indexmodel cũng đc - thích viết ở đây)
  //3.2tổng số bản ghi
  $total_row = num_rows('tbl_product',$cat_id);
  //3.3tổng số trang
  $num_page = ceil($total_row / $num_per_page);
  //3.4chỉ số trang hiện tại
  $page = isset($_GET["page"])?(int)$_GET["page"]:1;
  //3.5chỉ số bản ghi bắt đầu mỗi trang
  $start = ($page - 1) * $num_per_page;

  $list_product = list_product($cat_id, $start, $num_per_page);
  $get_pagging = get_pagging($num_page, $page, $url);
}

//load view

//SẮP XẾP
if(!empty($_POST['select_sort'])){
  if($_POST['select_sort'] == 'az'){
    $list_product = list_product_sort($cat_id, 'product_title');
  }else if($_POST['select_sort'] == 'za'){
    $list_product = list_product_rsort($cat_id, 'product_title');
  }else if($_POST['select_sort'] == 'sort'){
    $list_product = list_product_sort($cat_id, 'price');
  }else if($_POST['select_sort'] == 'rsort'){
    $list_product = list_product_rsort($cat_id, 'price');
  }else{
    die();
  }
}

//LOAD VIEW
   $data["info_cat"] = $info_cat;

   $data["list_product"] = $list_product;
   $data["get_pagging"] = $get_pagging;

   load_view('index', $data);
}

function detailAction() {
 $id = (int)$_GET["id"];

//lấy dữ liệu bài viết (sản phẩm)theo id
$item = get_item_by_id('tbl_product',$id);
$cat_id = $item['cat_id'];
#thông tin danh mục sp
$info_cat = get_info_cat('tbl_product_cat',$cat_id);

$list_product = get_list_item('tbl_product');
//load view
    $data["item"] = $item;
    $data["info_cat"] = $info_cat;
    $data["list_product"] = $list_product;

   load_view('detail', $data);
}
function searchAction(){
global $error,$success;

load('helper', 'pagging');
load('helper', 'validate');
//SEARCH
$result = array();
$data = array();
  if(isset($_POST['btn_search'])){
    $error = array();
    //
    $key = $_POST['search'];
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



function filterAction() {

 
    //Xử lí lọc dữ liệu
    // Lọc giá sản phẩm
    //TH1:
    if (isset($_POST['price'])) {
        $price = $_POST['price'];
        if ($price == 1) {
            //Lấy các sản phẩm dưới 500.000đ
            $list_product = get_product_filter_price_round(500000);
        } elseif ($price == 2) {
            //Lấy ra các sp có giá trong khoảng: 500.000 - 1triêu
            $list_product = get_product_filter_price(500000, 1000000);
        } elseif ($price == 3) {
            $list_product = get_product_filter_price(1000000, 5000000);
        } elseif ($price == 4) {
            $list_product = get_product_filter_price(5000000, 10000000);
        } elseif ($price == 5) {
            $list_product = get_product_filter_price(10000000, 20000000);
        } elseif ($price == 6) {
            $list_product = get_product_filter_price_ceil(20000000);
        }
        $body = "";
        if (!empty($list_product)) {
            foreach ($list_product as $item) {
              $url_product = base_url("{$item['product_slug']}-{$item['id']}");
              $product_thumb = base_url("admin/{$item['product_thumb']}");
              $url_addcart = base_url("?mod=cart&controller=index&action=add&id={$item['id']}");
              $url_checkout = base_url("?mod=cart&controller=index&action=checkout&id={$item['id']}");
                $body .= "<li>
                            <a href='{$url_product}' title=' class='thumb'>
                                <img src='{$product_thumb}'>
                            </a>
                            <a href='{$url_product}' title=' class='product-name'>" . $item['product_title'] . "</a>
                            <div class='price'>
                                <span class='new'>" . currency_format($item['price']) . "</span>
                                <span class='old'>". currency_format($item['old_price']) ."</span>
                            </div>
                            <div class='action clearfix'>
                                <a href='{$url_addcart}' title='Thêm giỏ hàng' class='add-cart fl-left'>Thêm giỏ hàng</a>
                                <a href='{$url_checkout}' title='Mua ngay' class='buy-now fl-right'>Mua ngay</a>
                            </div>
                        </li>";
            }
        }
    } else {
        
    }
    echo $body;
};