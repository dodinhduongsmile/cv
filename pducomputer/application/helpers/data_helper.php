<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 if (!function_exists('setCacheh')) {
    /*
    nếu có gọi vào thẳng model ở chỗ khác thì setcache ở model,
    nếu chỉ gọi riêng ở đây thì mới set ở đây
     */
 function setCacheh($key, $data, $timeOut = 3600)
    {
        $instance =& get_instance();
        if (CACHE_MODE == TRUE) {
            if($data === null) $timeOut = 60*1;
            $instance->cache->save($key, $data, $timeOut);
        }
    }
}
if (!function_exists('getCacheh')) {
    /*nếu ở bên model có setcache rồi thì ở đây getCache cho nhanh
    -> ưu tiên setCache ở bên model, rồi chỗ này getcache thôi, đỡ phải load_model
    */
function getCacheh($key)
    {
        $instance =& get_instance();
        if (CACHE_MODE == TRUE) {
            return $instance->cache->get($key);
        } else return false;
    }
}
if (!function_exists('cms_delete_public_file_by_extend')) {
    function cms_delete_public_file_by_extend($extend)
    {
        {
            $fullPath = ROOT_UPLOAD_IMPORT_PATH;
            array_map('unlink', glob("$fullPath*" . $extend));
        }
    }
}
//1. lấy giá trị của table st_setting
if (!function_exists('getSetting')) {
    function getSetting($key_setting){
        $key = "cacheSetting_{$key_setting}";
        $data = getCacheh($key);
        if(empty($data)){
            $instance =& get_instance();
            $instance->load->model('setting_model');
            $setting_model = new Setting_model();
            $data = $setting_model->get_setting_by_key($key_setting);
            $data = !empty($data) ? json_decode($data->value_setting) : '';
            setCacheh($key,$data,36000);
        }
            return $data;
    }
}
//2. lấy bài post thông qua id
if (!function_exists('getByIdPost')) {
    function getByIdPost($post_id){
        $_this =& get_instance(); // tạo đối tượng CI
        $_this->load->model(array('post_model'));
        $post_model = new Post_model();
        $dataPost = $post_model->getById($post_id);
        return $dataPost;
    }
}

if (!function_exists('getByIdProduct')) {
    function getByIdProduct($product_id){
        $_this =& get_instance();
        $_this->load->model('product_model');
        $product_model = new Product_model();
        $data = $product_model->getById($product_id,'id,title,price,price_sale,size,mass,thumbnail,slug,guarantee,quality,code');
        return $data;
    }
}
//lấy danh sách showroom
if (!function_exists('getStore')) {
    function getStore($type=''){
        $_this =& get_instance();
        $_this->load->model('store_model');
        $store_model = new Store_model();
        $data = $store_model->getDataStore($type);
        return $data;
    }
}
//lấy data
if (!function_exists('getDataAll')) {
    function getDataAll($conditions = [], $tablename = '', $select = '*',$order='',$getfirst=false,$limit=''){
        $_this =& get_instance();
        $_this->load->model('store_model');
        $store_model = new Store_model();
        $data = $store_model->getDataAll($conditions, $tablename, $select,$order,$getfirst,$limit);
        return $data;
    }
}
if (!function_exists('getDataProductType')) {
    function getDataProductType($where=array()){
        $key = "LogoProductType";
        $data = getCacheh($key);
        if(empty($data)){
            $_this =& get_instance();
            $_this->load->model('product_type_model');
            $product_type_model = new Product_type_model();
            $data = $product_type_model->getDataProductType($where);
        }
        return $data;
    }
}
if (!function_exists('getDataBanner')) {
    function getDataBanner($type){
        $key = "cacheBanner_{$type}";
        $data = getCacheh($key);
        if(empty($data)){
            $_this =& get_instance();
            $_this->load->model('banner_model');
            $banner_model = new Banner_model();
            $data = $banner_model->getDataBanner($type);
        }
        return $data;
    }
}
function toSlug($doc) {
    $str = addslashes(html_entity_decode($doc));
    $str = toNormal($str);
    $str = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
    $str = preg_replace('~[^\pL\d]+~u', '-', $str);
    $str = preg_replace('~[^-\w]+~', '', $str);;
    $str = preg_replace("/( )/", '-', $str);
    $str = str_replace('/', '', $str);
    $str = str_replace("\/", '', $str);
    $str = str_replace("+", "", $str);
    $str = strtolower($str);
    $str = stripslashes($str);
    return trim($str, '-');
}
function toNormal($str) {
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    return $str;
}

if (!function_exists('isMobileDevice')) {
    function isMobileDevice() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }
}



if (!function_exists('getMenuParent')) {
    function getMenuParent($parent_id,$location=0)
    {
        $_this =& get_instance();
        $_this->load->model('menus_model');
        $data = $_this->menus_model->getMenuParent($parent_id,$location);
        return $data;
    }
}

//lấy list con trực tiếp của parent_id
if (!function_exists('getListChild')) {
    function getListChild($parent_id)
    {
        $_this =& get_instance();
        $_this->load->model('category_model');
        $data = $_this->category_model->getListChild('product',$parent_id);
        return $data;
    }
}
if (!function_exists('getCateChild')) {
    function getCateChild($allcate,$parent_id)
    {
        $_this =& get_instance();
        $_this->load->model('category_model');
        $data = $_this->category_model->getCateChild($allcate,$parent_id);
        return $data;
    }
}

if (!function_exists('show_price_detail')) {
    function show_price_coin($oneItem,$unit=' COIN')
    {
        $_this =& get_instance();
        $price_coin = (int)$_this->_settings_email->coin_price;
        
        if (!empty($oneItem->price) && !empty($oneItem->price_sale)) {
           $html = '<span class="current-price">'.number_format($oneItem->price_sale/$price_coin,0,'','.').$unit.'</span>
                    <span class="original-price"><s>'.number_format($oneItem->price/$price_coin,0,'','.'). $unit.'</s></span>';

        }elseif(empty($oneItem->price_sale) && !empty($oneItem->price)){
            $html = '<span class="current-price">'.number_format($oneItem->price/$price_coin,0,'','.'). $unit.'</span>';
        }else{
            $html = '<span class="current-price">Miễn phí</span>';
        }

        
        return $html;
    }
}
if (!function_exists('show_price_detail')) {
    function show_price_detail($oneItem,$unit=' vnđ')
    {
        $price_remaining = $oneItem->price - $oneItem->price_sale;
        if (!empty($oneItem->price) && !empty($oneItem->price_sale)) {
           $html = '<span class="current-price">'.number_format($oneItem->price_sale,0,'','.').$unit.'</span>
                    <span class="original-price"><s>'.number_format($oneItem->price,0,'','.'). $unit.'</s></span>';

        }elseif(empty($oneItem->price_sale) && !empty($oneItem->price)){
            $html = '<span class="current-price">'.number_format($oneItem->price,0,'','.'). $unit.'</span>';
        }else{
            $html = 'Giá: <span class="current-price">Liên hệ</span>';
        }
        return $html;
    }
}
if (!function_exists('show_price_detail1')) {
    function show_price_detail1($oneItem,$unit=' vnđ')
    {
        $price_remaining = $oneItem->price - $oneItem->price_sale;
        if (!empty($oneItem->price) && !empty($oneItem->price_sale)) {
           $html = '<span class="current-price">'.number_format($oneItem->price_sale,0,'','.').$unit.'</span>
                    <span class="original-price"><s>'.number_format($oneItem->price,0,'','.'). $unit.'</s></span>
                    <p><em class="PriceSaving">(Bạn đã tiết kiệm được '.number_format($price_remaining,0,'','.').$unit.')</em></p>';

        }elseif(empty($oneItem->price_sale) && !empty($oneItem->price)){
            $html = '<span class="current-price">'.number_format($oneItem->price,0,'','.'). $unit.'</span>';
        }else{
            $html = '<span class="current-price">Liên hệ</span>';
        }
        return $html;
    }
}

//show giá ở cart,cart/done, cart/detail. quantrong
if (!function_exists('show_price_cart')) {
    function show_price_cart($oneItem,$quality)
    {
        $html = '';
        if (!empty($oneItem->price)) {
            $html = '<td class="text-center">'.number_format($oneItem->price,0,'','.').'<sup>₫</sup></td>
            <td class="text-center subtotal">'.number_format($oneItem->price*$quality,0,'','.').'<sup>₫</sup></td>';
        }else{
            $html = '<td class="text-center">Liên hệ</td>
            <td class="text-center">Liên hệ</td>';
        }
        echo $html;
    }
}


if (!function_exists('replace_content')) {
    function replace_content($content) {
        if (!empty($content)) {
            $content = htmlentities($content, null, 'utf-8');
            $content = str_replace('/data/upload', 'public/media/upload', $content);
            $content = str_replace('/data/images/product', 'public/media/upload/product', $content);
            $content = str_replace('/data/images/product_images', 'public/media/upload/product_images', $content);
            $content = str_replace("&nbsp;", "", $content);
            $content = preg_replace('/(style=".*?")/m','',$content);
            $content = html_entity_decode($content);
        }else{
            $content = 'Đang cập nhật';
        }
        return $content;
    }
}


if (!function_exists('convertDetailTime')) {
    function convertDetailTime($time) {
        $dow = getDay($time, 0);
        $date= date("d/m/Y", strtotime($time));
        $time= date("H:i", strtotime($time));
        return "{$dow}, ngày {$date} - {$time}";
    }
}
function getDay($time,$type=0){
    $getday = date('D',strtotime($time));
    $arrayDay = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
    $arrayDayVn = ['Thứ Hai','Thứ Ba','Thứ Tư','Thứ Năm','Thứ Sáu','Thứ Bảy','Chủ Nhật'];
    $arrayDayNumber = ['Thứ 2','Thứ 3','Thứ 4','Thứ 5','Thứ 6','Thứ 7','Chủ nhật'];
    $arrayDayLinkLite = ['thu-2','thu-3','thu-4','thu-5','thu-6','thu-7','chu-nhat'];
    $arrayDayLink = ['t2','t3','t4','t5','t6','t7','cn'];
    if($type == 0){for ($i=0;$i<count($arrayDay);$i++){if($getday == $arrayDay[$i]){return $arrayDayVn[$i];};};};
    if($type == 1){for ($i=0;$i<count($arrayDay);$i++){if($getday == $arrayDay[$i]){return $arrayDayLink[$i];};};};
    if($type == 2){for ($i=0;$i<count($arrayDay);$i++){if($getday == $arrayDay[$i]){return $arrayDayLinkLite[$i];};};};
    if($type == 3){for ($i=0;$i<count($arrayDay);$i++){if($getday == $arrayDay[$i]){return $arrayDayNumber[$i];};};};
    if ($type == 4) {
        $current_type_6 = 'ngày '.date('j',strtotime($time)).' tháng '.date('n',strtotime($time)).' năm '.date('Y',strtotime($time));
        return $current_type_6;
    }
}

if (!function_exists('symUserpdu')) {
//check user backend
function symUserpdu($symbol_lv){
    // $symbol_lv = $this->session->userdata("lever");
    switch ($symbol_lv) {
      case 3:
        echo '<div class="user admincap3"></div>';
        break;
      case 2:
        echo '<div class="user admincap2"></div>';
        break;
      case 1:
        echo '<div class="user admincap1"></div>';
        break;
      default:
        echo '<div class="user usercap0"></div>';
    };
}}