<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends STEVEN_Model {

    public $table;
    public $table_detail;

    public function __construct() {
        parent::__construct();
        $this->table         = "order";
        $this->table_detail  = "order_detail";
        $this->product        = "product";
        $this->column_order  = array("$this->table.id",);
        $this->column_search = array('email','phone','address','code');
        $this->order_default = array("$this->table.id" => "desc");
    }


    public function _where_custom($args = array()){
        parent::_where_custom();
        extract($args);

        if(!empty($phone)) $this->db->where("$this->table.phone", $phone);

    }
/*lấy sản phẩm của đơn hàng*/
     public function getData_OrderDetail($where=[],$or_where=[])
    {
        
        $this->db->select('a.total_amount,b.quantity as quantity_order, b.subtotal as price_order,b.price,b.title,c.id,c.slug,c.thumbnail,c.guarantee');
        
        $this->db->from($this->table.' a');

        $this->db->join($this->table_detail.' b','a.id = b.order_id','left');
        $this->db->join($this->product.' c','c.id = b.product_id','left');
        if(!empty($where)){
            $this->db->where($where);
        }
        if(!empty($or_where)){
            $this->db->or_where($or_where);
        }
        
        $data = $this->db->get()->result();
       
        return $data;
    }

//danh sách sản phẩm theo list order_id
public function order_detail($order_id){
    $this->db->select('a.*,b.thumbnail,b.slug');

    $this->db->from($this->table_detail.' a');
    $this->db->join($this->product.' b','b.id=a.product_id');
    if(!empty($order_id)){$this->db->where_in('a.order_id',$order_id);}
    $this->db->order_by('a.order_id','desc');
    $q=$this->db->get()->result();
    return $q;
}
/*lấy đơn hàng bảo hành*/
 public function getData_bh($where,$or_where,$select = '*')
    {
        
            if(!empty($select)){$this->db->select($select);}
            
            $this->db->from($this->table);

            if(!empty($where)){
                $this->db->where($where);
            }
            if(!empty($or_where)){
                $this->db->or_where($or_where);
            }
            
            
            $data = $this->db->get()->result();
       
        return $data;
    }

    public function saveDataOrder($data)
    {
        $order = $data['order_info'];
        $orderDetail = $data['order_detail'];
        $orderDetailData = array();
        if ($this->db->insert($this->table, $order) == false) {
            log_message('info', json_encode($order));
            log_message('error', $this->db->error());
            return false;
        } else {
            $orderId = $this->db->insert_id();

            if (!empty($orderDetail)) foreach ($orderDetail as $item) {
                $orderDetailData['order_id']   = $orderId;
                $orderDetailData['product_id'] = !empty(strstr($item['id'],"_")) ? (int)str_replace(strstr($item['id'],"_"),"",$item['id']) : (int)$item['id'];
                $orderDetailData['quantity']   = $item['qty'];
                $orderDetailData['subtotal']      = $item['subtotal'];
                $orderDetailData['price']      = $item['price'];
                $orderDetailData['title']      = $item['name'];
                // dd($orderDetailData);
                if ($this->db->insert($this->table_detail, $orderDetailData) == false) {
                  log_message('info', json_encode($orderDetailData));
                  log_message('error', $this->db->error());
                  return false;
                }
            }
            return $orderId;
        }
    }


//lấy số lượng sản phẩm đặt hàng
    public function getSoldProduct($order_id)
    {
        $count = 0;
        $this->db->select('*');
        $this->db->from($this->table_detail);
        $this->db->where('order_id', $order_id);
        $data = $this->db->get()->result();
        if (!empty($data)) foreach ($data as $key => $value) {
            $count+= $value->quantity;
        }
        return $count;
    }
    

}