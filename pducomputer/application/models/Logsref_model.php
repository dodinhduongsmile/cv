<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logsref_model extends STEVEN_Model
{
    public $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = "log_ref";
        $this->column_order = array("id");
        $this->column_search = array('note','user_id','type');
        $this->order_default = array("id" => "desc");
    }

    public function _where_custom($args = array())
    {
        parent::_where_custom();
        extract($args);
    }

    public function getDataLogref($userID,$page,$limit,$type='')
    {
        $this->db->select('*');
        $this->db->from($this->table);

        $offset = ($page - 1) * $limit;
        $this->db->limit($limit, $offset);
        $this->db->where('user_id',$userID);
        if(!empty($type)){
            $this->db->where('type',$type);
        }
        $this->db->order_by('id','desc');
        $data = $this->db->get()->result();
        return $data;
    }
//lay tổng sp theo danh mục
    public function getTotalLogref($userID,$type='')
    {
        $this->db->select('id');
        $this->db->from($this->table);
       
        $this->db->where('user_id',$userID);
        if(!empty($type)){
            $this->db->where('type',$type);
        }
        $data = $this->db->get()->num_rows();
        return $data;
    }

}