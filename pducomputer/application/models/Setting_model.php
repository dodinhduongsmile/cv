<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends STEVEN_Model {
    public $table;
    
    public function __construct()
    {
        parent::__construct();
        $this->table = 'setting';
    }

    public function get_setting_by_key($key) {
        
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where('key_setting', $key);
            $data = $this->db->get()->row();
            
        return $data;
    }
    
   
}