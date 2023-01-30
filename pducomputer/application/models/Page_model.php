<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model extends STEVEN_Model
{
    public $table_category;

    public function __construct()
    {
        parent::__construct();
        $this->table = "page";
        $this->column_order = array("$this->table.id");
        $this->column_search = array("title");
        $this->order_default = array("$this->table.id" => "ASC");
    }

    public function _where_custom($args = array())
    {
        parent::_where_custom();
        extract($args);

        if(isset($is_robot)) $this->db->where("$this->table.is_robot", $is_robot);
    }
    public function get_page_by_id ($id) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $this->db->where('is_status', 1);
        return $this->db->get()->row();
    }
    public function getBySlug($slug, $select = '*') {

        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->where("slug", $slug);
        $this->db->where('is_status', 1);
        $query = $this->db->get();
        return $query->row();
    }
    public function slugToId($slug)
    {
        $this->db->select('id');
        $this->db->from($this->table);
        $this->db->where('slug', $slug);
        $data = $this->db->get()->row();
        return !empty($data) ? $data->id : null;
    }
    public function getDataPageAll($id)
    {
        $this->db->select('id,title,updated_time,slug');
        $this->db->from($this->table);
        $this->db->where_not_in('id', $id);
        $data = $this->db->get()->result();
        return $data;
    }
}