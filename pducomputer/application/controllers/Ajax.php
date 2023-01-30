<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Public_Controller {

	protected $_comment;

    public function __construct() {
        parent::__construct();
        $this->load->model('comment_model');
        $this->_comment = new Comment_model();
    }
/*
cuộn tới đâu load html tới đo
 */
public function ajax_load(){
    $data = $this->input->post();
    if(!empty($data['info'])){
        $view = $data['info'];
        if($view == "comment"){
            //load block comment, nghi ngờ ajax google không lấy được data, nên thôi
            $cmt_target_id = isset($data['cmt_target_id']) ? $data['cmt_target_id'] : "";
            $cmt_type = isset($data['cmt_type']) ? $data['cmt_type'] : "";
            $html = "";
            if(!empty($cmt_target_id)){
                $html = $this->comment($cmt_type,$cmt_target_id);
            }
            echo $html;
            die();
        }elseif($view == "post"){
            $data1['post'] = "con phò phương";
        }elseif($view == "sidebar_cateedu"){
            $_all_category = $this->_category->_all_category();
            $data1['view_cateedu'] =  $this->load->view($this->template_path . 'block/sidebar_cateedu', ['allcate'=>$_all_category], TRUE);
            $html = $this->load->view($this->template_path . 'block/'.$view, $data1, TRUE);
            echo $html;
            die();
        }

    }
}

public function ajax_update_field(){
        $this->checkRequestPostAjax();
        $table = $this->input->post('id');
        $id = $this->input->post('id');
        $field = $this->input->post('field');
        $value = $this->input->post('value');
        $response = $this->_comment->update(['id' => $id], [$field => $value],$table);
        if($response != false){
            $message['type'] = 'success';
            $message['message'] = "Cập nhật thành công !";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Cập nhật thất bại !";
        }
        $this->returnJson($message);
    }
//update trường vào table nào đó. order
 public function ajax_update_content(){
    $this->checkRequestPostAjax();
    $data = $this->input->post();

    $id = $data['id'];
    $table = $data['table'];
    unset($data['table']);
    if($this->_comment->update(['id' => $id],$data, $table)){
        $message['type'] = 'success';
        $message['message'] = "Thao tác thành công !";
    }else{
        $message['type'] = 'error';
        $message['message'] = "Thao tác thất bại !";
    }
    $this->returnJson($message);
}
//ajax gửi liên hệ, đăng ký nhận tin
public function ajaxsend_contact()
    {
        $this->load->model('contact_model');
        $this->_contact = new Contact_model();
        $this->checkRequestPostAjax();
        // dd($this->input->post());
        $rules = [
        	[
                'field' => "email",
                'label' => "email",
                'rules' => "trim|required|valid_email|min_length[2]"
            ]
        ];
        $data = $this->_convertData($rules);
        // dd($data);
        if($id = $this->_contact->save($data)){
            $message['type'] = 'success';
            $message['message'] = "Gửi thông tin thành công";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Gửi thông tin thất bại !!!";
        }
        $this->returnJson($message);
    }
//ajax quick view product
public function ajaxview_product()
    {
        $this->load->model('product_model');
        $id = $this->input->post("product_id");
        $data['product'] = $product = $this->product_model->getById($id);
        $data['product']->album = json_decode($product->album);
        $data['product']->attribute = json_decode($product->attribute);
        $html = $this->load->view($this->template_path . 'home/product1', $data, TRUE);
        echo $html;
        exit();
    }
//ajax kiểm tra bảo hành
public function Search_bh()
{
    $this->load->model('order_model');
    $term = $this->input->post("q");
    $listdata= $this->order_model->getData_bh(['code'=>$term],['phone'=>$term,'full_name'=>$term]);

    $output = [];
    if(!empty($listdata)) foreach ($listdata as $item) {
        $output[] = ['id'=>$item->id, 'code'=>$item->code, 'phone'=>$item->phone, 'full_name'=>$item->full_name, 'address'=>$item->address,'is_status'=>$item->is_status,'total_amount'=>$item->total_amount,'url_detail'=>base_url("cart/detail_order/").$item->code];
    }
    $this->returnJson($output);
}


//kiểm tra login mới cho cmt
public function check_logincmt(){
    $userpdu =$this->session->userdata();
    if (empty($userpdu['user_id'])) {
        $message['type'] = 'error';
        $message['message'] = "Muốn bình luận cần phải đăng nhập";
        die(json_encode($message));
    }
}


//ajax delete comment, xóa thì phải xóa cả con
public function delete_comment(){
    $this->checkRequestGetAjax();
    $id = $this->input->get('id');
    $data = $this->_comment->getById($id,"id,parent_id,file_attach");
    if($data->parent_id == 0){
        //delete cmt sub
        $this->_comment->delete(['parent_id'=>$id]);
        if(!empty($data->file_attach)){
            if(file_exists(PUBLIC_PATH.$data->file_attach)){
                @unlink(PUBLIC_PATH.$data->file_attach);
                @unlink(PUBLIC_PATH.getPathThumb($data->file_attach));
            }
        }
    }
    if($this->_comment->delete(['id' => $id])){
        $message['type'] = 'success';
        $message['message'] = "Xóa thành công";
    }else{
        $message['type'] = 'error';
        $message['message'] = "Thao tác thất bại !";
    }
    die(json_encode($message));
}
// ajax url_like_comment
public function like_cmt(){

    $this->checkRequestGetAjax();
    $id = $this->input->get('id');
    $comment = $this->_comment->getById($id,"id,count_like");

    if($this->_comment->update(['id' => $id],['count_like'=>$comment->count_like+1])){
        $message['type'] = 'success';
        $message['message'] = $comment->count_like+1;
    }else{
        $message['type'] = 'error';
        $message['message'] = "Thao tác thất bại !";
    }
    die(json_encode($message));
}
// ajax url_report_comment
public function report_cmt(){

    $this->checkRequestGetAjax();
    $id = $this->input->get('id');
    $comment = $this->_comment->getById($id,"id,report");
    
    if($this->_comment->update(['id' => $id],['report'=>$comment->report+1])){
        $message['type'] = 'success';
        $message['message'] = $comment->report+1;
    }else{
        $message['type'] = 'error';
        $message['message'] = "Thao tác thất bại !";
    }
    die(json_encode($message));
}
// ajax url_load_sub_comment
public function comment_sub(){
    /*comment sub*/

    $this->checkRequestPostAjax();
    $data = $this->input->post();
    $data['limit'] = $limit = 4;

    $target_id = $data['target_id'];
    $type = $data['type'];
    $offset = isset($data['offset']) ? $data['offset'] : 0;
    $parent_id = $data['parent_id'];

    $data['list_comment'] = $list_comment = $this->_comment->getListCmt(["type"=>$type,"target_id"=>$target_id,"a.parent_id"=>$parent_id],$limit,$offset);
    

    $html  = $this->load->view($this->template_path . 'block/load_comment_sub', $data, TRUE);


    $data_mess = [
        'html' => $html,
        'limit' => $limit
    ];
    die(json_encode($data_mess));
}
/*
comment modul
do duong 10/1/2023
*/
public function comment($type='',$target_id=''){

    $parent_id = 0;
    $data['limit'] = $limit = 4;

    if(isset($_POST['target_id'])){
        //ajax call
        $data = $this->input->post();

        $target_id = $data['target_id'];
        $type = $data['type'];
        $offset = isset($data['offset']) ? $data['offset'] : 0;
        $parent_id = isset($data['$parent_id']) ? $data['$parent_id'] : 0;

        $data['list_comment'] =$list_comment = $this->_comment->getListCmt(["type"=>$type,"target_id"=>$target_id,"a.parent_id"=>$parent_id],$limit,$offset,true);
        
        $html  = $this->load->view($this->template_path . 'block/load_comment', $data, TRUE);
        $data_mess = [
            'html' => $html,
            'limit' => $limit
        ];
        die(json_encode($data_mess));
    }else{
        //gọi view khi load trang
        $offset = 0;
        $data['list_comment'] =$list_comment = $this->_comment->getListCmt(["type"=>$type,"target_id"=>$target_id,"a.parent_id"=>$parent_id],$limit,$offset,true);
        //get total sub của  $list_idcmt, để hiển thị có bao nhiêu câu trả lời
        $html  = $this->load->view($this->template_path . 'block/comment', $data, TRUE);
        return $html;die();
    }
}

/*ajax_comment binh luan,edit,vote*/
public function ajax_comment(){

    $this->check_logincmt();
    $this->checkRequestPostAjax();
    $data = $this->input->post();
    if(isset($data['id_edit']) && $data['id_edit'] != 0){
        //update
        $id_edit = $data['id_edit'];
        $data_update['content'] = htmlentities($data['content']);
        if(isset($data['file'])){
             $data_update['file_attach'] = $data['file'];
        }
        if($this->_comment->update(['id' => $id_edit],$data_update)){
            $message['action'] = 'edit';
            $message['type'] = 'success';
            $message['message'] = "Thao tác thành công !";
            $message['content'] = $data['content'];
        }else{
            $message['type'] = 'error';
            $message['message'] = "Thao tác thất bại !";
        }
        $this->returnJson($message);
    }else{
        //insert
        $datasave['user_id'] = $user_id = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : NULL;
        $datasave['parent_id'] = isset($data['parent_id']) ? $data['parent_id'] : 0;

        $datasave['count_star'] = isset($data['count_star']) ? $data['count_star'] : 5;
        $datasave['target_id'] = $data['target_id'];
        $datasave['type'] = $data['type'];

        /*Khi đánh giá mới có file*/
        if(isset($data['file'])){
             $datasave['file_attach'] = $data['file'];
        }

        $datasave['content'] = htmlentities($data['content']);
        
        if($id = $this->_comment->save($datasave)){
            $message['action'] = 'add';
            $message['type'] = 'success';
            $info = [
                "id_comment"=>$id,
                "user_id" => $user_id,
                "content" => $datasave['content'],
                "fullname" => $this->session->userdata('fullname') ? $this->session->userdata('fullname') : "No Name",
                "avatar" => $this->session->userdata('avatar') ? $this->session->userdata('avatar') : "/images/user.png",
            ];

            $message['info'] = $info;
        }else{
            $message['type'] = 'error';
            $message['message'] = "Bình luận thất bại, có lỗi, liên hệ admin nhé !!!";
        }
        $this->returnJson($message);
    }
    
    
}
/*ajax_vote danh gia,binh luan
save file truoc, rồi mới lưu cmt đc, vì không chạy ajax cùng lúc đc.
*/
public function ajax_vote(){
    $this->check_logincmt();
    $this->checkRequestPostAjax();
    $id = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : "";
    
    $path = USER_PATH.'memberid_'.$id.'/';
    $path2 = "/uploads/memberpdu/memberid_".$id.'/';
    $config['upload_path'] = $path;
    $config['allowed_types'] = 'jpg|jpeg|png|JPG|JPEG|PNG';
    $config['max_size'] = '1000';
    $config['remove_spaces'] = false;
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    /*xoa avata cu*/
    if(!empty($_FILES)){
        $file = $_FILES['imagevote'];

        if ($file['name'] != '') {
            $type_file = pathinfo($file['name'], PATHINFO_EXTENSION);

            $type_image = explode(".", $file['name']);
            $a = $this->toSlug($type_image[0]);
            $file_name = $a.'.'.$type_file;
            $file['name'] =  $file_name;

            if(file_exists($path.'/'.$file_name))
            {
                @unlink($path.'/'.$file_name);
            }else{
                if(!is_dir($path)){//nếu path không exit thì tạo path
                    mkdir($path, 0755, TRUE);
                }
            }
            //upload
            if (!$this->upload->do_upload("imagevote")) {
                $message['type'] = 'error';
                $message['message'] = $this->upload->display_errors();
                
            } else {

                $upload = array('upload_data' => $this->upload->data());
                $url_image = $path2.$upload['upload_data']['file_name'];
                $message['file'] = $url_image;

                //begin resize
                $config['image_library'] = 'gd2';
                $config['source_image'] = $path.$upload['upload_data']['file_name'];//đường dẫn image đã upload
                $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = TRUE;
                $config['width']         = 150;//kích thước resize
                $config['height']       = 100;

                $this->load->library('image_lib', $config);//gọi hàm
                $this->image_lib->initialize($config);//lưu lại cái config mới này khi resize
                $this->image_lib->resize();//thực hiện resize
                 
            }
        }

    }
    $this->returnJson($message);
}
// ajax_upimage_user ở ghi chú khóa học
public function ajax_upimage_user(){
    $this->checkRequestPostAjax();
    $id = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 1;

    $path = USER_PATH.'memberid_'.$id.'/';
    $path2 = "/public/uploads/memberpdu/memberid_".$id.'/';
    $config['upload_path'] = $path;
    $config['allowed_types'] = 'jpg|jpeg|png|JPG|JPEG|PNG';
    $config['max_size'] = '1000';
    $config['remove_spaces'] = false;
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    /*xoa avata cu*/
    if(!empty($_FILES)){
        foreach($_FILES as $k => $v){

            if ($v['name'] != '') {
                $type_file = pathinfo($v['name'], PATHINFO_EXTENSION);

                $type_image = explode(".", $v['name']);
                $a = $this->toSlug($type_image[0]);
                $file_name = $a.'.'.$type_file;
                $v['name'] =  $file_name;

                if(file_exists($path.'/'.$file_name))
                {
                    @unlink($path.'/'.$file_name);
                }else{
                    if(!is_dir($path)){
                        mkdir($path, 0755, TRUE);
                    }
                }
                //upload
                if (!$this->upload->do_upload($k)) {
                    $message['type'] = 'error';
                    $message['message'] = $this->upload->display_errors();
                    
                } else {
                    
                    $upload = array('upload_data' => $this->upload->data());
                    $url_image = base_url().$path2.$upload['upload_data']['file_name'];
                    $message['file'][$k] = $url_image;
                     
                }
            }
        }
    }
    $this->returnJson($message);

}
    private function _validation($rules){
        $this->checkRequestPostAjax();

        
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

    private function _convertData($rules=array()){
        $this->_validation($rules);

        $data = $this->input->post();
        return $data;
    }

}

/* End of file Ajax.php */
/* Location: ./application/controllers/Ajax.php */