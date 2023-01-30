<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_type_model extends STEVEN_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "product_type";
        $this->column_order = array("$this->table.id", "$this->table.id", "title", "$this->table.is_status", "$this->table.created_time", "$this->table.updated_time");
        $this->column_search = array("title");
        $this->order_default = array("$this->table.created_time" => "DESC");

    }

    public function _where_custom($args = array())
    {
        parent::_where_custom();
        extract($args);

        if (isset($is_status)) $this->db->where("$this->table.is_status", $is_status);

        if (isset($keyword_search)) $this->db->like("$this->table.title", $keyword_search);

        if (isset($not_in)) $this->db->where_not_in("$this->table.id", $not_in);
    }
 public function _all_ProductType($updateCache = false){
        $key = '_all_ProductType';
        $data = $this->getCache($key);
        if(empty($data) || $updateCache == true){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where("$this->table.is_status",1);
            $data = $this->db->get()->result();
            $this->setCache($key,$data,60*60*24);
        }
        return $data;
    }
public function _recursive_child_type($all, $parentId = 0){
    $child_id= array();
    // $child_id[] = $parentId; //bật cái này thì mỗi id sẽ hiện 2 lần, vì nó add cả cha(bỏ, sau phải array_merge thêm id gốc vào)
    // $chid_id2 = array();
    if(!empty($all)) foreach ($all as $key => $item){
        if($item->parent_id == $parentId){
            $child_id[] = $item;
            // $chid_id2 = $this->_recursive_child_type($all, $item->id);
            //   if(!empty($chid_id2)){
            //     $child_id = array_merge($child_id,$chid_id2);
            //   } 
            unset($all[$key]);
        }
        
    }
    return $child_id;
}
    public function checkHref($href)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('crawler_href', $href);
        $query = $this->db->get()->row();
        return $query;
    }
//lấy all bản ghi ở product_type
    public function getDataProductType($where=array())
    {
        $key = 'LogoProductType';
        $data = $this->getCache($key);
        if(empty($data)){
            $this->db->select('id,title,slug,thumbnail');
            $this->db->from($this->table);
            $this->db->where('is_status', 1);
            if (!empty($where)){
                $this->db->where($where);
            }
            $this->db->order_by('order', 'asc');
            $data = $this->db->get()->result();
            $this->setCache($key,$data,360000);
        }
        return $data;
    }
//lấy list danh mục type con cấp 1 của nó.
    public function getDataproductChildType($parent_id)
    {
        $this->db->select('id,title,slug');
        $this->db->from($this->table);
        $this->db->where('parent_id', $parent_id);
        $this->db->order_by('order', 'asc');
        $query = $this->db->get()->result();
        return $query;
    }
    

}