<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ware_import extends Admin_Controller
{
    protected $_data;
    protected $_product_type;
    protected $_user;
    protected $_store;
    protected $_logsware;

    public function __construct()
    {
        parent::__construct();
        //tải thư viện
        $this->load->model(['product_model','users_model','product_type_model','store_model','logsware_model']);
        $this->_data         = new Product_model();
        $this->_product_type = new Product_type_model();
        $this->_user         = new Users_model();
        $this->_store        = new Store_model();
        $this->_logsware        = new Logsware_model();
    }

    public function index(){
        $data['heading_title'] = "Quản lý nhập kho";
        $data['heading_description'] = "Danh sách sản phẩm";
        $data['main_content'] = $this->load->view($this->template_path . $this->_controller . DIRECTORY_SEPARATOR . 'index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function ajax_list(){
        $this->checkRequestPostAjax();
        $data = array();
        $pagination = $this->input->post('pagination');
        $page = $pagination['page'];
        $total_page = isset($pagination['pages']) ? $pagination['pages'] : 1;
        $limit = !empty($pagination['perpage']) && $pagination['perpage'] > 0 ? $pagination['perpage'] : 1;

        $queryFilter = $this->input->post('query');
        $params = [
            'page'          => $page,
            'limit'         => $limit,
            'whereall'     => ['is_status <'=>2],
            'order'         => array('id'=>'desc')
        ];
        if(isset($queryFilter['is_status']) && $queryFilter['is_status'] !== ''){
            $params = array_merge($params,['is_status' => $queryFilter['is_status']]);
        }

        $listData = $this->_data->getData($params);
        if(!empty($listData)) foreach ($listData as $item) {
            $dataUser = $this->_user->getByField('id',$item->user_id);//người tạo
            $row = array();
            $row['checkID']      = $item->id;
            $row['id']           = $item->id;
            $row['title']        = '<a href="'.get_url_product($item).'" target="_blank">'.$item->title.'</a>';
            $row['code']         = $item->code;
            $row['thumbnail']    = $item->thumbnail;
            $row['username']     = !empty($dataUser->username) ? $dataUser->username : '';
            $row['is_status']    = $item->is_status;
            $row['khochua']  = $item->khochua;
            $row['countware']      = $item->countware;
            $row['countsell']      = $item->countsell;
            $row['price']        = $item->price;
            $row['price_sale']   = $item->price_sale;
            $row['is_filter']    = $item->is_filter;
            $row['viewed']       = $item->viewed;
            $row['updated_time'] = $item->updated_time;
            $row['created_time'] = $item->created_time;
            $data[] = $row;
        }

        $output = [
            "meta" => [
                "page"      => $page,
                "pages"     => $total_page,
                "perpage"   => $limit,
                "total"     => $this->_data->getTotal($params),//tổng item theo params
                "sort"      => "asc",
                "field"     => "id"
            ],
            "data" =>  $data
        ];

        $this->returnJson($output);
    }
//load các bản ghi ở table hiện tại
   public function ajax_load(){
        $term = $this->input->get("q");
        $id = $this->input->get('id')?$this->input->get('id'):0;
        $params = [
            'is_status'=> 1,
            'not_in' => ['id' => $id],
            'keyword' => $term,// cái tên keyword này định nghĩa ở _where_before()
            'limit'=> 10
        ];
        $data = $this->_data->getData($params);
        $output = [];
        if(!empty($data)) foreach ($data as $item) {
            $output[] = ['id'=>$item->id, 'text'=>$item->title];
        }
        $this->returnJson($output);
    }

    public function ajax_add(){
        $this->checkRequestPostAjax();
        $data = $this->_convertData();
        dd($data);
        $data['is_status'] = 1;

        if($id = $this->_data->save($data)){
            $note   = 'Thêm sản phẩm có id là : '.$id;
            $this->addLogaction('sản phẩm',$data,$id,$note,'Add');
            $message['type'] = 'success';
            $message['message'] = "Thêm mới thành công !";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Thêm mới thất bại !";
        }
        $this->returnJson($message);
    }

    public function ajax_edit(){
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        if(!empty($id)){
            $output['data_info'] = $data_info = $this->_data->single(['id' => $id],$this->_data->table);
//             $output['data_category'] = $this->_data->getSelect2Category($id);//lấy danh mục theo id
//             $data_product_type = $this->_product_type->getByField('id',$data_info->product_type_id,'id,title as text');
//             $output['data_product_type'][] = !empty($data_product_type) ? $data_product_type : '';
// //thêm chọn kho chứa vào product
//             $data_warehouse = $this->_store->getByField('id',$data_info->warehouse,'id,title as text');
//             $output['data_warehouse'][] = !empty($data_warehouse) ? $data_warehouse : '';
            $data_khochua = $this->_store->getByField('id',$data_info->khochua,'id,title as text');
            $output['data_khochua'][] = !empty($data_khochua) ? $data_khochua : '';
            $output['edit'] = 'edit';

            $this->returnJson($output);
        }
    }

// chỉ dùng cho khi ấn add, vì nó check đc kho cũ, kho mới để cập nhật bản ghi mới hoặc update số lương. Khi sửa mà chọn kho mới thì nó insert bản ghi mới nv là lỗi.
     public function ajax_update(){//khi click btnsave,ấn submit sẽ chạy
        $this->checkRequestPostAjax();
        $data = $this->_convertData();//array
        
        $id = $data['id'];//id sp khi ấn submit
        $data_old = $this->_data->single(['id' => $id],$this->_data->table);//object, data cũ, update xong mới là data mới
        unset($data['category_id']);//xóa bỏ category_id khỏi mảng, vì category nó lưu ở bảng khác
       if(!empty($data['edit'])){
            //không trống $data['edit'] -> thực hiện update
            unset($data['edit']);//xóa bỏ $data['edit'] khỏi mảng update
            if($this->_data->update(['id' => $id],$data,$this->_data->table)){
                $note   = 'Update product có id là : '.$id;
                $this->addLogaction('product',$data_old,$id,$note,'Update');

                $notekho = "chỉnh sửa sản phẩm id: {$id} <br/> mã: {$data['code']} <br/> số lượng: {$data['countware']} <br/> Kho chứa ID: {$data['khochua']} ";
                $this->addLogWarehouse($data_old,$id,$notekho,"suasanpham");
                $message['type'] = 'success';
                $message['message'] = "Cập nhật thành công !";
            }else{
                $message['type'] = 'error';
                $message['message'] = "Cập nhật thất bại !";
            }
       }else{
        // trống $data['edit'] -> add hoặc update dựa vào chọn khochua
        unset($data['edit']);//xóa bỏ $data['edit'] khỏi mảng update
        unset($data['code']);//không cập nhật code mới, code này phải thêm ở bên product
        if($data_old->khochua == $data['khochua']){
            //cùng 1 kho chứa thì update
             $data["countware"] = $data_old->countware + $data["countware"];
            if($this->_data->update(['id' => $id],$data,$this->_data->table)){
                $note   = 'Update product có id là : '.$id;
                $this->addLogaction('product',$data_old,$id,$note,'Update');

    $notekho = "Nhập thêm sản phẩm id: {$id}<br/> mã: {$data['code']} <br/> số lượng: {$data['countware']} <br/> Kho chứa ID: {$data['khochua']} ";
                $this->addLogWarehouse($data_old,$id,$notekho,"nhapsanpham");
                $message['type'] = 'success';
                $message['message'] = "Cập nhật thành công !";
            }else{
                $message['type'] = 'error';
                $message['message'] = "Cập nhật thất bại !";
            }
        }else{
            //khác kho chứa insert bản ghi mới
            unset($data['id']);//bỏ data['id'] vì thêm mới nó tự động tăng id
            $data['code'] = $data_old->code;//vì ở trên unset, ở đây phải thêm code gốc vào. vì không cho chỉnh sửa code

            if($id = $this->_data->save($data)){
                $note   = 'Thêm sản phẩm có id là : '.$id;
                $this->addLogaction('sản phẩm',$data,$id,$note,'Add');

                $notekho = "Nhập thêm sản phẩm id: {$id}<br/> mã: {$data['code']} <br/> số lượng: {$data['countware']} <br/> Kho chứa ID: {$data['khochua']} ";
                $this->addLogWarehouse($data_old,$id,$notekho,"nhapsanpham");
                $message['type'] = 'success';
                $message['message'] = "Thêm mới thành công !";
            }else{
                $message['type'] = 'error';
                $message['message'] = "Thêm mới thất bại !";
            }
            // dd("insert");
        }
       }

        
        $this->returnJson($message);
    }

    public function ajax_update_field(){
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        $field = $this->input->post('field');
        $value = $this->input->post('value');
        $response = $this->_data->update(['id' => $id], [$field => $value]);
        if($response != false){
            $message['type'] = 'success';
            $message['message'] = "Cập nhật thành công !";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Cập nhật thất bại !";
        }
        $this->returnJson($message);
    }

    public function ajax_delete(){
        $this->checkRequestPostAjax();
        $ids = (int)$this->input->post('id');
        $response = $this->_data->update(['id' => $ids], ['is_status'=>2]);
        if($response != false){
            $notekho = "Kho Xóa sản phẩm id: {$ids}";
                $this->addLogWarehouse('',$ids,$notekho,"xoasanpham");

            $message['type'] = 'success';
            $message['message'] = "Xóa thành công !";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Xóa thất bại !";
            log_message('error',$response);
        }
        $this->returnJson($message);
    }

    private function _validation(){
        $this->checkRequestPostAjax();
        $rules = [
            [
                'field' => "title",
                'label' => "Tiêu đề",
                'rules' => "trim|required"
            ],[
                'field' => "khochua",
                'label' => "kho chứa",
                'rules' => "trim|required"
            ]
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == false) {
            $message['type'] = "warning";
            $message['message'] = "Vui lòng kiểm tra lại thông tin vừa nhập.";
            $valid = array();
            if(!empty($rules)) foreach ($rules as $item){
                if(!empty(form_error($item['field']))) $valid[$item['field']] = form_error($item['field']);
            }
            $message['validation'] = $valid;
            $this->returnJson($message);
        }
    }

    private function _convertData(){
        $this->_validation();
        $data = $this->input->post();
        return $data;
    }
}