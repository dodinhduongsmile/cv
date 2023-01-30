<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends STEVEN_Model
{
    public $table;
    public $table_category;
    public $category;

    public function __construct()
    {
        parent::__construct();
        $this->table          = "product";
        // $this->table_type         = "product_type";
        $this->table_category = "product_category";
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
    
    public function getProduct2()
    {
        $this->db->select('id,title,region');
        $this->db->from($this->table2);
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
//join vào bảng trung gian, nhiều-nhiều, lấy all danh mục của sp $id 
    public function getSelect2Category($id)
    {
        $this->db->select("$this->table_category.category_id AS id, title AS text");
        $this->db->from($this->table_category);
        $this->db->join("category", "$this->table_category.category_id = category.id");
        $this->db->where($this->table_category . ".product_id", $id);
        $data = $this->db->get()->result();
        return $data;
    }
//lấy sản phẩm có price_sale !=0
    // public function getDataProductSale()
    // {
    //     $this->db->select('id,title,slug,thumbnail,price,price_sale,size,mass');
    //     $this->db->from($this->table);
    //     $this->db->where('is_status',1);
    //     $this->db->where('price_sale !=',0);
    //     $this->db->order_by('created_time','desc');
    //     $this->db->limit(8);
    //     $data = $this->db->get()->result();
    //     return $data;
    // }
//sp hot có is_featured = 1
    public function getDataProductHot($limit='')
    {
        $key = "cacheProductHot";
        $data = $this->getCache($key);
        if(empty($data)){
            $this->db->select('id,title,slug,thumbnail,price,price_sale');
            $this->db->from($this->table);
            $this->db->where('is_status',1);
            $this->db->where('is_featured',1);
            $this->db->order_by('id','RANDOM');
            if(!empty($limit)){
                $this->db->limit($limit);
            }
            $data = $this->db->get()->result();
            $this->setCache($key,$data,3600);
        }
        return $data;
    }
//lấy item theo list id danh mục sp. lấy all bản ghi ở table product
    public function getDataProductByCategory($array_category,$limit=0,$offset=0)
    {
        $data = [];
        if (!empty($array_category)) {
            $this->db->select('a.id,a.title,a.slug,a.thumbnail,a.price,a.price_sale,a.code');
            $this->db->from($this->table.' a');
            $this->db->join($this->table_category.' b','a.id = b.product_id');//điều kiện lọc là 'a.id = b.product_id'
            $this->db->where('a.is_status',1);
            $this->db->where_in('b.category_id',$array_category);
            $this->db->order_by('a.created_time','desc');
            // $this->db->order_by("FIELD(b.category_id,".join(',',$array_category).")");

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
    public function getDataProductByCategory1($array_category=[])
    {
        $data = [];

            $this->db->select('a.id,a.title,a.slug,a.thumbnail,a.price,a.price_sale,a.size,a.mass,b.category_id');
            $this->db->from($this->table.' a');
            $this->db->join($this->table_category.' b','a.id = b.product_id');//giống inner join, chỉ lấy bản ghi thỏa mãn đk lọc
            // $this->db->join($this->table_category.' b','a.id = b.product_id','left'); //left join, lấy all bản ghi ở product, và những bản ghi thỏa mãn đk ở product_category - không thỏa mãn thì nó hiện null, 
            $this->db->where('a.is_status',1);
            // $this->db->where_in('b.category_id',$array_category);//điều kiện category_id ở bảng product_category phải thuộc mảng $array_category | $array_category không đc trống, vì đó là điều kiện lọc,
            // $this->db->order_by("FIELD(b.category_id,".join(',',$array_category).")");

            $data = $this->db->get()->result();
        
        return $data;
    }

    //Lấy list danh mục sản phẩm theo id sp
    public function getByIdCategoryProduct($product_id)
    {
        $this->db->select('b.id,b.title,b.slug');
        $this->db->from($this->table_category.' a');
        $this->db->join($this->category.' b','a.category_id = b.id');
        $this->db->where('a.product_id',$product_id);
        $this->db->where('is_status',1);
        $data = $this->db->get()->result();
        return $data;
    }


//sp cùng danh mục
    public function getDataProductRelated($array_category,$not_id,$limit=8,$start_price=0,$end_price=0,$datafilter='',$order=array(),$page=1,$newlike='')
    {
        $this->db->select('a.id,a.title,a.slug,a.thumbnail,a.price,a.price_sale,a.code,a.guarantee,a.quality');
        $this->db->from($this->table.' a');
        $this->db->join($this->table_category.' b','a.id = b.product_id');
        if (!empty($array_category)) {
            $this->db->where_in('b.category_id',$array_category);
        }else{
            $this->db->order_by('a.id','desc');
        }

        if (!empty($order) && is_array($order)) {
            foreach ($order as $k => $v){
                $this->db->order_by($k, $v);
            } 
        }else{
            $this->db->order_by('b.category_id','asc');
            // $this->db->order_by("FIELD(b.category_id,".join(',',$array_category).")");
        }
        if($newlike != ''){
            $this->db->where('a.newlike', $newlike);
        }
        if(!empty($not_id)){
            $this->db->where_not_in('b.product_id',$not_id);
        }
        if(!empty($end_price)){
            $this->db->where('a.price >=',$start_price);
            $this->db->where('a.price <=',$end_price);
        } 
        if(!empty($datafilter) && is_array($datafilter)){
            // $this->db->group_start();
            foreach($datafilter as $i=>$item){
                $this->db->group_start();
                $this->db->like("a.attribute", $item);
                $this->db->or_like("a.title", $item);
                $this->db->group_end(); 
            }
            // $this->db->group_end();  
        }
        $this->db->where('is_status',1);
        $offset = ($page - 1) * $limit;
        $this->db->limit($limit, $offset);
        $this->db->distinct("a.id");
        $data = $this->db->get()->result();
        return $data;
    }
//tổng số bản ghi theo list danh mục, dùng để tính phân trang
    public function getTotalProductRelated($array_category,$not_id='',$start_price=0,$end_price=0,$datafilter='',$newlike='')
    {
        $this->db->select('a.id');
        $this->db->from($this->table.' a');
        $this->db->join($this->table_category.' b','a.id = b.product_id');
        $this->db->where_in('b.category_id',$array_category);
        if(!empty($not_id)) $this->db->where_not_in('b.product_id',$not_id);
        if(!empty($end_price)){
            $this->db->where('a.price >=',$start_price);
            $this->db->where('a.price <=',$end_price);
            // $this->db->where('is_filter',1);
        } 
        if(!empty($datafilter) && is_array($datafilter)){
            // $this->db->group_start();
            foreach($datafilter as $i=>$item){
                $this->db->group_start();
                $this->db->like("a.attribute", $item);
                $this->db->or_like("a.title", $item);
                $this->db->group_end(); 
            }
            // $this->db->group_end();  
        }
        if($newlike != ''){
            $this->db->where('a.newlike', $newlike);
        }
        $this->db->where('is_status',1);
        $this->db->distinct("a.id");
        $data = $this->db->get()->num_rows();
        return $data;
    }
//lấy sp có product_type_id = $product_type_id
    public function getDataProductType($product_type_id,$not_id,$limit=5)
    {
        $this->db->select('id,title,slug,thumbnail,price,price_sale,size,attribute');
        $this->db->from($this->table);
        $this->db->where('product_type_id',$product_type_id);
        if(!empty($not_id)) $this->db->where_not_in('id',$not_id);
        $this->db->where('is_status',1);
        $this->db->order_by('created_time','desc');
        $this->db->limit($limit);
        $data = $this->db->get()->result();
        return $data;
    }
//danh sách product có product_type = mảng giá trị, phân trang
    public function getDataProductTypeIn($product_type_id,$not_id,$limit=5,$order=array(),$start_price=0,$end_price=0,$page=1,$newlike='')
    {
        $this->db->select('id,title,slug,thumbnail,price,price_sale,attribute');
        $this->db->from($this->table);
        $this->db->where_in('product_type_id',$product_type_id);
        if(!empty($not_id)) $this->db->where_not_in('id',$not_id);
        $this->db->where('is_status',1);
        
        if(!empty($end_price)){
            $this->db->where('price >=',$start_price);
            $this->db->where('price <=',$end_price);
            // $this->db->where('is_filter',1);
        } 
        if (!empty($order) && is_array($order)) {
            foreach ($order as $k => $v){
                $this->db->order_by($k, $v);
            } 
        }else{
           $this->db->order_by("FIELD(product_type_id,".join(',',$product_type_id).")");
        }
        if($newlike != ''){
            $this->db->where('newlike', $newlike);
        }
        $offset = ($page - 1) * $limit;
        $this->db->limit($limit, $offset);
        $data = $this->db->get()->result();
        return $data;
    }
    public function getTotalProductTypeIn($product_type_id,$not_id,$start_price=0,$end_price=0,$newlike='')
    {
        $this->db->select('id');
        $this->db->from($this->table);
        $this->db->where_in('product_type_id',$product_type_id);
        if(!empty($not_id)) $this->db->where_not_in('id',$not_id);
        $this->db->where('is_status',1);
        if(!empty($end_price)){
            $this->db->where('price >=',$start_price);
            $this->db->where('price <=',$end_price);
            // $this->db->where('is_filter',1);
        }
        if($newlike != ''){
            $this->db->where('newlike', $newlike);
        }
        // $this->db->order_by("FIELD(product_type_id,".join(',',$product_type_id).")");
        $data = $this->db->get()->num_rows();
        return $data;
    }
//lấy sản phẩm trong lịch sử cũ, ví dụ ở controller home
    public function getDataProductHistory($product_arr_id,$not_id=[])
    {
        $product_arr_id = array_reverse($product_arr_id);
        $this->db->select('id,title,slug,thumbnail,price,price_sale,size,attribute');
        $this->db->from($this->table);
        $this->db->where_in('id',$product_arr_id);
        if(!empty($not_id)) $this->db->where_not_in('id',$not_id);
        $this->db->where('is_status',1);
        $this->db->order_by("FIELD(id,".join(',',$product_arr_id).")");
        $this->db->limit(10);
        $data = $this->db->get()->result();
        return $data;
    }
//lấy sp theo keyword search
    // public function getDataSearchProduct($keyword)
    // {
    //     $this->db->select('id,title,slug,thumbnail,price,price_sale,size,mass,attribute,countware,code');
    //     $this->db->from($this->table);
    //     $this->db->like('title',$keyword);
    //     $this->db->where('is_status',1);
    //     $this->db->order_by('created_time','desc');
    //     $this->db->limit(28);
    //     $data = $this->db->get()->result();
    //     return $data;
    // }
//lấy sp theo list danh mục hoặc không, để phân trang
    public function getDataProduct($page,$limit,$not_id_arr,$category_id)
    {
        $this->db->select('a.id,a.title,a.slug,a.thumbnail,a.price,a.price_sale,a.attribute');
        $this->db->from($this->table.' a');
        
        
        if(!empty($category_id)){
            $this->db->join($this->table_category.' b','a.id = b.product_id');
            $this->db->where_in('b.category_id',$category_id);
        }
        if(!empty($not_id_arr)) $this->db->where_not_in('a.id',$not_id_arr);
        $offset = ($page - 1) * $limit;
        $this->db->limit($limit, $offset);
        $this->db->where('a.is_status',1);
        $this->db->order_by('a.created_time','desc');
        $data = $this->db->get()->result();
        return $data;
    }
//lay tổng sp theo danh mục
    public function getTotalProduct($not_id_arr,$category_id)
    {
        $this->db->select('1');
        $this->db->from($this->table.' a');
       
        if(!empty($category_id)){
             $this->db->join($this->table_category.' b','a.id = b.product_id');
            $this->db->where_in('b.category_id',$category_id);
        }
        if(!empty($not_id_arr)) $this->db->where_not_in('a.id',$not_id_arr);
        $this->db->where('a.is_status',1);
        $data = $this->db->get()->num_rows();
        return $data;
    }

    public function getDataProductInBaoGia($arr_product_id)
    {
        $this->db->select('id,title,slug,thumbnail,price,price_sale,size,mass,attribute');
        $this->db->from($this->table);
        $this->db->where_in('id',$arr_product_id);
        $this->db->where('is_status',1);
        $this->db->order_by('created_time','desc');
        $data = $this->db->get()->result();
        return $data;
    }
//lấy data product
    public function getProduct($not_id_arr=[],$in_arr=[])
    {
        $this->db->select('id,title,price,price_sale,size,mass,thumbnail,slug,guarantee,code');
        $this->db->from($this->table);
        if(!empty($not_id_arr)) $this->db->where_not_in('id',$not_id_arr);
        if(!empty($in_arr)) $this->db->where_in('id',$in_arr);

        $this->db->where('is_status', 1);
        $result = $this->db->get()->result();
        return $result;
    }

}