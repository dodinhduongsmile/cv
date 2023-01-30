<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Codesale_model extends STEVEN_Model {
    public $table;

    public function __construct() {
        parent::__construct();
        $this->table = "codesale";
        $this->column_order = array("$this->table.id",);
        $this->column_search = array('title','code');
        $this->order_default = array("$this->table.id" => "asc");
    }


    public function _where_custom($args = array()){
        parent::_where_custom();
        extract($args);
        if(!empty($type)) $this->db->where("$this->table.type", $type);

    }


    public function getDataCodesale()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('id','desc');
        $this->db->where('is_status',1);
        $query = $this->db->get()->result();
        return $query;
    }

}