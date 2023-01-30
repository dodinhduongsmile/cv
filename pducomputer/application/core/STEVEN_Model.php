<?php
defined('BASEPATH') or exit('No direct script access allowed');

class STEVEN_Model extends CI_Model
{
    public $table;
    public $primary_key;
    public $column_order;
    public $column_search;
    public $order_default;

    public $_controller;
    public $_method;
    public $_dbprefix;

    public $_args = array();
    public $where_custom;

    public function __construct()
    {
        parent::__construct();
        $this->_dbprefix = $this->db->dbprefix;
        $this->_controller = $this->router->fetch_class();
        $this->_method = $this->router->fetch_method();

        $this->table = strtolower(str_replace('_model', '', get_Class($this)));
        // echo $this->table;
        $this->primary_key = "$this->table.id";
        $this->column_order = array("$this->table.id", "$this->table.id", "title", "$this->table.is_status", "$this->table.updated_time", "$this->table.created_time");
        $this->column_search = array("title");
        $this->order_default = array("$this->table.created_time" => "DESC");

        //load cache driver
        if (CACHE_MODE == TRUE) $this->load->driver('cache', array('adapter' => CACHE_ADAPTER, 'backup' => 'file', 'key_prefix' => CACHE_PREFIX_NAME));

    }

    public function setCache($key, $data, $timeOut = 3600)
    {
        if (CACHE_MODE == TRUE) {
            if($data === null) $timeOut = 60*1;
            $this->cache->save($key, $data, $timeOut);
        }
    }

    public function getCache($key)
    {
        if (CACHE_MODE == TRUE) {
            return $this->cache->get($key);
        } else return false;
    }

    public function deleteCache($key = null)
    {
        if (CACHE_MODE == TRUE) {
            if (!empty($key)) return $this->cache->delete($key);
            else return $this->cache->clean();
        } else return false;
    }

    /*Hàm xử lý các tham số truyền từ Datatables Jquery . search ở cái ô tìm kiếm id="generalSearch" ở mỗi trang admin nè*/ 
    public function _get_datatables_query()
    {
        $query = $this->input->post('query');
        
        if (!empty($query['generalSearch'])) {
            $keyword = $query['generalSearch'];
            $fieldSearch = '';
            foreach ($this->column_search as $i => $item) {
                if ($i == 0) {
                    $this->db->group_start();
                    $this->db->like($item, $keyword, 'both', false);
                    $this->db->or_like($item, $keyword, 'both', false);
                } else {
                    $this->db->or_like($item, $keyword, 'both', false);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            
        }

        if ($this->input->post('sort')) {
            $sort = $this->input->post('sort');
            $this->db->order_by($sort['field'], $sort['sort']);
        }
    }

//ajax search, serach với nhiều tùy chọn
//điều kiện để truy vấn
    public function _where_before($args = array(), $typeQuery = false)
    {
        $page = 1;
        $limit = 10;
        extract($args);
        if ($typeQuery === 'count' && empty($search)){
            $this->db->select('id');
        }
        $this->db->from($this->table);
        if (isset($selectpdu)){
            $this->db->select($selectpdu);
        }

        if (isset($is_featured)){
            $this->db->where("$this->table.is_featured", $is_featured);
        }

        if (isset($is_status)){
            $this->db->where("$this->table.is_status", $is_status);
        }

        if (isset($whereall)){
            $this->db->where($whereall);
        }
        if (!empty($keyword)){
            $this->db->like("$this->table.title", $keyword);
        }

        if (!empty($type_img)){
           
            $this->db->where("$this->table.type_img", $type_img);
        }

        if (!empty($id)){
            $this->db->where("$this->table.id", $id);
        }

        if (!empty($post_id)){
            $this->db->where("$this->table.post_id", $post_id);
        }

        if (!empty($in)){
            $this->db->where_in("$this->table.id", $in);
        }

        if (!empty($or_in)){
            $this->db->or_where_in("$this->table.id", $or_in);
        }

        if (!empty($not_in)){
            $this->db->where_not_in("$this->table.id", $not_in);
        }

        if (!empty($or_not_in)){
            $this->db->or_where_not_in("$this->table.id", $or_not_in);
        }

        if (!empty($created_time)){
            $this->db->like("$this->table.created_time", $created_time);
        }

        if (!empty($author)){
            $this->db->where("$this->table.author", $author);
        }

        if (!empty($offset)){
            $this->db->offset($offset);
        }


        $this->_get_datatables_query();
        if(!empty($keywordpro)){//dùng column_search cài đặt ở model
            if(is_array($this->column_search)){
            $this->db->group_start();
                    foreach ($this->column_search as $i => $item) {
                        if ($i == 0) {
                            $this->db->like($item, $keywordpro, 'both', false);
                        } else {
                            $this->db->or_like($item, $keywordpro, 'both', false);
                        }
                    }
                 $this->db->group_end();   
            }
        }

        if ($typeQuery == false) {
            if (!empty($order) && is_array($order)) {
                foreach ($order as $k => $v)
                    $this->db->order_by($k, $v);
            }
            $offset = ($page - 1) * $limit;
            $this->db->limit($limit, $offset);
        }
    }

    public function _where_custom($args = array()) {
    }

    private function _where($args = array(), $typeQuery = null)
    {
        $this->_where_before($args, $typeQuery);
        $this->_where_custom($args);
    }

    /*
     * Lấy tất cả dữ liệu
     * */
    public function getAll($lang_code = null, $is_status = null)
    {
        $this->db->from($this->table);
        if (!empty($is_status)) $this->db->where("$this->table.is_status", $is_status);
        $query = $this->db->get();
        return $query->result();
    }


    /*
     * Đếm tổng số bản ghi
     * */
    public function getTotalAll($table = '')
    {
        if (empty($table)) $table = $this->table;
        $this->db->select('1');
        $this->db->from($table);
        return $this->db->count_all_results();
    }
//tổng số bản ghi theo đk mảng params
    public function getTotal($args = [])
    {
        $args = array_merge(['select' => 1], $args);
        $this->_where($args, "count");
        $this->db->group_by("$this->table.id");
        $query = $this->db->get();
        return $query->num_rows();
    }
    /*
    lấy data theo điều kiện $params rồi dùng extrac để lấy mảng điều kiện. Ô search cũng sẽ gọi vào đây
     */
    public function getData($args = array(), $returnType = "object")
    {
        $this->_where($args);
        $query = $this->db->get();
        if ($returnType !== "object") return $query->result_array(); //Check kiểu data trả về
        else return $query->result();

    }

    /*
     * Lấy dữ liệu theo điều kiện 1 trường = value nào đó
     * Truyền vào id
     * */

    public function getDataByField($field, $value, $select = '*')
    {
        $key = 'getDataByField_'.$field.$value.$this->table;
        $data = $this->getCache($key);
        if(empty($data)){
            $this->db->select($select);
            $this->db->from($this->table);
            $this->db->where("$this->table.$field", $value);
            $data = $this->db->get()->row();
            $this->setCache($key,$data,60*60);
        }
        return $data;
    }
//row() lấy 1 bản ghi đầu tiên, đk theo field
    public function getByField($field, $value, $select = '*', $tablename='')
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }
        
        $this->db->select($select);
        $this->db->from($tablename);
        $this->db->where("$tablename.$field", $value);
        $query = $this->db->get()->row();
        return $query;
    }
//lấy 1 item theo id
    public function getById($id, $select = '*', $tablename='') {
        if ($tablename == '') {
            $tablename = $this->table;
        }
        if(!empty($select)){
            $this->db->select($select);
        }
        
        $this->db->from($tablename);
        $this->db->where("id", $id);
        $query = $this->db->get()->row();
        return $query;
    }


//lấy 1 item theo slug
    public function getDataBySlug($slug, $select = '*') {

        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->where("$this->table.slug", $slug);
        $this->db->where("$this->table.is_status", 1);
        $query = $this->db->get()->row();
        return $query;
    }


//lấy 1 sản phẩm < id nào đó
    public function getPrevById($id, $select = '*', $lang_code = null)
    {

        $this->db->select($select);
        $this->db->from($this->table);

        $this->db->where("$this->table.id <", $id);
        $this->db->where("$this->table.is_status", 1);
        $this->db->order_by("$this->table.id", 'DESC');
        $query = $this->db->get();
        return $query->row();

    }
//lấy 1 sản phẩm > id nào đó
    public function getNextById($id, $select = '*', $lang_code = null)
    {

        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->where("$this->table.id >", $id);
        $this->db->where("$this->table.is_status", 1);
        $this->db->order_by("$this->table.id", 'ASC');
        $query = $this->db->get();
        return $query->row();
    }

// check tồn tại 1 trường nào đó trong bảng
    public function checkExistByField($field, $value, $tablename = '')
    {
        $this->db->select('1');
        if ($tablename == '') {
            $tablename = $this->table;
        }
        $this->db->from($tablename);
        $this->db->where($field, $value);
        $query = $this->db->get();
        return $query->num_rows() > 0 ? true : false;
    }

    public function getSelect2($ids)
    {
        $this->db->select("$this->table.id, title AS text");
        $this->db->from($this->table);
        if (is_array($ids)) $this->db->where_in("$this->table.id", $ids);
        else $this->db->where("$this->table.id", $ids);

        $query = $this->db->get();
        return $query->result();
    }

//lưu bản ghi, trả về id của bản ghi đc lưu
    public function save($data, $tablename = '')
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }

        if (!$this->db->insert($tablename, $data)) {
            log_message('info', json_encode($data));
            log_message('error', json_encode($this->db->error()));
            return false;
        }
        $id = $this->db->insert_id();
        return !empty($id) ? $id : $this->db->affected_rows();
    }

//lấy bản ghi theo mảng điều kiện, ví dụ $conditions = ['title'=>$title, 'price >' $price];
    public function search($conditions = null, $limit = 500, $offset = 0, $tablename = '')
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }
        if ($conditions != null) {
            $this->db->where($conditions);
        }

        $query = $this->db->get($tablename, $limit, $offset);

        return $query->result();
    }
//lấy 1 bản ghi đầu tiên
    public function single($conditions, $tablename = '')
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }
        $this->db->where($conditions);

        return $this->db->get($tablename)->row();
    }
//lấy all data
    public function getDataAll($conditions = [], $tablename = '', $select = '*',$order=array(),$getfirst=false,$limit='')
    {
        if (!empty($select)){
            $this->db->select($select);
        }else{
            $this->db->select('*');
        }
        if ($tablename == '') {
            $tablename = $this->table;
        }
        if (!empty($conditions)){
            $this->db->where($conditions);
        }

        if(!empty($order)&&is_array($order)){
            foreach ($order as $field => $val){
               $this->db->order_by($field,$val);
            }
        }else{
            $this->db->order_by('id','DESC');
        }
        if (!empty($limit)){
           $this->db->limit($limit);
        }
        if ($getfirst===true){
            return $this->db->get($tablename)->first_row();
        }else{
            return $this->db->get($tablename)->result();
        }

       
    }

//lấy bản ghi tổng quát
/*
        get_data('users',array('lever ='=>'0'),array('id'=>'esc'));//lấy all bản ghi có lever=0
        $getfirst có lấy bản ghi đầu tiên không?
        $limit=0 lấy bắt đầu từ hàng nào
        $offset=0 lấy bao nhiêu bản ghi
    */
    public function get_datapdu($select='*',$where=array(),$limit=0,$offset=0,$order=array('id'=>'asc'),$tablename='',$getfirst=false){
        if ($tablename == '') {
            $tablename = $this->table;
        }
        $this->db->from($tablename);
        if(!empty($select)){
           $this->db->select($select); 
        }
        
        if(is_array($where)&&!empty($where)){
            $this->db->where($where);
        }
        
        if(!empty($order)&&is_array($order)){
            foreach ($order as $field => $val){
               $this->db->order_by($field,$val);
            }
        }else{
            $this->db->order_by('id','DESC');
        }
        if ($limit){
            if ($offset){
                $this->db->limit($limit,$offset);
            }else{
                $this->db->limit($limit);
            }
        }

        if ($getfirst===true){
            return $this->db->get()->first_row();
        }else{
            return $this->db->get()->result();
        }
    }
//thêm bản ghi
    public function insert($data, $tablename = '')
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }
        $this->db->insert($tablename, $data);

        return $this->db->affected_rows();
    }


//thêm nhiều bản ghi cùng lúc, dùng trong nhiều- nhiều
    public function insertMultiple($data, $tablename = '')
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }
        $this->db->insert_batch($tablename, $data);

        return $this->db->affected_rows();
    }


//$this->db->update('mytable', $data, "id = 4");
    public function update($conditions, $data,$tablename = '' )
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }

        if (!$this->db->update($tablename, $data, $conditions)) {
            log_message('info', json_encode($conditions));
            log_message('info', json_encode($data));
            log_message('error', json_encode($this->db->error()));
            return false;
        }

        return true;
    }
//xóa bản ghi theo đk
    public function delete($conditions, $tablename = '')
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }
        $this->db->where($conditions);
        if (!$this->db->delete($tablename)) {
            log_message('info', json_encode($conditions));
            log_message('info', json_encode($tablename));
            log_message('error', json_encode($this->db->error()));
        }

        return $this->db->affected_rows();
    }
//xóa nhiều bản ghi cùng lúc
    public function deleteArray($field, $value = array(), $tablename = '')
    {
        if ($tablename == '') {
            $tablename = $this->table;
        }
        $this->db->where_in($field, $value);
        if (!$this->db->delete($tablename)) {//nếu k delete sẽ log lỗi
            log_message('info', json_encode($tablename));
            log_message('error', json_encode($this->db->error()));
        }

        return $this->db->affected_rows();
    }
//đếm số lượng bản ghi
    public function count($conditions = null, $tablename = '')
    {
        if ($conditions != null) {
            $this->db->where($conditions);
        }

        if ($tablename == '') {
            $tablename = $this->table;
        }
        $this->db->select('1');
        return $this->db->get($tablename)->num_rows();
    }



}
