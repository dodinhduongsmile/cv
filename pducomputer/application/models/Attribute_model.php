<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attribute_model extends STEVEN_Model {
    public $table;

    public function __construct() {
        parent::__construct();
        $this->table = "attribute";
        $this->column_order = array("$this->table.id",);
        $this->column_search = array("title","content");
        $this->order_default = array("$this->table.id" => "ASC");
    }


    public function _where_custom($args = array()){
        parent::_where_custom();
        extract($args);
        if(!empty($type)) $this->db->where("$this->table.type", $type);

    }
//lay img type_img = $type
    public function getDataAttribute($type='',$where=[])
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('is_status', 1);
        
        if(!empty($type)){
            $this->db->where('type_img', $type);
        }
        if(!empty($where)){
             $this->db->where($where);
        }
         if(!empty($parent_id)){
            $this->db->where_in("$this->table.parent_id", $in);
        }

        $this->db->order_by('order','asc');
        $query = $this->db->get()->result();
        return $query;
    }


}