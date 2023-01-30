<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Itme_model extends STEVEN_Model {
    public $table;

    public function __construct() {
        parent::__construct();
        $this->table = "itme";
    }


//lay img type_img = $type
    public function getDataItme($where=[],$order='')
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('is_status', 1);
        
        if(!empty($where)){
             $this->db->where($where);
        }
        if (!empty($order) && is_array($order)) {
            foreach ($order as $k => $v){
                $this->db->order_by($k, $v);
            } 
        }else{
            $this->db->order_by('trangthai','asc');
            $this->db->order_by('ngaynhan','desc');
        }
        
        $query = $this->db->get()->result();
        return $query;
    }


}