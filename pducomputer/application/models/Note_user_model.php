<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Note_user_model extends STEVEN_Model {
    public $table;

    public function __construct() {
        parent::__construct();
        $this->table = "note_user";
        $this->column_order = array("$this->table.id",);
        $this->column_search = array('title','slug');
        $this->order_default  = array("$this->table.user_id" => "ASC");
    }


    public function _where_custom($args = array()){
        parent::_where_custom();
        extract($args);
        if(!empty($type)) $this->db->where("$this->table.type", $type);
    }


    public function getNoteByEduId($id,$user_id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('id','desc');
        $this->db->where('id',$id);
        $query = $this->db->get()->result();
        return $query;
    }

}