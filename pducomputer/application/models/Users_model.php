<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends STEVEN_Model
{

    public $table_user_favourite;
    public $table_group;
    public $_data_user;

    public function __construct()
    {
        parent::__construct();
        $this->table = "users";

        $this->table_useredu = "edu_user";
        $this->table_user_favourite = "users_favourites";
        $this->table_group = "groups";
        $this->column_order = array("$this->table.id");
        $this->column_search = array("username","phone","email");
        $this->order_default = array("$this->table.id" => "DESC");
    }


    public function _where_custom($args = array())
    {
        parent::_where_custom();
        extract($args);
        if (!empty($group_id)) {/*lấy những user có group_id = $group_id*/
            $this->db->where_in("$this->table.group_id", $group_id);
        }
        if (isset($active)) {
            $this->db->where("$this->table.active", $active);
        }
        if (isset($lever)) {
            $this->db->where("$this->table.lever >", $lever);
        }
    }

    public function check_oauth($field, $oauth)
    {
        $this->db->where($field, $oauth);

        $tablename = $this->table;

        $this->db->select('1');
        return $this->db->get($tablename)->num_rows();
    }

    public function getUserByField($key, $value)
    {
        $this->db->select('*');
        $this->db->where($this->table . '.' . $key, $value);
        return $this->db->get($this->table)->row();
    }

    public function getSelect2Group($group_ids){
        $this->db->select("$this->table_group.id, title AS text");
        $this->db->from($this->table_group);
        if(is_array($group_ids)){$this->db->where_in("$this->table_group.id",$group_ids);
        }else{$this->db->where("$this->table_group.id",$group_ids);}

        $query = $this->db->get();
        return $query->result();
    }

    //user yêu thích cái sp gì thì lưu vào
    public function saveFavourite($user_id,$product_id){
        $data = [
            'account_id' => $user_id,
            'product_id' => $product_id
        ];
        if(!$this->save($data,$this->table_user_favourite)) return false;
        return true;
    }
    //lấy data yêu thích của user nào đó
    public function getDataIdFavourite($user_id){
        $params = [
            'account_id' => $user_id,
        ];
        return $this->getDataAll($params,$this->table_user_favourite);
    }

public function getAllUser($update_cache=false){
        $key = "getAllUser";
        $data = $this->getCache($key);
        if(empty($data) || $update_cache == true){
            $this->db->select('id,email,active,is_status,parent_id');
            $this->db->from($this->table);
            $this->db->where('active', 1);
            $data = $this->db->get()->result();
            $this->setCache($key,$data,3600);
        }
        return $data;
    }

public function getUserchild($ids=array()){
    $this->db->select('id,username,email,parent_id');
    $this->db->from($this->table);
    $this->db->where('active', 1);
    if(!empty($ids)){
        $this->db->where_in('parent_id',$ids);
    }
    
    $data = $this->db->get()->result();
    return $data;
}
/*chạy cái getUserchild() lâu thì dùng cái này get danh sách child của list ids
    -> lấy được thông tin child cấp 1, cấp 2 luôn trong 1 lần
    bảng ad có id = parent_id bảng b=> bảng b là con của a
*/
public function getchild2($ids){
       
    $this->db->select('a.id,b.id as child_id,b.email as child_email,b.parent_id as child_parent');
    $this->db->from($this->table.' a');
     $this->db->join($this->table.' b','a.id = b.parent_id', 'left');
    // $this->db->where('a.id', $id);

    $this->db->where_in('a.id',$ids);
    $data = $this->db->get()->result();

    return $data;
}

}