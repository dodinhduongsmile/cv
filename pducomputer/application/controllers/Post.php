<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends Public_Controller
{
    protected $_post;
    protected $_all_category;
    protected $_category;

    public function __construct() {
        parent::__construct();
        
        $this->load->model(['post_model','category_model','search_model']);
        $this->_post = new Post_model();
        $this->_category = new Category_model();
        $this->_all_category = $this->_category->_all_category('post');

    }

    public function category($id,$page=1)
    {
        $data['oneItem']   = $oneItem = $this->_category->getByField('id',$id);
        if (empty($oneItem)) show_404();

        //lấy all id danh mục con cháu của danh mục -> lấy bài viết có các danh mục này
        $data['list_category'] = $listCateId1 = $this->_category->_recursive_child_id2($this->_all_category, $id);
        $listCateId = array_merge(array_column($listCateId1, 'id'),[$id]);
        $limit = 12;
        $data['list_post'] = $this->_post->getDataPostByCategory($listCateId,$page,$limit);
        
        $data['keysearch'] = $this->search_model->getkeySearch(6);
        // phân Trang
        $total = $this->_post->getTotalPostByCategory($listCateId);
        $this->load->library('pagination');
        $paging['base_url'] = get_url_category_post($oneItem,$page);
        $paging['first_url'] = get_url_category_post($oneItem);
        $paging['total_rows'] = $total;
        $paging['per_page'] = $limit;
        $this->pagination->initialize($paging);
        $data['pagination'] = $this->pagination->create_links();
        // end phân Trang

        // $this->breadcrumbs->push('Trang chủ', base_url());
        $this->_category->_recursive_parent($this->_all_category, $oneItem->id);
        if (!empty($this->_category->_list_category_parent)) foreach (array_reverse($this->_category->_list_category_parent) as $item) {
            $this->breadcrumbs->push($item->title, get_url_category_post($item));
        }
        $this->breadcrumbs->push($oneItem->title, get_url_category_post($oneItem));
        $data['breadcrumb'] = $this->breadcrumbs->show();

        $data['SEO'] = [
            'meta_title' => !empty($oneItem->meta_title) ? $oneItem->meta_title : '',
            'meta_description' => !empty($oneItem->meta_description) ? $oneItem->meta_description : '',
            'meta_keyword' => !empty($oneItem->meta_keyword) ? $oneItem->meta_keyword : '',
            'url' => get_url_category_post($oneItem),
            'is_robot' => !empty($oneItem->is_robot) ? $oneItem->is_robot : '',
            'image' => getImageThumb($oneItem->thumbnail, 600, 314),
        ];
        $layoutView = '';
        if (!empty($oneItem->layout)) $layoutView = '-' . $oneItem->layout;
        $data['main_content'] = $this->load->view($this->template_path . 'post/category', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }


    public function detail($id,$page=1)
    {
        // $this->load->helper('webcounter');
        $data['oneItem'] = $oneItem = $this->_post->getByField('id',$id);
        if (empty($oneItem)) show_404();
        $this->_post->update(['id'=>$id],['viewed'=>$oneItem->viewed+1]);
        
        // $data['category'] = $oneCategory = $this->_post->getByIdCategoryPost($id);//all category of post

        $this->_category->_recursive_child_id($this->_all_category, !empty($oneItem->category_id) ? $oneItem->category_id : '');

       $listCateId = $this->_category->_list_category_child_id;

        $data['list_post'] = $this->_post->getDataPostByCategorys($listCateId,4,'',['id'=>'RANDOM']);
        $data['list_backlink'] = $this->_post->getDataPostByCategorys($oneItem->category_id,4,'',['id'=>'asc']);

//product
        $this->load->model('product_model');
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


        // $this->breadcrumbs->push('Trang chủ', base_url());
        $this->_category->_recursive_parent($this->_all_category, $oneItem->category_id);
        if (!empty($this->_category->_list_category_parent)) foreach (array_reverse($this->_category->_list_category_parent) as $item) {
            $this->breadcrumbs->push($item->title, get_url_category_post($item));
        }
        $this->breadcrumbs->push($oneItem->title, get_url_post($oneItem));
        $data['breadcrumb'] = $this->breadcrumbs->show();
        
        $data['SEO'] = [
            'meta_title' => !empty($oneItem->meta_title) ? $oneItem->meta_title : '',
            'meta_description' => !empty($oneItem->meta_description) ? $oneItem->meta_description : '',
            'meta_keyword' => !empty($oneItem->meta_keyword) ? $oneItem->meta_keyword : '',
            'url' => get_url_post($oneItem),
            'is_robot' => !empty($oneItem->is_robot) ? $oneItem->is_robot : '',
            'image' => getImageThumb($oneItem->thumbnail, 600, 314),
        ];
        $data['comment_block'] = $this->comment("post",$id);
        $data['main_content'] = $this->load->view($this->template_path . 'post/detail', $data, TRUE);
        $this->load->view($this->template_main, $data);
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
