<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edu extends API_Controller
{
    protected $_all_category;

    public function __construct() {
        parent::__construct();
        
        $this->load->model(['edu_model','category_model']);
        $this->_edu = new Edu_model();
        $this->_category = new Category_model();
    }

public function get_datapdu(){
    $limit = $this->input->get("limit");
    $data = $this->_edu->get_datapdu("","",$limit);
    $this->returnJson($data);
}    

    public function category()
    {
        $id = $this->input->get("id");
        
        $this->_all_category = $this->_category->_all_category('edu');
        $data['oneItem']  = $oneItem = $this->_category->getByField('id',$id);

        $data['success'] = 1;
        if (empty($oneItem)){
            $data['success'] = 0;
            $data['message'] = "not exit id";
            $this->returnJson($data);
        };
        
        $limit = $this->input->get("limit");
        $page = $this->input->get("page") ? $this->input->get("page") : 1;
        $sortpdu= $this->input->get("sortpdu");
        $sortkey= $this->input->get("sortkey");
        $order = '';
        if(!empty($sortkey)){
            $order = array($sortkey=>$sortpdu);
        }

       
        /*Danh sách cate con,cháu*/
        $data['list_category'] = $listCateId1 = $this->_category->_recursive_child_id2($this->_all_category, $id);//con,chau,chính nó luon
        $listCateId = array_merge(array_column($listCateId1, 'id'),[$id]);

        $data['list_product'] = $this->_edu->getDataEduByCategory($listCateId,'',$limit,$page,$order);
        // phân Trang
        $data['total'] = $total = $this->_edu->getTotalEduByCategory($listCateId);
        
        // end phân Trang
        // breadcrumbs
        $breadcrumbs = [];
        $this->_category->_recursive_parent($this->_all_category, $oneItem->id);
        if (!empty($this->_category->_list_category_parent)) foreach (array_reverse($this->_category->_list_category_parent) as $item) {
            $breadcrumbs[] = $item;
        }
        $data['breadcrumb'] = $breadcrumbs;
        
        $this->returnJson($data);

    }
//getListcategory by type api
public function listCategoryByType(){
    $type = $this->input->get('type');
    $data['all_category_'.$type] = $_all_category = $this->_category->_all_category($type);
    $data['success'] = 1;
    if (empty($_all_category)){
        $data['success'] = 0;
        $data['message'] = "not exit type";
        $this->returnJson($data);
    };
    $this->returnJson($data);
}
//getById api
public function getById(){
    $id = $this->input->get('id');
    $oneItem = $this->_edu->getById($id);

    if (empty($oneItem)){
        $data['success'] = 0;
        $data['message'] = "not exit id";
        $this->returnJson($data);
    };
    $this->returnJson($oneItem);
}
//get item by id -> oneItem
public function getById2(){
    $id = $this->input->get('id');
    $data['oneItem'] = $this->_edu->getById($id);
    
    $data['success'] = 1;
    if (empty($oneItem)){
        $data['success'] = 0;
        $data['message'] = "not exit id";
        $this->returnJson($data);
    };
    $this->returnJson($data);
}
    public function detail()
    {
        $id = $this->input->get('id');

        $this->_all_category = $this->_category->_all_category('edu');
        //get item by id
        $data['oneItem']  = $oneItem = $this->_edu->getByField('id',$id);
        $data['success'] = 1;
        if (empty($oneItem)){
            $data['success'] = 0;
            $data['message'] = "not exit id";
            $this->returnJson($data);
        };
        

        //list danh mục, cua sp
        $data['category'] = $this->_edu->getCategoryByIdEdu($id);

        //sp cùng danh mục
        $data['list_related'] = $this->_edu->getDataEduByCategory($oneItem->category_id,$id,10);
        
        $breadcrumbs = [];
        $this->_category->_recursive_parent($this->_all_category, $oneItem->category_id);
        if (!empty($this->_category->_list_category_parent)){
            $data['danhmuccha'] = $this->_category->_list_category_parent;
             foreach (array_reverse($this->_category->_list_category_parent) as $item) {
                $breadcrumbs[] = $item;
            }
        }
        $data['breadcrumb'] = $breadcrumbs;
        
        $this->returnJson($data);
    }
//get list item history
public function getListItemHistory(){
    $data_history= $this->input->post();
    $id = $this->input->get("id") ? $this->input->get("id") : "";
    
    $data['product_history'] = !empty($data_history) ? $this->_edu->getDataEduHistory($data_history,$id) : '';
    $this->returnJson($data);
}
//get list item by mảng id, empty thì lấy all
public function getListItemByIds(){
    $list_id= $this->input->post();
    
    $data['list_item'] = !empty($list_id) ? $this->_edu->getListItemByIds($list_id) : '';
    $this->returnJson($data);
}
//update view api
public function updateview(){
    $id = $this->input->get('id');
    $oneItem = $this->_edu->getByField('id',$id);
    $this->_edu->update(['id'=>$id],['viewed'=>$oneItem->viewed+1]);
}
//remove_sharedrive api
public function remove_sharedrive(){
    $data = $this->input->post();
    $edu_id = $data['edu_id'];
    $email_remove = $data['email_remove'];
    $id_permission = $data['id_permission'];

    $itemedu = $this->_edu->getById($edu_id,"id,link_drive");
    $link_id = str_replace("/", "", strrchr($itemedu->link_drive,"/"));

    $this->load->library('google_api');
    $rediect_uri = GG_rediect;
    $this->google_api->login($rediect_uri,'drive');
    $remove_share = $this->google_api->remove_share($email_remove,$link_id,$id_permission);
}
public function buyedu($id="",$email="",$who=""){

    $params = $this->input->post();
    $id = $params['id'];
    $email = $params['email'];
    $who = $params['who'];
    $api_token = $this->input->get("api_token");
    /*
        log xem chia sẻ cho gmail nào, từ web nao
         */
    $item = $this->_edu->getById($id,"id,title,price,price_sale,is_free,link_drive,countsell");

    //2.3 share file
    $returndata['id_permission'] = 0;
    if(!empty($item->link_drive)){

        $link_id = str_replace("/", "", strrchr($item->link_drive,"/"));
        
        if(stripos($email,"@gmail.com")){//không cùng gmail sẽ báo lỗi khi không gửi thông báo
            $sendNotification = false;
        }else{
            $sendNotification = true;
        }

        $this->load->library('google_api');
        $rediect_uri = GG_rediect;
        $this->google_api->login($rediect_uri,'drive');
        $sharedrive = $this->google_api->sharefile($email,$link_id,$sendNotification);
        
        if(!empty($sharedrive['id'])){//id là id share, id_permission
            $returndata['id_permission'] = $sharedrive['id'];

            // log vào bảng logs_api
            $dtlog = array(
                'api_token'=>$api_token,
                'who'=>$who,
                'modul'=>'edu',
                'action'=>"share_drive",
                'gmail'=>$email,
                'is_status'=>2,
                'note' =>"share drive cho email: ".$email." edu_id = ".$id." Tên edu ".$item->title
            );
            $this->addLogApi($dtlog);
        }

    }else{
        // log vào bảng logs_api
        $dtlog = array(
            'api_token'=>$api_token,
            'who'=>$who,
            'modul'=>'edu',
            'action'=>"share_drive",
            'gmail'=>$email,
            'is_status'=>1,
            'note' =>"Chưa share drive cho email: ".$email." edu_id = ".$id." Tên edu ".$item->title
        );
        $this->addLogApi($dtlog);
    }
 
     $this->returnJson($returndata);
    
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

}
