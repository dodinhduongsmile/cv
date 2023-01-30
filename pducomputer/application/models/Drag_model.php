<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drag_model extends STEVEN_Model {

    public $table;
    public $table_phim;

    public function __construct() {
        parent::__construct();
        $this->table         = "drag";
        $this->table_phim    = "phims";
    }

    public function getDataDrag($type){
        $this->db->from($this->table);
        $this->db->where('type',$type);
        $this->db->order_by('order','asc');
        $query = $this->db->get()->result();
        return $query;
    }

    public function getDataDragPhim($type,$update_cache = false){
        $key = "getDataDragPhim_{$type}";
        $data = $this->getCache($key);
        if(empty($data) || $update_cache == true){
            $this->db->select('b.id,b.title,b.slug,b.thumbnail,b.other_name');
            $this->db->from($this->table.' a');
            $this->db->join($this->table_phim.' b','b.id = a.phim_id');
            $this->db->where('a.type',$type);
            $this->db->where('b.is_status',1);
            $this->db->limit(15);
            $this->db->order_by('a.order','asc');
            $data = $this->db->get()->result();
            $this->setCache($key,$data,60*60);
        }
        return $data;
    }
    
}