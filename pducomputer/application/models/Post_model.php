<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends STEVEN_Model
{
    public $table_category;

    public function __construct()
    {
        parent::__construct();
        $this->table = "post";
        $this->table_category = "post_category";
        $this->category       = "category";
        $this->column_order = array("$this->table.id", "$this->table.id", "title", "$this->table.is_status", "$this->table.created_time", "$this->table.updated_time");
        $this->column_search = array('title','code','price');
        $this->order_default = array("$this->table.created_time" => 'desc');
    }

    public function _where_custom($args = array())
    {
        parent::_where_custom();
        extract($args);

        if(isset($is_status)) $this->db->where("$this->table.is_status", $is_status);
    }
    
    public function checkHref($href)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('crawler_href', $href);
        $query = $this->db->get()->row();
        return $query;
    }

    public function getSelect2Category($id)
    {
        $this->db->select("$this->table_category.category_id AS id, title AS text");
        $this->db->from($this->table_category);
        $this->db->join("category", "$this->table_category.category_id = category.id");
        $this->db->where($this->table_category . ".post_id", $id);
        $data = $this->db->get()->result();
        return $data;
    }

//lấy bài post theo list id danh mục,tin tức liên quan, để phân trang
    public function getDataPostByCategory($array_category,$page,$limit)
    {

        $this->db->select('a.id,a.title,a.slug,a.thumbnail,a.description,a.created_time');
        $this->db->from($this->table.' a');
        $this->db->join($this->table_category.' b','a.id = b.post_id');
        $this->db->where_in('b.category_id',$array_category);
        $this->db->where('a.is_status',1);
        $this->db->order_by('b.category_id','desc');
        // $this->db->order_by("FIELD(b.category_id,".join(',',$array_category).")");
        $offset = ($page - 1) * $limit;
        $this->db->limit($limit, $offset);
        $this->db->distinct("a.id");
        $data = $this->db->get()->result();
        return $data;
    }
//lấy item theo list id danh mục cách 2
    public function getDataPostByCategorys($array_category,$limit=0,$offset=0,$order=array())
    {
        $data = [];
        if (!empty($array_category)) {
            $this->db->select('a.id,a.title,a.slug,a.thumbnail,a.description,a.created_time');
            $this->db->from($this->table.' a');
            $this->db->join($this->table_category.' b','a.id = b.post_id');
            $this->db->where('a.is_status',1);
            $this->db->where_in('b.category_id',$array_category);
            $this->db->distinct("a.id");
            
            if (!empty($order) && is_array($order)) {
                foreach ($order as $k => $v){
                    $this->db->order_by($k, $v);
                } 
            }else{
                $this->db->order_by('b.category_id','asc');
            }
            if ($limit){
                if ($offset){
                    $this->db->limit($limit,$offset);
                }else{
                    $this->db->limit($limit);
                }
            }
            $data = $this->db->get()->result();
        }
        return $data;
    }

    public function getTotalPostByCategory($array_category)
    {
        $this->db->select('a.id');
        $this->db->from($this->table.' a');
        $this->db->join($this->table_category.' b','a.id = b.post_id');
        $this->db->where('a.is_status',1);
        $this->db->where_in('b.category_id',$array_category);
        $this->db->distinct("a.id");
        $data = $this->db->get()->num_rows();
        return $data;
    }

    //lấy danh mục theo id bài post
    public function getByIdCategoryPost($post_id)
    {
        $this->db->select('b.id,b.title,b.slug');
        $this->db->from($this->table_category.' a');
        $this->db->join($this->category.' b','a.category_id = b.id');
        $this->db->where('a.post_id',$post_id);
        $this->db->where('is_status',1);
        $data = $this->db->get()->result();
        return $data;
    }
//lấy bài post
    public function getDataPost($limit='')
    {
        $this->db->select('id,title,slug,thumbnail');
        $this->db->from($this->table);
        $this->db->where('is_status',1);
        $this->db->order_by('created_time','desc');
        if(!empty($limit)){
            $this->db->limit($limit);
        }
        $data = $this->db->get()->result();
        return $data;
    }

//1 bài hot có is_featured = 1
//     public function getDataPostHot_1()
//     {
//         $this->db->select('*');
//         $this->db->from($this->table);
//         $this->db->where('is_status',1);
//         $this->db->where('is_featured',1);

//         $this->db->order_by('created_time','desc');
//         $data = $this->db->get()->first_row();
//         return $data;
//     }

// //lấy 3 bài
//         public function getDataPost_3()
//     {
//         $this->db->select('*');
//         $this->db->from($this->table);
//         $this->db->where('is_status',1);
//         $this->db->order_by('created_time','desc');
//         $this->db->limit(3);
//         $data = $this->db->get()->result();
//         return $data;
//     }
}