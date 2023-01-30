<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends STEVEN_Model {
    public $table;

    public function __construct() {
        parent::__construct();
        $this->table = "search";
        $this->column_order = array("$this->table.id",);
        $this->column_search = array("title");
        $this->order_default = array("$this->table.id" => "ASC");
    }


//getdata theo keyword search fronend
    public function getDataSearchx($keyword,$tablename = '', $select = '*',$limit=20,$page=1)
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }
        if(!empty($select)){$this->db->select($select);}
        $this->db->like('slug',$keyword);
        if($tablename == 'product'){
            $this->db->or_like('attribute', $keyword);
        }
        
        $this->db->where('is_status',1);
        $offset = ($page - 1) * $limit;
        $this->db->limit($limit, $offset);
        
        return $this->db->get($tablename)->result();
    }
    public function getTotalDataSearch($keyword,$tablename = '')
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }
        $this->db->select('id');
        $this->db->like('slug',$keyword);
        if($tablename == 'product'){
            $this->db->or_like('attribute', $keyword);
        }
        $this->db->where('is_status',1);
        return $this->db->get($tablename)->num_rows();
    }
    public function getkeySearch($limit=0)
    {
        $this->db->select('id,title,slug,count,type');
        $this->db->from($this->table);
        if (!empty($limit)){
           $this->db->limit($limit);
        }
        $this->db->order_by('count','desc');
        $query = $this->db->get()->result();
        return $query;
    }


}