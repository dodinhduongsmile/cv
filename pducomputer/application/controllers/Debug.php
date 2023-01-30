<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Debug extends Public_Controller
{
    protected $_data_category;
    protected $_data;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['category_model', 'post_model']);
        $this->_data = new Post_model();
        $this->_data_category = new Category_model();
    }

    public function cache(){
        $allCache = $this->cache->cache_info();
        echo "<ul>";
        if(!empty($allCache)) foreach ($allCache as $key => $item){
            $delete = "<a target='_blank' href='".base_url('debug/delete_cache?key='.$key)."'>Delete cache</a>";
            echo "<li>$key => $delete</li>";
        }
        echo "</ul>";
    }

    public function delete_cache_file($url = ''){
        if (empty($url)){
            $this->load->helper('file');
            $url = $this->input->get('url');
        }

        if(!empty($url)){
            $uri = str_replace(base_url(),'/',$url);
            if($this->output->delete_cache($uri)) echo 'Delete cache'.$uri."<br>";
            else  echo "$uri has been deleted !<br>";
        }else{
            if(delete_files(FCPATH . 'application' . DIRECTORY_SEPARATOR . 'cache')) die("Delete all page statistic success !");
            else  die("Delete all page statistic error !");
        }

    }

    public function delete_cache(){
        $key = $this->input->get('key');
        $key = str_replace(CACHE_PREFIX_NAME,'',$key);
        if(!empty($key)) {
            if($this->deleteCache($key)) die('Delete success !');
            else  die('Delete error !');
        }else{
            die('Not key => error !');
        }
    }

    public function update_cache(){
        $this->delete_cache_file(base_url());
        exit;
    }

    public function update_cache_home(){
        $this->delete_cache_file(base_url());
        exit;
    }

    public function update_cache_cate($slug){
        $this->delete_cache_file(base_url());
        exit;
    }


    public function update_cache_detail($id){
        $oneItem = $this->_data->get_post_by_id($id,true);
        $this->delete_cache_file(get_url_post($oneItem));
        exit;
    }

}

