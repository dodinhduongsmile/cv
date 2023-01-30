<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups_model extends STEVEN_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "groups";

        $this->column_order = array("$this->table.id", "$this->table.id", "title", "$this->table.is_status", "$this->table.created_time", "$this->table.updated_time");
        $this->column_search = array("name");
        $this->order_default = array("$this->table.created_time" => "DESC");

    }

    public function _where_custom($args = array())
    {
        parent::_where_custom();
        extract($args);

        if (isset($is_status)) {
            $this->db->where("$this->table.is_status", $is_status);
        }
    }

    public function get_group_by_groupid($id)
    {
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_all_group()
    {
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result();
    }
}