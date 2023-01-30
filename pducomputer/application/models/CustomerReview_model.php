<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerReview_model extends STEVEN_Model {
    public $table;

    public function __construct() {
        parent::__construct();
        $this->table = "customer_review";
        $this->column_order = array("$this->table.id",);
        $this->column_search = array("title");
        $this->order_default = array("$this->table.id" => "ASC");
    }


    public function _where_custom($args = array()){
        parent::_where_custom();
        extract($args);// biến mảng thành các biến là key và giá trị của biến = value
        if(!empty($type)) $this->db->where("$this->table.type", $type);

    }

    public function getDataCustomerReview()
    {
        $key = "cacheCustomerReview";
        $data = $this->getCache($key);
        if(empty($data)){
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where('is_status', 1);
            $this->db->order_by('order','asc');
            $data = $this->db->get()->result();
            $this->setCache($key,$data,3600);
        }
        return $data;
    }

}