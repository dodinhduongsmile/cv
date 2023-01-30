<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edu_model extends STEVEN_Model
{
    public $table_category;

    public function __construct()
    {
        parent::__construct();
        $this->table = "edu";
        $this->table_useredu = "edu_user";
        $this->table_category = "edu_category";
        $this->category       = "category";
        $this->column_order = array("$this->table.id");
        $this->column_search = array('title','code');
        $this->order_default = array("$this->table.id" => 'desc');
    }

    public function _where_custom($args = array())
    {
        parent::_where_custom();
        extract($args);

        if(isset($is_status)) $this->db->where("$this->table.is_status", $is_status);
    }

    //mua khóa học,liên kết user - edu
    public function saveUserEdu($data)
    {
        $tablename = $this->table_useredu;
        if (!$this->db->insert($tablename, $data)) {
            log_message('info', json_encode($data));
            log_message('error', json_encode($this->db->error()));
            return false;
        }
        $id = $this->db->insert_id();
        return !empty($id) ? $id : $this->db->affected_rows();
    }
    //quyền xem edu
    public function permission_edu($conditions)
    {
        $this->db->select('id');
        $this->db->from($this->table_useredu);
        $this->db->where($conditions);
        return $this->db->get()->num_rows();
    }

    public function checkHref($href)
    {
        $this->db->select('id');
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
        $this->db->where($this->table_category . ".edu_id", $id);
        $data = $this->db->get()->result();
        return $data;
    }

    //lấy sản phẩm trong lịch sử cũ, ví dụ ở controller home
    public function getDataEduHistory($edu_arr_id,$not_id=[])
    {
        $edu_arr_id = array_reverse($edu_arr_id);
        $this->db->select('id,title,slug,thumbnail,price,price_sale');
        $this->db->from($this->table);
        $this->db->where_in('id',$edu_arr_id);
        if(!empty($not_id)){$this->db->where_not_in('id',$not_id);}
        $this->db->where('is_status',1);
        $this->db->order_by("FIELD(id,".join(',',$edu_arr_id).")");
        $this->db->limit(10);
        $data = $this->db->get()->result();
        return $data;
    }
//lấy item theo list id danh mục cách 2 (dùng khi load more)
    public function getDataEduByCategorys($array_category,$not_id='',$limit=8,$offset=0,$order=array())
    {
            $this->db->select('a.id,a.title,a.slug,a.thumbnail,a.price,a.price_sale,a.code');
            $this->db->from($this->table.' a');
            $this->db->join($this->table_category.' b','a.id = b.edu_id');
            $this->db->where('a.is_status',1);
            $this->db->where_in('b.category_id',$array_category);
            if(!empty($not_id)) $this->db->where_not_in('b.edu_id',$not_id);
            if (!empty($order) && is_array($order)) {
                foreach ($order as $k => $v){
                    $this->db->order_by($k, $v);
                } 
            }else{
                $this->db->order_by('b.category_id','asc');
            }
            $this->db->distinct("a.id");
            if ($limit){
                if ($offset){
                    $this->db->limit($limit,$offset);
                }else{
                    $this->db->limit($limit);
                }
            }
            $data = $this->db->get()->result();

        return $data;
    }
//lấy bài post theo list id danh mục,tin tức liên quan, để phân trang
    public function getDataEduByCategory($array_category,$not_id='',$limit=8,$page=1,$order=array())
    {

        $this->db->select('a.id,a.title,a.slug,a.thumbnail,a.price,a.price_sale,a.code');
        $this->db->from($this->table.' a');
        $this->db->join($this->table_category.' b','a.id = b.edu_id');
        $this->db->where_in('b.category_id',$array_category);
        $this->db->where('a.is_status',1);
        if(!empty($not_id)) $this->db->where_not_in('b.edu_id',$not_id);
        if (!empty($order) && is_array($order)) {
            foreach ($order as $k => $v){
                $this->db->order_by($k, $v);
            } 
        }else{
            $this->db->order_by('b.category_id','asc');
        }

        $offset = ($page - 1) * $limit;
        $this->db->limit($limit, $offset);
        $this->db->distinct("a.id");
        $data = $this->db->get()->result();
        return $data;
    }

/*lấy tổng bản ghi theo mảng danh mục, phân trang*/
    public function getTotalEduByCategory($array_category)
    {
        $this->db->select('a.id');
        $this->db->from($this->table.' a');
        $this->db->join($this->table_category.' b','a.id = b.edu_id');
        $this->db->where('a.is_status',1);
        $this->db->where_in('b.category_id',$array_category);
        $this->db->distinct("a.id");
        $data = $this->db->get()->num_rows();
        return $data;
    }

    //lấy danh mục theo id bài post
    public function getCategoryByIdEdu($edu_id)
    {
        $this->db->select('b.id,b.title,b.slug');
        $this->db->from($this->table_category.' a');
        $this->db->join($this->category.' b','a.category_id = b.id');
        $this->db->where('a.edu_id',$edu_id);
        $this->db->where('is_status',1);
        $data = $this->db->get()->result();
        return $data;
    }

public function getDataEduBlog($limit=0,$offset=0)
    {

        $this->db->select('a.id,a.title,a.thumbnail,a.slug,a.content,a.listdrive,a.listyoutube,a.crawler_href,a.crawler_href2');

        $this->db->from($this->table.' a');
        $this->db->join($this->table_category.' b','a.id = b.edu_id');
        // $this->db->join($this->category.' c','b.category_id = c.id');
        $this->db->where('a.type',1);
        // $this->db->where('b.category_id !=',259);
        $this->db->order_by('a.id','asc');
         $this->db->distinct("a.id");
        if ($limit){
            if ($offset){
                $this->db->limit($limit,$offset);
            }else{
                $this->db->limit($limit);
            }
        }
        
        $data = $this->db->get()->result();
        return $data;
    }

    public function getDataEduBlog2($limit=0,$offset=0)
    {

        $this->db->select('a.id,a.title,a.thumbnail,a.slug,a.content,a.listdrive,a.crawler_href,a.description');

        $this->db->from($this->table.' a');
       
        $this->db->order_by('a.id','asc');

        if ($limit){
            if ($offset){
                $this->db->limit($limit,$offset);
            }else{
                $this->db->limit($limit);
            }
        }
        
        $data = $this->db->get()->result();
        return $data;
    }

}