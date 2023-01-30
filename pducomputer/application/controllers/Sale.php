<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends Public_Controller
{
    protected $_product;

    public function __construct() {
        parent::__construct();
        
    }
/*
-back friday
- khuyen mai, sale,,,
 */

   public function detail($id)
    {
        $this->load->model('Codesale_model');
        $this->_codesale = new Codesale_model();

        $data['oneItem'] = $oneItem = $this->_codesale->getById($id);
        if (empty($oneItem)) show_404();
       
        $this->breadcrumbs->push("khuyen-mai", base_url("vouchers_khuyen-mai.html"));
        $this->breadcrumbs->push($oneItem->title, get_url_codesale($oneItem));
        $data['breadcrumb'] = $this->breadcrumbs->show();

        $data['list_backlink'] = $this->_codesale->get_datapdu('',["is_status"=>1],5,0,['id'=>'RANDOM']);
        //product
        //sp đã xem()
        $this->load->model('product_model');
        $history      = get_cookie("history");
        $data_history = json_decode($history);
        $data['product_history']  = !empty($data_history) ? $this->product_model->getDataProductHistory($data_history,$id) : '';

        $data['SEO'] = [
            'meta_title' => !empty($oneItem->meta_title) ? $oneItem->meta_title : '',
            'meta_description' => !empty($oneItem->meta_description) ? $oneItem->meta_description : '',
            'meta_keyword' => !empty($oneItem->meta_keyword) ? $oneItem->meta_keyword : '',
            'url' => get_url_codesale($oneItem),
            'is_robot' => 1,
            'image' => getImageThumb($oneItem->thumbnail, 600, 314),
        ];
        $data['comment_block'] = $this->comment("sale",$id);
        $data['main_content'] = $this->load->view($this->template_path . 'post/detail_codesale', $data, TRUE);
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
