<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edu extends Public_Controller
{

    protected $_all_category;
    protected $_key_historyedu;

    public function __construct() {
        parent::__construct();
        
        $this->load->model(['edu_model','category_model','users_model','note_user_model']);
        $this->_edu = new Edu_model();
        $this->_category = new Category_model();
        $this->_user     = new Users_model();
        $this->_note      = new Note_user_model();
        $this->_key_historyedu  = 'historyedu';

    }
    public function deletedata()
    {
        $this->db->truncate('comment');
        echo "xóa hết xong x";
    }
    public function updateedu()
    {
        /*
        update lại edu_category
        1. lấy all recound
        2. lấy all bản ghi có category_id = 1 -> update category_id new
         */
        // $list = $this->_edu->getupdate(["category_id"=>268]);
        // dd($list);
        $list = $this->_edu->update(["type"=>1],["type"=>0],"edu");
        echo "ok";
    }
     

    public function category($id,$page=1)
    {
        $this->_all_category = $this->_category->_all_category('edu');

        $data['oneItem']  = $oneItem = $this->_category->getByField('id',$id);

        if (empty($oneItem)) show_404();
        
        $limit = 20;
        $sortpdu= $this->input->get("sortpdu");
        $sortkey= $this->input->get("sortkey");
        $order = '';
        if(!empty($sortkey)){
            $order = array($sortkey=>$sortpdu);
        }

        // dd($this->input->get("page"));
        /*Danh sách cate con,cháu*/
        $data['list_category'] = $listCateId1 = $this->_category->_recursive_child_id2($this->_all_category, $id);//con,chau,chính nó luon
        $listCateId = array_merge(array_column($listCateId1, 'id'),[$id]);

        $data['list_product'] = $this->_edu->getDataEduByCategory($listCateId,'',$limit,$page,$order);
        // phân Trang
        $data['total'] = $total = $this->_edu->getTotalEduByCategory($listCateId);

        $this->load->library('pagination');

        $paging['base_url'] = get_url_category_edu($oneItem,$page);
        $paging['first_url'] = get_url_category_edu($oneItem);
        $paging['total_rows'] = $total;
        $paging['per_page'] = $limit;
        $this->pagination->initialize($paging);
        $data['pagination'] = $this->pagination->create_links();
        // end phân Trang
        // breadcrumbs
        // $this->breadcrumbs->push('Trang chủ', base_url());
        $this->_category->_recursive_parent($this->_all_category, $oneItem->id);
        if (!empty($this->_category->_list_category_parent)) foreach (array_reverse($this->_category->_list_category_parent) as $item) {
            $this->breadcrumbs->push($item->title, get_url_category_product($item));
        }
        $this->breadcrumbs->push($oneItem->title, get_url_category_product($oneItem));
        $data['breadcrumb'] = $this->breadcrumbs->show();
        // end breadcrumbs
        
        $data['SEO'] = [
            'meta_title' => !empty($oneItem->meta_title) ? $oneItem->meta_title : '',
            'meta_description' => !empty($oneItem->meta_description) ? $oneItem->meta_description : '',
            'meta_keyword' => !empty($oneItem->meta_keyword) ? $oneItem->meta_keyword : '',
            'url' => get_url_category_edu($oneItem),
            'is_robot' => !empty($oneItem->is_robot) ? $oneItem->is_robot : '',
            'image' => getImageThumb($oneItem->thumbnail, 600, 314),
        ];
        if(isset($_GET['page']) || isset($_GET['sortkey'])){
            // $id đã định nghĩ ở link router, phân trang xử lý ở hàm khác thì phải gửi id về nữa
            $html = $this->load->view($this->template_path . 'edu/ajax_category', $data, TRUE);
            echo $html;
            die();
        }else{
            //khi load lai trang
            $data['main_content'] = $this->load->view($this->template_path . 'edu/category', $data, TRUE);
            $this->load->view($this->template_main, $data);
        }
        
    }
    public function learnedu()
    {
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        $server = $this->input->post('server');

        $data1['oneItem']  = $oneItem = $this->_edu->getById($id,"id,slug,title,listdrive,listyoutube,type");
        
        $user_id = $this->session->userdata('user_id');
        $data1['auth_useredu'] = false;
        if(!empty($user_id)){
            $data1['note'] = $this->_note->single(['edu_id'=>$id,'user_id'=>$user_id]);
            $data1['auth_useredu'] = $this->_edu->permission_edu(['edu_id'=>$id,'user_id'=>$user_id]);
        }
        $data1['typevd'] = "";
        if($server == 2){
            if($oneItem->type > 1){//>1 da update yotube
                $data1['typevd'] = "yt";
                $data1['listdrive'] = json_decode($oneItem->listyoutube);
            }else{
                $data1['listdrive'] = json_decode($oneItem->listdrive);
            }
        }else{
            $data1['listdrive'] = json_decode($oneItem->listdrive);
        }

        $html = $this->load->view($this->template_path . 'edu/ajax_learnpdu', $data1, TRUE);
        echo $html;
        die();
    }
    //transfer_server chuyển server xem video
    public function transfer_server()
    {
        $this->checkRequestGetAjax();
        $server = $this->input->get('server');
        $id = $this->input->get('id');
        $data1['oneItem']  = $oneItem = $this->_edu->getById($id);

        $user_id = $this->session->userdata('user_id');
        $data1['auth_useredu'] = false;
        if(!empty($user_id)){
            $data1['note'] = $this->_note->single(['edu_id'=>$id,'user_id'=>$user_id]);
            $data1['auth_useredu'] = $this->_edu->permission_edu(['edu_id'=>$id,'user_id'=>$user_id]);
        }

        $data1['typevd'] = "";
        if($server == 2){
            $data1['typevd'] = "yt";
            $data1['listdrive'] = json_decode($oneItem->listyoutube);
        }else{
            $data1['listdrive'] = json_decode($oneItem->listdrive);
        }

        $html = $this->load->view($this->template_path . 'edu/listvideo', $data1, TRUE);
        echo $html;
        die();
    }
    public function detail($id)
    {
        
        $this->_all_category = $this->_category->_all_category('edu');
        
        //get item by id
        $data1['oneItem']  = $oneItem = $this->_edu->getByField('id',$id);
        if (empty($oneItem)) show_404();
        $this->update_history($id);
        $this->_edu->update(['id'=>$id],['viewed'=>$oneItem->viewed+1]);

        $user_id = $this->session->userdata('user_id');
        $data1['auth_useredu'] = false;
        if(!empty($user_id)){
            $data1['note'] = $this->_note->single(['edu_id'=>$id,'user_id'=>$user_id]);
            /*xu ly quyền edu - user*/
            $data1['auth_useredu'] = $this->_edu->permission_edu(['edu_id'=>$id,'user_id'=>$user_id]);

        }
    $data1['typevd'] = "";
    if(isset($_GET['server']) && $_GET['server'] == 2){
        if($oneItem->type > 1){//>1 da update yotube
            $data1['typevd'] = "yt";
            $data1['listdrive'] = json_decode($oneItem->listyoutube);
        }else{
            $data1['listdrive'] = json_decode($oneItem->listdrive);
        }
        $data1['listvideo'] = $this->load->view($this->template_path . 'edu/listvideo', $data1, TRUE);
    }else{
        $data1['listdrive'] = json_decode($oneItem->listdrive);
        $data1['listvideo'] = $this->load->view($this->template_path . 'edu/listvideo', $data1, TRUE);
    }
        
        // $data1['listvideo'] = $this->load->view($this->template_path . 'edu/ajax_learnpdu', $data1, TRUE);

        //list danh mục, cua sp
        $data1['category'] = $this->_edu->getCategoryByIdEdu($id);

        //sp cùng danh mục
        $data1['list_related'] = $this->_edu->getDataEduByCategory($oneItem->category_id,$id,10);

        //sp đã xem()
        $history      = get_cookie($this->_key_historyedu);
        $data_history = json_decode($history);
        $data1['product_history']  = !empty($data_history) ? $this->_edu->getDataEduHistory($data_history,$id) : '';
        
        // $this->breadcrumbs->push('Trang chủ', base_url());
        //begin breadcrumbs
        $this->_category->_recursive_parent($this->_all_category, $oneItem->category_id);
        if (!empty($this->_category->_list_category_parent)){
            $data1['danhmuccha'] = $this->_category->_list_category_parent;
             foreach (array_reverse($this->_category->_list_category_parent) as $item) {
                $this->breadcrumbs->push($item->title, get_url_category_edu($item));
            }
        }
        $this->breadcrumbs->push($oneItem->title, get_url_product($oneItem));
        $data1['breadcrumb'] = $this->breadcrumbs->show();
        
        $data['SEO'] = [
            'meta_title' => !empty($oneItem->meta_title) ? $oneItem->meta_title : '',
            'meta_description' => !empty($oneItem->meta_description) ? $oneItem->meta_description : '',
            'meta_keyword' => !empty($oneItem->meta_keyword) ? $oneItem->meta_keyword : '',
            'url' => get_url_product($oneItem),
            'is_robot' => !empty($oneItem->is_robot) ? $oneItem->is_robot : '',
            'image' => getImageThumb($oneItem->thumbnail, 600, 314),
        ];

        $data1['comment_block'] = $this->comment("edu",$id);
        $data['main_content'] = $this->load->view($this->template_path . 'edu/detail', $data1, TRUE);
        $this->load->view($this->template_main, $data);
    }

    /*ajax_note_edu update note*/
    public function ajax_note_edu(){
        $this->checkRequestPostAjax();
        $data = $this->input->post();
        $user_id = $this->session->userdata('user_id');
        $note = $this->_note->single(['edu_id'=>$data['edu_id'],'user_id'=>$user_id]);
        if(!empty($note)){
            //update
            $content = htmlentities($data['content']);

            if($this->_note->update(['id' => $note->id],['content'=>$content])){
                $message['type'] = 'success';
                $message['message'] = "Update thành công !";
            }else{
                $message['type'] = 'error';
                $message['message'] = "Update thất bại !";
            }
        }else{
            //insert
            $data['content'] = htmlentities($data['content']);
            $data['user_id'] = $user_id;
            if($id = $this->_note->save($data)){
                $message['type'] = 'success';
                $message['message'] = "Thêm mới thành công !";
            }else{
                $message['type'] = 'error';
                $message['message'] = "Thêm mới thất bại !";
            }
        }
        
        $this->returnJson($message);
    }
public function buyedu(){
    $this->load->model('Logsref_model');
    $this->_logref = new Logsref_model();
    $this->checkRequestPostAjax();
    $id = $this->input->post('id');
    /*
    - lấy item edu
    - check coin xem đủ tiền mua k
    + đủ: 
    _ cấp quyền liên kết user-edu
    _ trừ tiền
     */
    $item = $this->_edu->getById($id,"id,price,price_sale,is_free,link_drive,countsell");
    $user_id = $this->session->userdata('user_id');
    $user = $this->_user->getById($user_id,"id,coin_total,coin_lock,email");
    if(empty($user)){
        $message['type'] = 'error';
        $message['message'] = "Bạn cần phải đăng nhập tài khoản <a href='".base_url("user/login")."'>tại đây</a>";
    }else{
        //1.get price
        $price_coin = (int)$this->_settings_email->coin_price;
        if(!empty($item->price_sale) && $item->is_free != 1){
            $price = (int)$item->price_sale/$price_coin;
        }elseif(!empty($item->price) && $item->is_free != 1){
            $price = (int)$item->price/$price_coin;
        } else{
            $price = 0;
        }
        //2.check coin
        $coin_total = (int)$user->coin_total;
        if($coin_total >= $price){
            //2.1: xu ly tru tien
            $coin_total2 = $coin_total - $price ;
            if($this->_user->update(['id' => $user_id],['coin_total'=>$coin_total2])){
                $dtlogref = array(
                    'type'=>'delete_coin','user_id'=>$user_id,
                    'child_id'=>0,
                    'reward'=>$price,
                    'note' =>"User id = {$user_id}, -{$price} coin. Đăng ký khóa học id = {$id}"
                );
                $this->addLogRef($dtlogref);
            }
            //2.2: cấp quyền liên kết user-edu
            $data_edu_user = ["user_id"=>$user_id,"edu_id"=>$id,"price"=>$price,"is_status"=>1];
            if($id_useredu = $this->_edu->saveUserEdu($data_edu_user)){
                //update count sell
                $this->_edu->update(['id'=>$id],['countsell'=>$item->countsell+1]);
                //2.3 share file
                if(!empty($item->link_drive)){
                    $link_id = str_replace("/", "", strrchr($item->link_drive,"/"));
                    
                    if(stripos($user->email,"@gmail.com")){//không cùng gmail sẽ báo lỗi khi không gửi thông báo
                        $sendNotification = false;
                    }else{
                        $sendNotification = true;
                    }

                    $this->load->library('google_api');
                    $rediect_uri = GG_rediect;
                    $this->google_api->login($rediect_uri,'drive');
                    $sharedrive = $this->google_api->sharefile($user->email,$link_id,$sendNotification);
                    
                    if(!empty($sharedrive['id'])){//id là id share, id_permission
                        $this->_edu->update(['id' => $id_useredu],['is_status'=>2,"id_permission"=>$sharedrive['id']],"edu_user");
                    }
                }
                $message['type'] = 'success';
                $message['message'] = "Đăng ký thành công";
            }else{
                $message['type'] = 'error';
                $message['message'] = "Đăng ký thất bại. Vui lòng thử lại hoặc liên hệ Admin !";
            }
            
            
            
        }else{
            $message['type'] = 'error';
            $message['message'] = "Số COIN của bạn không đủ. Vui lòng nạp thêm <a href='".base_url("user/deposit_coin")."'>tại đây</a> !";
        }  
    }
     $this->returnJson($message);
    
}

public function file_drive()
    {
        dd($_SESSION['GOOGLE_ACCESS_TOKEN']);
        $this->load->library('google_api');
        // unset($_SESSION['GOOGLE_ACCESS_TOKEN']);
        // dd($_SESSION['GOOGLE_ACCESS_TOKEN']);
        //cách 1: login để lấy client rồi mới tạo service, phải đăng nhập
        $rediect_uri = "http://localhost/ctytoan/pducomputer/googleapp/file_drive";
        $this->google_api->login($rediect_uri,'drive');
        
        // $this->google_api->sharefile();

        $this->load->view($this->template_path . 'itme/app_googledrive',[], false);
        
    }

    private function update_history($edu_id)
    {
        $data = get_cookie($this->_key_historyedu);
        if (!empty($data)) {
            $data = json_decode($data, true);
            array_push($data, $edu_id);
            $data = array_unique($data);
            set_cookie($this->_key_historyedu, json_encode($data), 24*60*60*120);
        } else {
            set_cookie($this->_key_historyedu, json_encode([$edu_id]), 24*60*60*120);
        }
    }

    /*
     chuyển data edu sang pdusoft để học online
    */
    public function exportEduBlog($limit=0,$offset=0)
    {
        if(!empty($limit)){
            $listedu= $this->_edu->getDataEduBlog($limit,$offset);
        }else{
            $listedu= $this->_edu->getDataEduBlog();
        }
        if(!empty($listedu)){//thêm cate vào phần tử, vì sql join 3 bảng thì không distric được, vì 1item có nhiều danh mục, nên phải distric tránh trùng
            foreach($listedu as $item){
                $item->cateedu = $this->_edu->getByIdCategoryPost($item->id);
                $item->listdrive = json_decode($item->listdrive,true);
                $item->listyoutube = json_decode($item->listyoutube,true);
            }

            $data['listedu'] = $listedu;
        }

        // $datamain['main_content'] = $this->load->view($this->template_path . 'edu/exportblog', $data, TRUE);
        $this->load->view($this->template_path . 'edu/exportblog', $data);
        // echo htmlentities($datamain['main_content']);die();
        // $this->load->view($this->template_main, $datamain);
    }

/*
     chuyển data cạo ở unica sang blogspot ở nhangheohocchui
    */
    public function blogunica($limit=0,$offset=0)
    {

        if(!empty($limit)){
            $listedu= $this->_edu->getDataEduBlog2($limit,$offset);
        }else{
            $listedu= $this->_edu->getDataEduBlog2();
        }
// dd($listedu);
        if(!empty($listedu)){//thêm cate vào phần tử, vì sql join 3 bảng thì không distric được, vì 1item có nhiều danh mục, nên phải distric tránh trùng
            foreach($listedu as $item){
                $item->cateedu = $this->_edu->getByIdCategoryPost($item->id);
                $item->listdrive = json_decode($item->listdrive,true);
            }

            $data['listedu'] = $listedu;
        }

        // $datamain['main_content'] = $this->load->view($this->template_path . 'edu/exportblog', $data, TRUE);
        $this->load->view($this->template_path . 'edu/exportblog2', $data);
    }

    /*
     chuyển data product sang blogspot ở phukienkc
    */
    public function phukienkc($limit=0,$offset=0)
    {

        if(!empty($limit)){
            $listpro= $this->_product->get_datapdu("id,title,thumbnail,slug,content,price,price_sale,code,album,crawler_href,attribute",array('is_status'=>1),$limit,$offset);
        }else{
            $listpro= $this->_product->get_datapdu("id,title,thumbnail,slug,content,price,price_sale,code,album,crawler_href,attribute",array('is_status'=>1));
        }

        if(!empty($listpro)){
            foreach($listpro as $item){
                $item->cateedu = $this->_product->getByIdCategoryProduct($item->id);
                $item->album = json_decode($item->album,true);
                $item->attribute = json_decode($item->attribute,true);
            }
            // dd($listpro);
            $data['listpro'] = $listpro;
        }

        // $datamain['main_content'] = $this->load->view($this->template_path . 'edu/exportblog', $data, TRUE);
        $this->load->view($this->template_path . 'edu/phukienkcblog', $data);
    }
/*tìm kiếm khóa học ajax*/
    public function ajax_serachedu(){
        $term = $this->input->post("q");
        $params = [
            'is_status'=> 1,
            'keyword' => $term,
            'limit'=> 5,
            "whereall" => ['type'=>0],//=1 là đã update drive, =2 là đã up youtube
            'order' => array('id'=>'desc'),
        ];
        $listdata = $this->_edu->getData($params);
        
        $output = [];
        if(!empty($listdata)) foreach ($listdata as $item) {
            $output[] = ['id'=>$item->id, 'title'=>$item->title, 'thumbnail'=>$item->thumbnail];
        }
        $this->returnJson($output);

    }
/*
comment modul
do duong 10/1/2023
*/
public function comment($type='',$target_id=''){
    $this->load->model('comment_model');
    $this->_comment = new Comment_model();

    $parent_id = 0;
    $data['limit'] = $limit = 4;
    //gọi view khi load trang
    $offset = 0;
    $data['list_comment'] =$list_comment = $this->_comment->getListCmt(["type"=>$type,"target_id"=>$target_id,"a.parent_id"=>$parent_id],$limit,$offset,true);
    //get total sub của  $list_idcmt, để hiển thị có bao nhiêu câu trả lời
    $html  = $this->load->view($this->template_path . 'block/comment', $data, TRUE);
    return $html;die();
}

}
