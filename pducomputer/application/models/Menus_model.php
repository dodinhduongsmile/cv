<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus_model extends STEVEN_Model
{
    public $listmenu;
    public $list_nav_link;
    public $_data_menu;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'menus';

    }

    public function getAllMenu($update_cache=false){
        $key = "getAllMenu";
        $data = $this->getCache($key);
        if(empty($data) || $update_cache == true){
            $this->db->select('*');
            $this->db->from($this->table);
            $data = $this->db->get()->result();
            $this->setCache($key,$data,86400);
        }
        return $data;
    }

    public function getMenu($location, $parent_id = 0){
        $key = "_cache_menu_{$location}_{$parent_id}";
        $data = $this->getCache($key);
        if(empty($data)){
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where('location_id',$location);
            $query = $this->db->get();
            $data = $query->result_array();
            $this->setCache($key,$data,36000);
        }
        return $data;
    }
//lấy danh sách menu theo parent(lấy menu con)
    public function getMenuParent($parent_id = 0,$location=0){
        $this->_data_menu = $this->getAllMenu();
        $data_store = [];
        if (!empty($this->_data_menu)) foreach ($this->_data_menu as $key => $value) {
            if ($value->parent_id == $parent_id && $value->location_id == $location) {
                $data_store[] = $value;
            }
        }
        return $data_store;
    }

    public function get_all () {
        $key = "_cache_all_menu_setting";
        $data = $this->getCache($key);
        if (empty($data)) {
            $this->db->select('*');
            $this->db->from($this->table);
            $data = $this->db->get()->result();
            $this->setCache($key, $data, 36000);
        }
        return $data;

    }

    public function _recursive_menu ($all, $cat_id = 0){
        if (!empty($all)) foreach ($all as $key => $item) {
            if ($item->id == $cat_id) {
                $this->list_nav_link [] = $item;
                unset($all[$key]);
                $this->_recursive_menu($all, $item->parent_id);
            }
        }
    }

    // hiển thị dữ liệu
    public function listmenu($menu, $parent = 0) {
        foreach ($menu as $key => $row) {
            if ($row['parent_id'] == $parent)
            {
                $this->listmenu[] = array(
                    'id' => intval($row['id']),
                    'name' => $row['title'],
                    'class' => $row['class'],
                    'type' => $row['type'],
                    'order' => $row['order'],
                    'link' => ($row['link'] === '/') ? BASE_URL : ($row['link'] === '#' ? $row['link'] : BASE_URL . $row['link']),
                    'level' => intval($row['parent_id']),
                    'parent' => intval($row['parent_id']));
                $this->listmenu($menu, $row['id']);
                unset($menu[$key]);
                
            }
        }
    }


    public function saveMenu($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

}
