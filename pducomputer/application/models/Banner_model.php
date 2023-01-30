<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner_model extends STEVEN_Model {
    public $table;

    public function __construct() {
        parent::__construct();
        $this->table = "banner";
        $this->column_order = array("$this->table.id",);
        $this->column_search = array("title");
        $this->order_default = array("$this->table.id" => "ASC");
    }


    public function _where_custom($args = array()){
        parent::_where_custom();
        extract($args);
        if(!empty($type)) $this->db->where("$this->table.type", $type);

    }
//lay img type_img = $type
    public function getDataBanner($type='', $location=1)
    {
        $key = "cacheBanner_{$type}{$location}";
        $data = $this->getCache($key);
        if(empty($data)){
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where('is_status', 1);
            if(!empty($location)){$this->db->where('location', $location);}
            
            $this->db->where('type_img', $type);
            $this->db->order_by('order','desc');
            $data = $this->db->get()->result();
            $this->setCache($key,$data,36000);
        }
        return $data;
    }


}