<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Public_Controller
{
    protected $_product;
    protected $_product_type;
    protected $_category;
    protected $_key_history;
    protected $_order;

    public function __construct() {
        parent::__construct();
        
        $this->load->model(['product_model','product_type_model','category_model','order_model']);
        $this->_product      = new Product_model();
        $this->_category     = new Category_model();
        $this->_product_type = new Product_type_model();
        $this->_order        = new Order_model();
        $this->_all_category = $this->_category->_all_category('product');
        $this->_key_history  = 'history';
    }

    public function category($id,$page=1)
    {


        $data['oneItem']  = $oneItem = $this->_category->getByField('id',$id);

        /*check ở danh mục mobile sẽ hiện 1 cái filter khác
            - lấy được list danh mục các mobile
            - check xem danh mục đang vào có thuộc mobile hay không? in_array()
            - có thuộc thì load view filter của mobile (hoặc truyền dataattribute của mobile)
        */
        
        if($oneItem->layoutview == 'mobile'){
            $data['dataattribute'] = $this->_category->getDataAll(['is_filter'=>1,'is_status'=>1,'type_img'=>'attribute_mobile'],'attribute','title,content,slugattr',array('parent_id'=>'asc'));
        }else if($oneItem->layoutview == 'laptop'){
            $data['dataattribute'] = $this->_category->getDataAll(['is_filter'=>1,'is_status'=>1,'type_img'=>'attribute_laptop'],'attribute','title,content,slugattr',array('parent_id'=>'asc'));
        }else{//là phukien
            /*Vì có nhiều loại phụ kiện nên không get all thuộc tính như trên*/
            $this->load->model('attribute_model');
            $layoutattr = $oneItem->layout;//là danh mục thuộc tính cha cấp 0
            $attrChild = [];
            if(!empty($layoutattr)){
                $attrFilter = $this->attribute_model->getByField('slugattr',$layoutattr,'id');//cha
                $attrChild = $this->attribute_model->getDataAttribute('',["parent_id"=>$attrFilter->id]);
            }
            
            $data['dataattribute'] = $attrChild;
        }

        if (empty($oneItem)) show_404();
        $limit = 32;
        /*Danh sách cate con,cháu
        c1: $data['list_category'] = $list_category    = $this->_category->getCategoryChild($id);//con cap1
        $data['list_category'] = $list_category    = $this->_category->getAllCateByCate($id);//con,chau luon
        cách 2: chạy nhanh hơn
        */
        $data['list_category'] = $listCateId1 = $this->_category->_recursive_child_id2($this->_all_category, $id);//con,chau,chính nó luon
        $listCateId = array_merge(array_column($listCateId1, 'id'),[$id]);

        //lấy dữ liệu lọc theo giá 
        $price_from = $this->input->get("price_from");
        $price_to = $this->input->get("price_to");


        $data['list_product'] = $this->_product->getDataProductRelated($listCateId,'',$limit,$price_from,$price_to,'','',$page);

        // phân Trang
        $data['total'] = $total = $this->_product->getTotalProductRelated($listCateId,'',$price_from,$price_to);

        $this->load->library('pagination');
        $paging['base_url'] = get_url_category_product($oneItem,$page);
        $paging['first_url'] = get_url_category_product($oneItem);
        $paging['total_rows'] = $total;
        $paging['per_page'] = $limit;
        $this->pagination->initialize($paging);
        $data['pagination'] = $this->pagination->create_links();
        // end phân Trang
        // breadcrumbs
        // $this->breadcrumbs->push('Trang chủ', base_url());
        $this->_category->_recursive_parent($this->_all_category, $oneItem->id);
        if (!empty($this->_category->_list_category_parent)) foreach (array_reverse($this->_category->_list_category_parent) as $item) {
            $this->breadcrumbs->push($item->title, get_url_category_product($item));
        }
        $this->breadcrumbs->push($oneItem->title, get_url_category_product($oneItem));
        $data['breadcrumb'] = $this->breadcrumbs->show();
        // end breadcrumbs
        
        $data['SEO'] = [
            'meta_title' => !empty($oneItem->meta_title) ? $oneItem->meta_title : '',
            'meta_description' => !empty($oneItem->meta_description) ? $oneItem->meta_description : '',
            'meta_keyword' => !empty($oneItem->meta_keyword) ? $oneItem->meta_keyword : '',
            'url' => get_url_category_product($oneItem),
            'is_robot' => !empty($oneItem->is_robot) ? $oneItem->is_robot : '',
            'image' => getImageThumb($oneItem->thumbnail, 600, 314),
        ];
        $data['main_content'] = $this->load->view($this->template_path . 'product/category', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
    public function ajax_filter()
    {
        $page= !empty($this->input->get("page"))?$this->input->get("page"):1;

        $price_from = $this->input->get("price_from");
        $price_to = $this->input->get("price_to");
        $datafilter = $this->input->get("datafilter");

        $newlike = $this->input->get("newlike");

        $sortpdu= $this->input->get("sortpdu");
        $sortkey= $this->input->get("sortkey");
        $order = '';
        if(!empty($sortkey)){
            $order = array($sortkey=>$sortpdu);
        }

        $id= $this->input->get("id");

        $oneItem = $this->_category->getByField('id',$id);
        if (empty($oneItem)) show_404();
        $limit = 32;

        $this->_category->_recursive_child_id($this->_all_category, $id);
        $listCateId =  $this->_category->_list_category_child_id;

        $data['list_product'] = $this->_product->getDataProductRelated($listCateId,'',$limit,$price_from,$price_to,$datafilter,$order,$page,$newlike);

        // phân Trang
        $total = $this->_product->getTotalProductRelated($listCateId,'',$price_from,$price_to,$datafilter,$newlike);

        $this->load->library('pagination');
        $paging['base_url'] = get_url_category_product($oneItem,$page);
        $paging['first_url'] = get_url_category_product($oneItem);
        $paging['total_rows'] = $total;
        $paging['per_page'] = $limit;
        $this->pagination->initialize($paging);
        $data['pagination'] = $this->pagination->create_links();

      /*cách 2*/
        $html = $this->load->view($this->template_path . 'product/ajax_category', $data, TRUE);
        echo $html;
        exit();
        
    }

    public function product_type($id,$page=1)
    {
        $all_productType = $this->_product_type->_all_ProductType();

        $data['oneItem']  = $oneItem = $this->_product_type->getByField('id',$id);
        if (empty($oneItem)) show_404();
        //con cháu
        // $data['list_child']   = $this->_product_type->getDataproductChildType($id);
        $data['list_child'] = $listCateId1 = $this->_category->_recursive_child_id2($all_productType, $id);//con,chau
        $listTypeId = array_merge(array_column($listCateId1, 'id'),[$id]);

        //all thương hiệu có parent_id = 0
        // $data['list_type']   = $this->_product_type->getDataProductType(["parent_id"=>0]);
        $data['list_type']   = $this->_product_type->_recursive_child_type($all_productType,0);
   
        $limit = 32;
        $data['list_product'] = $this->_product->getDataProductTypeIn($listTypeId,'',$limit,$page);
        $data['total'] = $total = $this->_product->getTotalProductTypeIn($listTypeId,'');
        //phân trang
        $this->load->library('pagination');
        // $paging['base_url'] = get_url_product_type($oneItem,$page);
        $paging['base_url'] = get_url_product_type($oneItem,$page);
        $paging['first_url'] = get_url_product_type($oneItem);
        $paging['total_rows'] = $total;
        $paging['per_page'] = $limit;
        $this->pagination->initialize($paging);
        $data['pagination'] = $this->pagination->create_links();

        $data['SEO'] = [
            'meta_title' => !empty($oneItem->meta_title) ? $oneItem->meta_title : '',
            'meta_description' => !empty($oneItem->meta_description) ? $oneItem->meta_description : '',
            'meta_keyword' => !empty($oneItem->meta_keyword) ? $oneItem->meta_keyword : '',
            'url' => get_url_product_type($oneItem),
            'is_robot' => !empty($oneItem->is_robot) ? $oneItem->is_robot : '',
            'image' => getImageThumb($oneItem->thumbnail, 600, 314),
        ];
        $data['main_content'] = $this->load->view($this->template_path . 'product/product_type', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
    //ajax phân trang ở product type, js ở view
    public function ajaxpaginationtype()
    {
        $all_productType = $this->_product_type->_all_ProductType();

        $id= $this->input->get("id");
        $page= !empty($this->input->get("page"))?$this->input->get("page"):1;

        $price_from = $this->input->get("price_from");
        $price_to = $this->input->get("price_to");
        $newlike = $this->input->get("newlike");
        $sortpdu= $this->input->get("sortpdu");
        $sortkey= $this->input->get("sortkey");
        $order = '';
        if(!empty($sortkey)){
            $order = array($sortkey=>$sortpdu);
        }

        $data['oneItem']  = $oneItem = $this->_product_type->getByField('id',$id);
        if (empty($oneItem)) show_404();

        // $data['list_child']   = $this->_product_type->getDataproductChildType($id);
        $data['list_child'] = $listCateId1 = $this->_category->_recursive_child_id2($all_productType, $id);//con,chau
        $listTypeId = array_merge(array_column($listCateId1, 'id'),[$id]);

        $limit = 32;
        $data['list_product'] = $this->_product->getDataProductTypeIn($listTypeId,'',$limit,$order,$price_from,$price_to,$page,$newlike);
        $total = $this->_product->getTotalProductTypeIn($listTypeId,'',$price_from,$price_to,$newlike);
        //phân trang
        $this->load->library('pagination');
        $paging['base_url'] = get_url_product_type($oneItem,$page);
        $paging['first_url'] = get_url_product_type($oneItem);
        $paging['total_rows'] = $total;
        $paging['per_page'] = $limit;
        $this->pagination->initialize($paging);
        $data['pagination'] = $this->pagination->create_links();

        $html = $this->load->view($this->template_path . 'product/ajax_category', $data, TRUE);
        echo $html;
        exit();
    }

    public function detail($id)
    {
        //get item by id
        $data['oneItem']  = $oneItem = $this->_product->getByField('id',$id);
        if (empty($oneItem)) show_404();
        $this->update_history($id);
        $this->_product->update(['id'=>$id],['viewed'=>$oneItem->viewed+1]);

        //decode thuộc tính
        $data['oneItem']->attribute = json_decode($oneItem->attribute);
        $data['oneItem']->classify = json_decode($oneItem->classify);
       // dd($data['oneItem']->classify);

        //array danh muc cua sp
        $data['category'] = $oneCategory = $this->_product->getByIdCategoryProduct($id);
        //all id con,chau cua 1 danh muc
        // $this->_category->_recursive_child_id2($this->_all_category, !empty($oneCategory['0']->id) ? $oneCategory['0']->id : '');
        // //list id danh mục, con cháu và anh em của sp
        // $listCateId = array_merge($this->_category->_list_category_child_id,array_column($oneCategory, 'id'));

        $oneCategory = array_column($oneCategory, 'id');
        //sp cùng danh mục
        $data['list_related'] = $this->_product->getDataProductRelated($oneCategory,$id,10);
        //sp cùng thương hiệu 
        $data['product_type_related']  = !empty($oneItem->product_type_id) ? $this->_product->getDataProductType($oneItem->product_type_id,$id,7) : '';
        
        //danh mục thương hiệu
        $data['category_type'] = !empty($oneItem->product_type_id) ? $this->_product_type->getByField('id',$oneItem->product_type_id,'id,title,slug') : '';

        //sp đã xem()
        $history      = get_cookie($this->_key_history);
        $data_history = json_decode($history);
        $data['product_history']  = !empty($data_history) ? $this->_product->getDataProductHistory($data_history,$id) : '';
        
        // $this->breadcrumbs->push('Trang chủ', base_url());
        //begin breadcrumbs
        $this->_category->_recursive_parent($this->_all_category, $oneItem->category_id);
        if (!empty($this->_category->_list_category_parent)){
            $data['danhmuccha'] = $this->_category->_list_category_parent;
             foreach (array_reverse($this->_category->_list_category_parent) as $item) {
                $this->breadcrumbs->push($item->title, get_url_category_product($item));
            }
        }
        $this->breadcrumbs->push($oneItem->title, get_url_product($oneItem));
        $data['breadcrumb'] = $this->breadcrumbs->show();
        
        $data['SEO'] = [
            'meta_title' => !empty($oneItem->meta_title) ? $oneItem->meta_title : '',
            'meta_description' => !empty($oneItem->meta_description) ? $oneItem->meta_description : '',
            'meta_keyword' => !empty($oneItem->meta_keyword) ? $oneItem->meta_keyword : '',
            'url' => get_url_product($oneItem),
            'is_robot' => !empty($oneItem->is_robot) ? $oneItem->is_robot : '',
            'image' => getImageThumb($oneItem->thumbnail, 600, 314),
        ];

        $layoutView = '';
        if (!empty($oneItem->layout)){
            $layoutView = '-' . $oneItem->layout;
        }
        $data['comment_block'] = $this->comment("product",$id);
        $data['main_content'] = $this->load->view($this->template_path . 'product/detail'. $layoutView, $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    private function update_history($product_id)
    {
        $data = get_cookie($this->_key_history);
        if (!empty($data)) {
            $data = json_decode($data, true);
            array_push($data, $product_id);
            $data = array_unique($data);
            set_cookie($this->_key_history, json_encode($data), 24*60*60*120);
        } else {
            set_cookie($this->_key_history, json_encode([$product_id]), 24*60*60*120);
        }
    }

//ajax product in post detail
    public function ajaxProductInPost()
    {
        $id= $this->input->get("id");
        $page= !empty($this->input->get("page"))?$this->input->get("page"):1;


        $limit = 8;
        $data['list_product']  = $this->product_model->getDataProduct($page,$limit,'','');
         // // phân Trang
        $total = $this->product_model->getTotalProduct('','');
        $this->load->library('pagination');
        $paging['base_url'] = base_url("post/detail/{$id}/");
        $paging['first_url'] = base_url("post/detail/{$id}/1");
        $paging['total_rows'] = $total;
        $paging['per_page'] = $limit;
        $this->pagination->initialize($paging);
        $data['pagination'] = $this->pagination->create_links();

        $html = $this->load->view($this->template_path . 'product/ajax_category', $data, TRUE);
        echo $html;
        exit();
    }
/*
ajax_buildpc xử lý hiển thị thông tin sp, lọc ở trang build pc
 */
    public function ajax_buildpc()
    {
        $this->load->model('attribute_model');
        $page= !empty($this->input->get("page"))?$this->input->get("page"):1;

        $price_from = $this->input->get("price_from");
        $price_to = $this->input->get("price_to");
        $datafilter = $this->input->get("datafilter");

        $sortpdu= $this->input->get("sortpdu");
        $sortkey= $this->input->get("sortkey");
        $order = '';
        if(!empty($sortkey)){
            $order = array($sortkey=>$sortpdu);
        }
// dd($datafilter);
        $id= $this->input->get("id");
        $layout= $this->input->get("layout");

        $keyword= $this->input->get("keyword");
        $keyword = toSlug(xss_clean($keyword));

        $oneItem = $this->_category->getByField('id',$id,'id');
        if (empty($oneItem)) show_404();
        $limit = 15;

        $attrFilter = $this->attribute_model->getByField('slugattr',$layout,'id');
        $attrChild = $this->attribute_model->getDataAttribute('',["parent_id"=>$attrFilter->id]);
        $attr_nhasanxuat = $this->attribute_model->getDataAttribute('',['slugattr' => 'nha_san_xuat']);
        
        $data['list_attrFilter'] = array_merge($attr_nhasanxuat,$attrChild);


        $this->_category->_recursive_child_id($this->_all_category, $id);
        $listCateId =  $this->_category->_list_category_child_id;

        $data['list_product'] = $this->_product->getDataProductRelated($listCateId,'',$limit,$price_from,$price_to,$datafilter,$order,$page);

        // phân Trang
        $total = $this->_product->getTotalProductRelated($listCateId,'',$price_from,$price_to,$datafilter);

        $this->load->library('pagination');
        $paging['base_url'] = base_url("am_buildpc.html/{$page}");//lấy $page từ ajax rồi, nên link này cho đẹp thôi
        $paging['first_url'] = base_url("am_buildpc.html/");
        $paging['total_rows'] = $total;
        $paging['per_page'] = $limit;
        $this->pagination->initialize($paging);
        $data['pagination'] = $this->pagination->create_links();


        // $params = [
        //     'is_status'=> 1,
        //     // 'keyword' => $term,
        //     'limit'=> 50,
        //     'order' => array('created_time'=>'desc'),
        //     // 'in' => [$id,$title] | array($id,$title), ~ WHERE id IN ($id, $title), cái in ở trường nào thì chỉnh trong hàm _where_before
        //     // 'biggerandless' => ['price >' => $price1, 'price <' => $price2],
        // ];
        // $listdata = $this->_product->getDataSearch($params);

        
      /*cách 2*/
        $html = $this->load->view($this->template_path . 'page/ajax_buildpc', $data, TRUE);
        echo $html;
        exit();
        
    }
/*
comment modul
do duong 10/1/2023
*/
public function comment($type='',$target_id=''){
    $this->load->model('comment_model');
    $this->_comment = new Comment_model();

    $parent_id = 0;
    $data['limit'] = $limit = 4;
    //gọi view khi load trang
    $offset = 0;
    $data['list_comment'] =$list_comment = $this->_comment->getListCmt(["type"=>$type,"target_id"=>$target_id,"a.parent_id"=>$parent_id],$limit,$offset,true);
    //get total sub của  $list_idcmt, để hiển thị có bao nhiêu câu trả lời
    $html  = $this->load->view($this->template_path . 'block/comment', $data, TRUE);
    return $html;die();
}

}
