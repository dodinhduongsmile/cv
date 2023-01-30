<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends STEVEN_Model {
    public $table;

    public function __construct() {
        parent::__construct();
        $this->table = "customer";
        $this->column_order = array("$this->table.id",);
        $this->column_search = array('title');
        $this->order_default = array("$this->table.id" => "order");
    }


    public function _where_custom($args = array()){
        parent::_where_custom();
        extract($args);
        if(!empty($phone)) $this->db->where("$this->table.phone", $phone);

    }


    public function getDataCustomer()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('order','asc');
        $this->db->where('is_status',1);
        $query = $this->db->get()->result();
        return $query;
    }

}