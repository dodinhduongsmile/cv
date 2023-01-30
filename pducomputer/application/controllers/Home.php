<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends Public_Controller
{
    protected $_product; 
    protected $_menu; 
    protected $_category; 
    protected $_post; 
    protected $_customer; 
    protected $_key_history;
    protected $_banner;

    public function __construct(){ 
        parent::__construct();
        $this->load->model(['menus_model','product_model','category_model','post_model','CustomerReview_model','banner_model']);
        $this->_menu     = new Menus_model();
        $this->_product  = new Product_model();
        $this->_post     = new Post_model();
        $this->_category = new Category_model();
        $this->_customer = new CustomerReview_model();
        $this->_banner   = new Banner_model();
        $this->_key_history  = 'history';
    } 


	public function index() {  
        
        if (!empty($_SESSION['orderId'])) {
            unset($_SESSION['orderId']);
            $this->cart->destroy();
        }
        
        /*sp có danh mục is_featured=1, hiện ở tab đầu tiên
        1.lấy đc danh mục có is_featured=1 -> lấy mảng id của nó
        2. dùng hàm getDataProductByCategory($arrcate) để lấy sp
        */
        $data['cate_featured'] = $cate_featured = $this->_category->getDataAll(['is_featured'=>1,'type'=>'product'],'','id,title,slug');
        if(!empty($cate_featured)){
            foreach ($cate_featured as $key => $value) {
               $data['cate_featuredx'][$key]['product']= $this->_product->getDataProductByCategory($value->id,8);
               $data['cate_featuredx'][$key]['cate'] = $value;
            }
        }
        
        //danh muc sp
        $data['category_product']  = $this->category_product();
        //sp hot sd cache
        $data['hot_product']       = $this->_product->getDataProductHot(8);
        // get product
        // $data['product'] = $this->_product->getProduct();
        // review sd cache
        $data['customer_review'] = $this->_customer->getDataCustomerReview();
        /*list tin tuc ở 1 danh mục có is_featured=1
        
        */
       
        $data['post_featured'] = $post_featured = $this->_category->getDataAll(['is_featured'=>1,'type'=>'post'],'','id,title,slug','random');
        if(!empty($post_featured)){
            $ids = array_column($post_featured, 'id');
            $data['post_featured1']= $this->_post->getDataPostByCategorys($ids,8);
        }

        //danh sachs khach hang
        // $data['list_customer']     = $this->_customer->getDataCustomer();
        //get banner, news_review, certify sd cache
        $data['list_banner']       = $this->_banner->getDataBanner('banner');
        $data['list_review']       = $this->_banner->getDataBanner('news_review');
        $data['list_bannerright']       = $this->_banner->getDataBanner('banner',2);

        // $history      = get_cookie($this->_key_history);
        // $data_history = json_decode($history);
        // $data['product_history']  = !empty($data_history) ? $this->_product->getDataProductHistory($data_history) : '';

        $data['main_content']  = $this->load->view($this->template_path . 'home/index', $data, TRUE);
        $this->load->view($this->template_main, $data);
        // $this->category_product();
        // dd($this->_product->getDataProductByCategory1());//test join
	}

//lấy all danh mục con của 1 danh mục. không tính danh mục đó.
public function getAllCateByCate($id_cate)
{
    /*
    1.lấy danh mục con,cháu, chắt của 1 danh mục $id_cate nào đó
     */
    $category = [];
    $category_sub1 = array();
    $child = $this->_category->getCategoryChild($id_cate);
    if(!empty($child)){
        foreach($child as $key => $value){
            $category[] = $value;
            if(!empty($this->_category->getCategoryChild($value->id))){
                $category_sub1 = $this->getAllCateByCate($value->id);//lấy đến thằng cháu chắt luôn
                $category = array_merge($category,$category_sub1);
            }
            
        }
        
    }else{
        $category = $this->_category->getCatById($id_cate);
    }

    return $category;
}
//lấy all item theo all danh mục con và cháu, cả danh mục cha
public function allProByCate($idcate)
{
$category = $this->_category->getCatById($idcate);
$cate = $this->getAllCateByCate($idcate);
$cate = array_merge($cate,$category);//nối danh mục con với danh mục cha
   $cateid = array_column($cate, 'id');
   $data_product = $this->_product->getDataProductByCategory($cateid);
    // dd($data_product);
    return $data_product;
}
//lấy all item post theo danh mục
public function allPostByCate($idcate,$limit)
{
$category = $this->_category->getCatById($idcate);
$cate = $this->getAllCateByCate($idcate);
$cate = array_merge($cate,$category);
   $cateid = array_column($cate, 'id');
   $data_post = $this->_post->getDataPostByCategorys($cateid,$limit);
    // dd($data_product);
    return $data_post;
}
//lấy all item theo danh mục có ở menu số 4, áp dụng menu 2 cấp
public function allProductByCategory()
    {
        $child = [];
        $childx = [];
        $category = $this->_menu->getMenuParent(0,4);//danh mục menu4, có parent_id=0

        if (!empty($category)) foreach ($category as $key => $value) {
            
            $child = $this->_menu->getMenuParent($value->id,4);
            $childx = array_merge($child,$childx);
        }
        $childx = array_merge($childx,$category);
        $data_child    = array_column($childx, 'data_id');
        $data_product = $this->_product->getDataProductByCategory($data_child);
        // dd($data_child);
        return $data_product;
    }

    //lấy all danh mục cấp 0 của menu vị trí số 4. rồi lấy all danh mục con của cái cấp 0 (1),lấy sp cua danh muc chỗ (1).
    public function category_product()
    {
        $data_store = [];
        $data_store['category'] = $category = $this->_menu->getMenuParent(0,4);
        if (!empty($category)) foreach ($category as $key => $value) {
            $child        = $this->_menu->getMenuParent($value->id,4);//lấy list menu có parent = $value->id
            $arr_child    = array_column($child, 'data_id');//id category con
            
            if (empty($arr_child)) {//nếu menu ý không có con thì lấy danh mục con trực tiếp của nó
                $child   = $this->_category->getCategoryChild($value->data_id);
                $arr_child    = array_column($child, 'id');//chỉ cần lấy danh mục con, vì là tab
            
            }

            if(!empty($arr_child)){
                foreach($arr_child as $key=>$value1){
                    $data_store['data_product'][$value->data_id][$key] = $this->_product->getDataProductByCategory($value1,8);//vì tab nên phải lấy sp đúng theo từng danh mục, chứ không gom 1 phát hết như ketsatgiadinh
                }
                
                $data_store['child_category'][$value->data_id] = $child;//danh mục con
            }
        }
        return $data_store;
    }

    
}

