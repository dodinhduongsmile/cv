<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends Admin_Controller {

    protected $_data;
    protected $_pageModel;
    protected $_postModel;
    protected $_productModel;
    protected $_categoryModel;
    protected $_listMenu;
    protected $_product_type;

    public function __construct()
    {
        parent::__construct();
        //tải file ngôn ngữ
        //$this->lang->load('menu');
        $this->config->load('menus');
        $this->load->model(['menus_model','post_model','category_model','page_model','product_type_model']);
        $this->_data          = new Menus_model();
        $this->_post          = new Post_model();
        $this->_pageModel     = new Page_model();
        $this->_categoryModel = new Category_model();
        $this->_product_type  = new Product_type_model();
    }

    public function index()
    {
        $data['heading_title'] = "Cấu hình Menu";
        $data['heading_description'] = "Danh sách menu";

        $data['main_content'] = $this->load->view($this->template_path . $this->_controller . '/index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
    public function ajax_load(){
        $this->checkRequestPostAjax();
        $input = $this->input->post();
        $data['list_category_type'] = $groupCategory = $this->_categoryModel->getDataGroupBy();
        $data['list_category'] = $allCategory = $this->_categoryModel->getAll();
        if(!empty($groupCategory)) foreach ($groupCategory as $key) {
            $tmp[$key['type']] = $this->getCategoryByType($allCategory, $key['type']);
            $data['list'] =  $tmp;
        }
        $data['list_pages'] = $this->_pageModel->getAll();
        $data['list_product_type'] = $this->_product_type->getAll();
        $data['list_posts'] = $this->_post->getAll();
        $html =  $this->load->view($this->template_path . 'menus/_ajax_load_data', $data, TRUE);
        echo $html;
        exit();
    }

    public function ajax_load_menu(){
        $this->checkRequestPostAjax();
        $locationId = $this->input->post('location_id');
        $data = $this->_data->search(['location_id' => $locationId]);
        $this->listMenu($data, 0, $locationId);
        $this->returnJson($this->_listMenu);
        exit();
    }

    public function ajax_save_menu(){
        $this->checkRequestPostAjax();
        $menuLocation = $this->input->post('loc');
        $response = $this->input->post('s');
        $this->_data->delete(['location_id'=>$menuLocation]);
        if (is_array($response)) {
            $topmenusorder = 1;
            if(!empty($response)) foreach ($response as $key => $block) {
                $tmp['title'] = trim($block['label']);
                $tmp['class'] = trim($block['cls']);
                $tmp['data_id'] = trim($block['value']);
                $tmp['link'] = trim($block['link']);
                $tmp['order'] = $topmenusorder;
                $tmp['parent_id'] = 0;
                $tmp['location_id'] = $menuLocation;
                $menuid = $this->_data->saveMenu($tmp);
                if (!empty($block['children'])) {
                    $this->childsubmenus($menuid, $block['children'], $menuLocation);
                }
                $topmenusorder++;
            }
        }
        $this->_data->getAllMenu(true);
        echo 1;
        exit;
    }

    //-----------------------------------
    private function childsubmenus($menuid, $e, $menuLocation)
    {
        $topmenusorder = 1;
        foreach ($e as $key => $block) {
            $tmp['title'] = trim($block['label']);
            $tmp['class'] = trim($block['cls']);
            $tmp['data_id'] = trim($block['value']);
            $tmp['link'] = trim($block['link']);
            $tmp['order'] = $topmenusorder;
            $tmp['parent_id'] = $menuid;
            $tmp['location_id'] = $menuLocation;
            $menu = $this->_data->saveMenu($tmp);
            if (!empty($block['children'])) {
                $this->childsubmenus($menu, $block['children'], $menuLocation);
            }
            $topmenusorder++;
        }
    }

    private function listMenu($menu, $parent = 0,$locationId)
    {
        if(!empty($menu)) foreach ($menu as $row) {
            $row = (array) $row;
            if ($row['parent_id'] == $parent)
            {
                $this->_listMenu[] = array(
                    'id' => $row['id'],
                    'name' => $row['title'],
                    'class' => $row['class'],
                    'data_id' => $row['data_id'],
                    'link' => $row['link'],
                    'level' => $row['parent_id']);
                $this->listMenu($menu, $row['id'],$locationId);
            }
        }
    }
    private function getCategoryByType($all, $type){
        $data = [];
        if(!empty($all)) foreach ($all as $item){
            if($item->type === $type) $data[] = $item;
        }
        return $data;
    }
}