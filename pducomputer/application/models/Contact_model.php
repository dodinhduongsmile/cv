<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends STEVEN_Model {
    public $table;

    public function __construct() {
        parent::__construct();
        $this->table = "contact";
        $this->column_order = array("$this->table.id",);
        $this->column_search = array('full_name','email','phone');
        $this->order_default = array("$this->table.id" => "ASC");
    }


    public function _where_custom($args = array()){
        parent::_where_custom();
        extract($args);
        if(!empty($type)) $this->db->where("$this->table.type", $type);

    }

}