<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_edu_model extends STEVEN_Model {
    public $table;

    public function __construct() {
        parent::__construct();
        $this->table = "edu_user";
        $this->table_edu = "edu";
        $this->table_user = "users";
        $this->column_order = array("$this->table.id",);
        $this->column_search = array('user_id','edu_id');
        $this->order_default = array("$this->table.id" => "desc");
    }

    public function _where_custom($args = array()){
        parent::_where_custom();
        extract($args);
    }
    /*lấy thông tin edu và user từ id recond*/
    public function getAllinfo($id){
       
        $this->db->select('a.*,b.email as user_email, b.coin_total,c.title as edu_title,c.link_drive');
        $this->db->from($this->table.' a');
         $this->db->join($this->table_user.' b','a.user_id = b.id');
         $this->db->join($this->table_edu.' c','a.edu_id = c.id');
        $this->db->where('a.id', $id);
        $data = $this->db->get()->row();
        return $data;
    }

    //get list by user_id
    public function getEduByUser($user_id,$limit=0,$offset=0){
        $this->db->select('a.price,a.edu_id,a.user_id,a.price,a.is_status,a.created_time,c.title,c.slug,c.id');
        $this->db->from($this->table.' a');
         $this->db->join($this->table_edu.' c','a.edu_id = c.id');
        $this->db->where('a.user_id', $user_id);
        $this->db->order_by('id','DESC');
        if ($limit){
            if ($offset){
                $this->db->limit($limit,$offset);
            }else{
                $this->db->limit($limit);
            }
        }

        $data = $this->db->get()->result();
        return $data;
    }

}   