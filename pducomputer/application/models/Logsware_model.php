<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logsware_model extends STEVEN_Model
{
    public $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = "log_warehouse";
        $this->column_order = array("id", "ip", "action", "note", "user", "created_time");
        $this->column_search = array('note','user','action');
        $this->order_default = array("id" => "ASC");
    }

    public function _where_custom($args = array())
    {
        parent::_where_custom();
        extract($args);
    }

    
    // public function delete_loguser($tablename='')
    // {
    //     if ($tablename == '') {
    //         $tablename = $this->table;
    //     }
    //     $time = date('Y-m-d H:i:s', time()-2592000);
    //     $this->db->where('created_time <', $time);
    //     if(!$this->db->delete($tablename)){
    //         log_message('info', json_encode($tablename));
    //         log_message('error', json_encode($this->db->error()));
    //     }else{
    //         return true;
    //     }
    // }
}