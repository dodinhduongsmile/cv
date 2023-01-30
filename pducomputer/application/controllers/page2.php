<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends Public_Controller
{
    protected $_page;
    protected $_product;
    protected $_key_bao_gia;
    protected $_all_category;
    protected $_category;

    public function __construct() {
        parent::__construct();
        
        $this->load->model(['page_model','product_model','category_model']);
        $this->_page         = new Page_model();
        $this->_product      = new Product_model();
        $this->_category     = new Category_model();
        $this->_all_category = $this->_category->_all_category('product');
    }

    public function index($slug)
    {
        
        $data['oneItem'] = $oneItem = $this->_page->getByField('slug',$slug);
        if (empty($oneItem)) show_404();
        
        // $this->breadcrumbs->push('Trang chủ', base_url());
        $this->breadcrumbs->push($oneItem->title, base_url().$oneItem->slug.".html");
        $data['breadcrumb'] = $this->breadcrumbs->show();

        $data['data'] = [];
        $data['SEO'] = [
            'meta_title' => !empty($oneItem->meta_title) ? $oneItem->meta_title : '',
            'meta_description' => !empty($oneItem->meta_description) ? $oneItem->meta_description : '',
            'meta_keyword' => !empty($oneItem->meta_keyword) ? $oneItem->meta_keyword : '',
            'url' => get_url_page($oneItem),
            'is_robot' => !empty($oneItem->is_robot) ? $oneItem->is_robot : '',
            'image' => getImageThumb($oneItem->thumbnail, 600, 314),
        ];
        $layoutView = '';
        if (!empty($oneItem->layout)) $layoutView = '-' . $oneItem->layout;
        $data['main_content'] = $this->load->view($this->template_path . 'page/index' . $layoutView, $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function print_bao_gia()
    {
        $data['vat'] = !empty($this->input->get('vat')) ? $this->input->get('vat') : '';
        if (!empty($this->session->userdata['in_bao_gia'])) {
            $id_bao_gia  = $this->session->userdata['in_bao_gia'];
            $data['data_arr_bg'] = json_decode($id_bao_gia);
        }
        echo $this->load->view($this->template_path . 'page/print_bao_gia' , $data, TRUE);
    }

    public function bao_gia($slug,$page = 1)
    {
        $data['oneItem'] = $oneItem = $this->_page->getByField('slug',$slug);
        if (empty($oneItem)) show_404();
        $limit       = 10;
        $not_id_arr  = [];

        if (!empty($this->session->userdata['in_bao_gia'])) {
            $id_bao_gia  = $this->session->userdata['in_bao_gia'];
            $data['data_arr_bg'] = json_decode($id_bao_gia);
            $not_id_arr = array_column($data['data_arr_bg'], 'id');
        }
        $data['page'] = $page;

        $data['category_id'] = $category_id = $this->input->get('category');
        $this->_category->_recursive_child_id($this->_all_category, !empty($category_id) ? $category_id : 102);
        $listCateId = $this->_category->_list_category_child_id;
        $data['list_product']  = $this->_product->getDataProduct($page,$limit,$not_id_arr,$listCateId);
        $this->_queue_select($this->_all_category);
        $data['list_category'] = $this->category_tree;
        // phân Trang
        $total = $this->_product->getTotalProduct($not_id_arr,$listCateId);
        $this->load->library('pagination');
        $paging['base_url'] = get_url_bao_gia($oneItem,$page);
        $paging['first_url'] = get_url_bao_gia($oneItem);
        $paging['total_rows'] = $total;
        $paging['per_page'] = $limit;
        $this->pagination->initialize($paging);
        $data['pagination'] = $this->pagination->create_links();
        // end phân Trang

        $data['SEO'] = [
            'meta_title' => !empty($oneItem->meta_title) ? $oneItem->meta_title : '',
            'meta_description' => !empty($oneItem->meta_description) ? $oneItem->meta_description : '',
            'meta_keyword' => !empty($oneItem->meta_keyword) ? $oneItem->meta_keyword : '',
            'url' => base_url("am_$slug.html"),
            'is_robot' => !empty($oneItem->is_robot) ? $oneItem->is_robot : '',
            'image' => getImageThumb($oneItem->thumbnail, 600, 314),
        ];
        $data['main_content'] = $this->load->view($this->template_path . 'page/index-buildpc', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function save_in_bao_gia()
    {
        $this->checkRequestPostAjax();
        $product_id   = $this->input->post('product_id');
        $data_product = getByIdProduct($product_id);
        $price        = $this->price_product($data_product);
        if (!empty($this->session->userdata['in_bao_gia'])) {
            $data = $this->session->userdata['in_bao_gia'];
            $data = json_decode($data, true);
            $check = false;
            if (!empty($data)) foreach ($data as $key => $value) {
                if ($value['id'] != $product_id) {
                    $check = true;
                }
            }
            if ($check == true) {
                array_push($data, [
                    'id' => $product_id,
                    'quantity' => 1,
                    'price' => $price
                ]);
            }
            $this->session->set_userdata('in_bao_gia', json_encode($data));
        } else {
            $arr[0] = [
                'id' => $product_id,
                'quantity' => 1,
                'price' => $price
            ];
            $this->session->set_userdata('in_bao_gia', json_encode($arr));
        }
        $data_mess = [
            'message' => 'Thành công',
            'type' => 'success'
        ];
        die(json_encode($data_mess));
    }

    public function remove_item_bao_gia()
    {
        $this->checkRequestPostAjax();
        $product_id   = $this->input->post('product_id');
        $total        = 0;
        if (!empty($this->session->userdata['in_bao_gia'])) {
            $data = $this->session->userdata['in_bao_gia'];
            $data = json_decode($data,true);
            if (!empty($data)) foreach ($data as $key => $value) {
                if ($value['id'] == $product_id) {
                    unset($data[$key]);
                }else{
                    $data_product = getByIdProduct($value['id']);
                    $price        = $this->price_product($data_product);
                    $total+=$price*$data[$key]['quantity'];
                }
            }
            $data = array_values($data);
            if (!empty($data)) {
                $this->session->set_userdata('in_bao_gia', json_encode($data));
            }else{
                $this->session->unset_userdata('in_bao_gia');
            }
        }
        $data_mess = [
            'message' => 'Thành công',
            'type' => 'success',
            'total' => number_format($total,0,'','.')
        ];
        die(json_encode($data_mess));
    }

    public function update_item_bao_gia($value='')
    {
        $this->checkRequestPostAjax();
        $product_id   = $this->input->post('product_id');
        $quantity     = $this->input->post('quantity');
        $total        = 0;
        $subtotal     = 0;
        if (!empty($this->session->userdata['in_bao_gia'])) {
            $data = $this->session->userdata['in_bao_gia'];
            $data = json_decode($data,true);
            if (!empty($data)) foreach ($data as $key => $value) {
                $data_product = getByIdProduct($value['id']);
                $price        = $this->price_product($data_product);
                if ($value['id'] == $product_id) {
                    $data[$key]['quantity'] = $quantity;
                    $subtotal = $price * $quantity;
                }
                $total += $price * $data[$key]['quantity'];
            }
            $this->session->set_userdata('in_bao_gia', json_encode($data));
        }
        $data_mess = [
            'message' => 'Thành công',
            'type' => 'success',
            'total' => number_format($total,0,'','.'),
            'subtotal' => number_format($subtotal,0,'','.')
        ];
        die(json_encode($data_mess));
    }

    public function price_product($data_product)
    {
        if (!empty($data_product->price) && !empty($data_product->price_sale)) {
            $price = $data_product->price_sale;
        }elseif(!empty($data_product->price) && empty($data_product->price_sale)){
            $price = $data_product->price;
        }else{
            $price = 0;
        }
        return $price;
    }

    public function _queue_select($categories, $parent_id = 0, $char = ''){
        if(!empty($categories)) foreach ($categories as $key => $item){
            if ($item->parent_id == $parent_id){
                $title = $item->title == 'Sản phẩm' ? 'Tất cả sản phẩm' : $item->title;
                $tmp['title'] = $parent_id ? '  |--'.$char.$title : $char.$title;
                $tmp['id'] = $item->id;
                $this->category_tree[] = $tmp;
                unset($categories[$key]);
                $this->_queue_select($categories,$item->id,$char.'--');
            }
        }
    }

    public function _404(){
        redirect('/','','301');
    }
    
    public function notfound(){
        $data['main_content'] = $this->load->view($this->template_path . 'page/_404', NULL, TRUE);
        $this->load->view($this->template_main, $data);
    }

}
