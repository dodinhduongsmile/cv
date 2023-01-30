<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment_model extends STEVEN_Model {
    public $table;

    public function __construct() {
        parent::__construct();
        $this->table = "comment";
        $this->table_user = "users";
        $this->column_order = array("$this->table.id",);
        $this->column_search = array('user_id','type');
        $this->order_default = array("$this->table.id" => "desc");
    }


    public function _where_custom($args = array()){
        parent::_where_custom();
        extract($args);
        if(!empty($type)) $this->db->where("$this->table.type", $type);

    }

/*
danh sách cmt
những cmt chỉ có user đăng nhập cmt mới đc gọi -> chỉ cho bình luận khi đã login
Nếu không login thì sẽ không dùng join nữa, mà khi đăng nhập sẽ lưu avatar, fullname lại
 */
public function getListCmt($where=[],$limit=10,$offset=0,$count_sub=false)
    {
        $this->db->select('a.id,a.content,a.file_attach,a.count_star,a.target_id,a.user_id,a.count_like,a.report,a.updated_time,b.fullname,b.avatar,b.lever');
        $this->db->from($this->table.' a');
        $this->db->join($this->table_user.' b','a.user_id = b.id');

        if(!empty($where)){
            $this->db->where($where);
        }
        $this->db->order_by('id','DESC');
        if ($limit){
            if ($offset){
                $this->db->limit($limit,$offset);
            }else{
                $this->db->limit($limit);
            }
        }
        if($count_sub){
            $data = $this->db->get()->result();
            foreach ($data as $row){
               $row->total_child = $this->count(['parent_id' => $row->id]);
            }
        }else{
            $data = $this->db->get()->result();
        }
        
        return $data;
    }


// public function getListCmtTotal(){
//     $sql = "select count(id) from st_edu";//^ 0.002000093460083
//     $query = $this->db->query($sql);
//     $data = $query->result();
//     return $data;
// }
// public function getListCmtTotal2(){
//     $this->db->select('id');//^ 0.003000020980835
//     $data = $this->db->get('st_edu')->num_rows();
//     return $data;
// }
// public function getListCmtTotal3(){
//     $this->db->select('id');//0.003000020980835
//     $data = $this->db->count_all_results('st_edu');
//     return $data;
// }
}