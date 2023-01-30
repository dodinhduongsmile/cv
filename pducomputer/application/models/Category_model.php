<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends STEVEN_Model
{
    public $_list_category_child;
    public $_list_category_parent;
    public $_list_category_child_id;
    public $category_tree;
    private $table_post_cat;
    public function __construct(){
        parent::__construct();
        $this->table            = "category";
        $this->table_post_cat   = "post_category";
        $this->column_order     = array("$this->table.id", "$this->table.id", "title", "$this->table.is_status", "$this->table.created_time", "$this->table.updated_time");
        $this->column_search    = array("title","id");
        $this->order_default    = array("$this->table.id" => "ASC");

    }
    public function _where_custom($args = array()){
        parent::_where_custom();
        extract($args);
        if(!empty($type)) $this->db->where("$this->table.type", $type);
        if (!empty($parent_id)) $this->db->where("$this->table.parent_id",$parent_id);

        if(isset($is_robot)) $this->db->where("$this->table.is_robot", $is_robot);

    }
public function getAllCateByCate($id_cate)
{
    /*
    1.lấy danh mục con,cháu, chắt của 1 danh mục $id_cate nào đó. Lấy full dữ liệu, nếu muốn lấy mỗi id thì dùng _recursive_child_id (lấy luôn cả chính nó)
     */
    $category = [];
    $category_sub1 = array();
    $child = $this->getCategoryChild($id_cate);
    if(!empty($child)){
        foreach($child as $key => $value){
            $category[] = $value;
            if(!empty($this->getCategoryChild($value->id))){
                $category_sub1 = $this->getAllCateByCate($value->id);//lấy đến thằng cháu chắt luôn
                $category = array_merge($category,$category_sub1);
            }
        }
    }else{
        $category = $this->getCatById($id_cate);
    }
    return $category;
}
//lấy all danh mục theo type
    public function _all_category($type = '', $updateCache = false){
        $key = 'all_category_'.$type;
        $data = $this->getCache($key);
        if(empty($data) || $updateCache == true){
            $this->db->select("id,title,parent_id,type,is_status,is_featured,slug,description");
            $this->db->from($this->table);
            $this->db->where("$this->table.is_status",1);
            if(!empty($type)) $this->db->where("$this->table.type",$type);
            $data = $this->db->get()->result();
            $this->setCache($key,$data,60*60*24);
        }
        return $data;
    }

//đệ quy lấy danh mục con trực tiêp (con cấp 1) của thằng cấp 0, và 1 đời con (list_child) của thằng con cấp 1 nữa.
    public function getListRecursive($type, $parent_id = 0){
        $all = $this->_all_category($type);
        $data = [];
        if(!empty($all)) foreach ($all as $key => $item){
            if($item->parent_id == $parent_id){
                $tmp = $item;
                $tmp->list_child = $this->getListChild($all,$item->id);//lấy danh mục con trực tiếp của thằng cấp 0
                $data[] = $tmp;
            }
        }
        return $data;
    }

/*Đệ quy ngược lấy record parent id -> tìm danh mục cha cấp 0 của 1 danh mục có id =$id*/
    public function _recursive_one_parent($all, $id){
        if(!empty($all)) foreach ($all as $item){
            if($item->id == $id){
                if($item->parent_id == 0) return $item;
                else return $this->_recursive_one_parent($all, $item->parent_id);
            }
        }
    }
    /*Đệ quy lấy record parent id*/

/*Đệ quy lấy array list category con,cháu $all là all danh mục để lọc, $parentId là category cha*/
    public function _recursive_child($all, $parentId = 0){
        if(!empty($all)) foreach ($all as $key => $item){
            if($item->parent_id == $parentId){
                $this->_list_category_child[] = $item;
                unset($all[$key]);
                $this->_recursive_child($all, $item->id);
            }
        }
    }

/*Đệ quy lấy maps các ID cha của danh mục đó, để làm breccrum*/
    public function _recursive_parent($all, $cateId = 0){
        if(!empty($all)) foreach ($all as $key => $item){
            if($item->id == $cateId){
                $this->_list_category_parent[] = $item;
                unset($all[$key]);
                $this->_recursive_parent($all, $item->parent_id);
            }
        }
    }

/*Đệ quy lấy array list category có type=$type có parent_id = $parentId,-> lấy category con cấp 1*/
    public function getListChild($type,$parentId = 0){
        $all = $this->_all_category($type);
        $data = array();
        if(!empty($all)) foreach ($all as $key => $item){
            if($item->parent_id == $parentId){
                $data[] = $item;
            }
        }
        return $data;
    }

    public function getCateChild($all,$parentId = 0){

        $data = array();
        if(!empty($all)){
            foreach ($all as $key => $item){
            if($item->parent_id == $parentId){
                $data[$key] = $item;
            }
        }
        }
        return $data;
    }
    /*Đệ quy lấy array list category  con*/

/*Đệ quy lấy list category- $all,lấy các ID con và cháu của 1 danh mục có id=$parentId (đã kèm danh mục cha hiện tại)*/
    public function _recursive_child_id($all, $parentId = 0){
        $this->_list_category_child_id[] = (int)$parentId;
        if(!empty($all)) foreach ($all as $key => $item){

            if($item->parent_id == $parentId){
                $this->_list_category_child_id[] = (int) $item->id;
                unset($all[$key]);
                $this->_recursive_child_id($all, (int) $item->id);
            }
            
        }
        $this->_list_category_child_id = array_unique($this->_list_category_child_id);
    }

    public function _recursive_child_id2($all, $parentId = 0){
        $child_id= array();
        // $child_id[] = $parentId; //bật cái này thì mỗi id sẽ hiện 2 lần, vì nó add cả cha
        $chid_id2 = array();
        if(!empty($all)) foreach ($all as $key => $item){
            if($item->parent_id == $parentId){
                $child_id[] = $item;
                $chid_id2 = $this->_recursive_child_id2($all, $item->id);
                  if(!empty($chid_id2)){
                    $child_id = array_merge($child_id,$chid_id2);
                  } 
                unset($all[$key]);
            }
            
        }
        return $child_id;
    }
    /*Đệ quy lấy list các ID, dùng trong gọi list danh mục ở admin*/

    public function _queue_select($categories, $parent_id = 0, $char = ''){
        if(!empty($categories)) foreach ($categories as $key => $item)
        {
            if ($item->parent_id == $parent_id)
            {
                $tmp['title'] = $parent_id ? '  |--'.$char.$item->title : $char.$item->title;
                $tmp['id'] = $item->id;
                $tmp['thumbnail'] = $item->thumbnail;
                $this->category_tree[] = $tmp;
                unset($categories[$key]);
                $this->_queue_select($categories,$item->id,$char.'--');
            }
        }
    }


//lấy danh mục theo slug
    public function getBySlugCached($slug,$type=''){
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where('slug',$slug);
        if(!empty($type)) $this->db->where('type',$type);
        $data = $this->db->get()->row();
        return $data;
    }
//lấy item theo CategoryType
    public function getDataByCategoryType($allCategories, $type){
        $dataType = [];
        if(!empty($allCategories)) foreach ($allCategories as $key => $item){
            if($item->type === $type) $dataType[] = $item;
        }
        return $dataType;
    }

//lấy danh mục theo type
    public function getAllCategoryByType($type,$parent_id = 0){
        $this->db->from($this->table);
        $this->db->where([
            'type' =>$type,
            'parent_id' => $parent_id
        ]);
        $query = $this->db->get()->result();
        return $query;
    }


//lấy các danh mục con trực tiếp, của 1 danh mục
    public function getCategoryChild($id){
        $key = "getCategoryChild_{$id}";
        $data = $this->getCache($key);
        if(empty($data)){
            $this->db->select('id,title,slug,layout');
            $this->db->from($this->table);
            $this->db->where([
                'parent_id' => $id,
                'is_status' => 1
            ]);
            $this->db->order_by('order','asc');
            $data = $this->db->get()->result();
            $this->setCache($key,$data,60*60);

        }
        return $data;
    }
    //lấy cate theo id
    public function getCatById($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('is_status', 1);
        $this->db->where('id', $id);
        $query = $this->db->get()->result();
        return $query;
    }
    public function checkHref($href)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('crawler_href', $href);
        $query = $this->db->get()->row();
        return $query;
    }

    public function getDataGroupBy()
    {
        $this->db->select('type');
        $this->db->from($this->table);
        $this->db->group_by('type');
        $query = $this->db->get();
        return $query->result_array();
    }

//lấy các danh mục có parent_id= mảng nhiều ptu
    public function getDataCategoryProduct($ids=[])
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where_in('parent_id', $ids);
        $data = $this->db->get()->result();
        return $data;
    }
    
}