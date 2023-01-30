<?php
defined('BASEPATH') or exit('No direct script access allowed');

require "public/simple_html_dom.php";

class Updateedu extends Admin_Controller
{
    private $_category; 
    private $_edu; 
    private $_domain; 
     
    public function __construct(){ 
        parent::__construct();
        $this->load->model(['category_model','edu_model']);
        $this->_category     = new Category_model();
        $this->_edu      = new Edu_model();

        $this->_domain       = 'https://www.hanoicomputer.vn/';
    } 
 public function index(){
        $data['heading_title'] = "update khóa học";
        $data['heading_description'] = "update khóa học";
        $data['main_content'] = $this->load->view($this->template_path . DIRECTORY_SEPARATOR . 'edu/updateedu', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
public function getListDrive()
{
    // $this->checkRequestPostAjax();
    // $data= $this->input->post();
    // dd($data['link']);
    $this->load->library('google_api');

    set_time_limit(0);
        $this->checkRequestPostAjax();
        $data = $this->input->post();
        $data_scan['sub'] = isset($data['sub']) ? 1 :0;
        // $data_scan['id_folder'] = str_replace("https://drive.google.com/drive/u/0/folders/","",$data['link']);
        $data_scan['id_folder'] = str_replace("/", "", strrchr($data['link'],"/"));
        //cách 1: login để lấy client rồi mới tạo service, phải đăng nhập
        $rediect_uri = GG_rediect;
        $this->google_api->login($rediect_uri,'drive');

        //cách 2: gọi thẳng vào service_account -> không phải đăng nhập
        // $this->google_api->service_account();
        
        $datascan = $this->google_api->getListFile($data_scan);

        if(!empty($datascan['child'])){
            $listdrive = json_encode($datascan['child']);
            if(!empty($data['id_itemedu'])){
                /*update*/

                $dataupdate = [
                    "listdrive" => $listdrive,
                    "type" => 1,
                    'link_drive' => $data['link']
                ];
                $this->_edu->update(['id'=>(int)$data['id_itemedu']],$dataupdate);  
                $_message = "update thành công"; 
            }else{
                /*insert*/
                $title_foder = $datascan['foder']['name'];
                $datainsert = [
                    "title" => $title_foder,
                    "slug" => $this->toSlug($title_foder),
                    'description' => $title_foder,
                    'meta_title' => $title_foder,
                    'meta_description' => $title_foder,
                    'meta_keyword' => $title_foder,
                    "content" =>$title_foder,
                    "listdrive" => $listdrive,
                    "type" => 1,//đủ cả youtube và drive là 2, thiếu là 1
                    "price" => 50000,
                    "price_sale" => 50000,
                    'link_drive' => $data['link']
                ];
                $id = $this->_edu->save($datainsert); 
                $_message = "insert thành công"; 
            }
            
            $dataview['typevd'] = 'dr';
            $dataview['listvd'] = $datascan['child'];
            $dataview['linklist'] = "https://drive.google.com/file/d/".$datascan['child'][0]['id']."/preview";

            $html = $this->load->view('admin/edu/ajax_listyoutube', $dataview, TRUE);
            $data_mess = [
                'message' => $_message,
                'type' => 'success',
                'html' => $html
            ];
            die(json_encode($data_mess));
        }else{
            $message['type'] = 'error';
            $message['message'] = "Có lỗi khi scan folder google. Không quét được file, Kiểm tra lại code";
            $this->returnJson($message);
        }
   

    
}
public function getListYoutube()
{
    $this->checkRequestPostAjax();
    $id_itemedu = $this->input->post('id_itemedu') ? $this->input->post('id_itemedu') : "";
  
    $title_itemedu = $this->input->post('title_itemedu');
    $search = $this->input->post("q") ?  trim($this->input->post("q")) : "";
    
    if(!empty($search)){
        if(strpos($search, "youtube.com") == false){
            $data_mess = [
                'message' => 'url của bạn không phải của youtube',
                'type' => 'error'
            ];
            die(json_encode($data_mess));
        }else{
            //
            $checkHref = $this->_edu->checkHref($search);
            if (empty($checkHref)) {
                $dataAPI = $this->callCURL("https://api.youtubemultidownloader.com/playlist?url={$search}&nextPageToken=",'','get');
                
                $datayt = json_decode($dataAPI);
                
                if($datayt->status){//có tồn tại link
                    $data = [];
                    foreach($datayt->items as $item){
                        $data[] = [
                            "name" => $item->title,
                            "link" => $item->url,
                            "id" => $item->id,
                            "time" => round($item->duration / 60,1),
                            "thumbnail" => $item->thumbnails,
                        ];
                    }
                    if(!empty($data)){
                        //sort
                        usort($data, function($a,$b){
                           preg_match_all('!\d+!', $a['name'], $matches);
                           preg_match_all('!\d+!', $b['name'], $matches2);
                            $a = (int)$matches[0][0];
                            $b = (int)$matches2[0][0];
                               return ($a<$b)?-1:1;//nếu $a < $b thì không cần sort, và ngược lại
                        });
                        if($id_itemedu){
                            //update
                            $dataupdate = [
                                "listyoutube" => json_encode($data),
                                "link_youtube" =>$search
                            ];
                           $this->_edu->update(['id'=>(int)$id_itemedu],$dataupdate);  
                            $_message = "update thành công"; 
                        }else{
                            $_message = "sang bên khóa học thêm {$title_itemedu} vào đã, rồi mới update được."; 
                        }

                    }
                }else{
                    $data_mess = [
                        'message' => 'url của bạn không đúng',
                        'type' => 'error'
                    ];
                    die(json_encode($data_mess));
                }
                
            }else{
                // echo "link đã tồn tại trên hệ thống";
                $_message = "link đã tồn tại trên hệ thống"; 
                $data = $this->_edu->getByField('link_youtube',$search);
                $data = json_decode($data->listyoutube,true);
                

            }
            $datax['listvd'] = $data;
            $datax['linklist'] = $search;
            $datax['typevd'] = 'yt';
            $html = $this->load->view('admin/edu/ajax_listyoutube', $datax, TRUE);
            $data_mess = [
                'message' => isset($_message) ? $_message : "Lỗi gì đó,xem lại code",
                'type' => 'success',
                'html' => $html
            ];
            die(json_encode($data_mess));
            
        }
        // returnJsonData
        
        
    }//if(!empty($search)
}

public function updateType()
{
    $eduType0 = $this->_edu->getDataAll(['type'=>1],'','id,link_youtube,link_drive');
    if(!empty($eduType0)){
        foreach($eduType0 as $item){
            if($item->link_youtube != ''){
                $this->_edu->update(['id'=>$item->id],['type'=>2]);  
            }
        }
    $data_mess = [
        'message' => "update type xong.",
        'type' => 'success'
    ];
    die(json_encode($data_mess));
    }
}
private function save_category($id, $category_id) {
    if (!empty($category_id)) {
        $this->_edu->delete(['edu_id'=>$id],'edu_category');
        $data_category[] = ["edu_id" => $id, 'category_id' => $category_id];

        if(!$this->_edu->insertMultiple($data_category, 'edu_category')){
            $message['type'] = 'error';
            $message['message'] = "Thêm edu_category thất bại !";
            log_message('error', $message['message'] . '=>' . json_encode($data_category));
        }
    }

}   

private function callCURL($url, $data = array(), $type = "GET")
    {
        $time_star = microtime(true);
        $resource = curl_init();
        curl_setopt($resource, CURLOPT_URL, $url);

        if ($type == "POST") {
            curl_setopt($resource, CURLOPT_POST, true);
            curl_setopt($resource, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($resource, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($resource, CURLOPT_TIMEOUT, 40);
        $httpcode = curl_getinfo($resource, CURLINFO_HTTP_CODE);
        $result = curl_exec($resource);
        curl_close($resource);
        return $result;
    }

public function ajax_serachedu(){
        $this->checkRequestPostAjax();
        $term = $this->input->post("q");
        $params = [
            'is_status'=> 1,
            'keyword' => $term,
            'limit'=> 5,
            "whereall" => ['type'=>0]
        ];
        $listdata = $this->_edu->getData($params);
        $output = [];
        if(!empty($listdata)) foreach ($listdata as $item) {
            $output[] = ['id'=>$item->id, 'title'=>$item->title, 'thumbnail'=>$item->thumbnail];
        }
        $this->returnJson($output);

    }
public function ajax_serachedu1(){
        $this->checkRequestPostAjax();
        $term = $this->input->post("q");
        $params = [
            'is_status'=> 1,
            'keyword' => $term,
            'limit'=> 5
        ];
        $listdata = $this->_edu->getData($params);
        $output = [];
        if(!empty($listdata)) foreach ($listdata as $item) {
            $output[] = ['id'=>$item->id, 'title'=>$item->title, 'thumbnail'=>$item->thumbnail];
        }
        $this->returnJson($output);

    }
//load data video
public function ajax_load1(){
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        
        if(!empty($id)){
             $data_info = $this->_edu->single(['id' => $id],$this->_edu->table);
            
            $datadr['listvd'] = json_decode($data_info->listdrive,true);
            $datadr['linklist'] = $data_info->link_drive;
            $datadr['typevd'] = 'dr';
            $htmldr = $this->load->view('admin/edu/ajax_listyoutube', $datadr, TRUE);

            $datayt['listvd'] = json_decode($data_info->listyoutube,true);
            $datayt['linklist'] = $data_info->link_youtube;
            $datayt['typevd'] = 'yt';
            $htmlyt = $this->load->view('admin/edu/ajax_listyoutube', $datayt, TRUE);

            $data_mess = [
                'message' => "thành công",
                'type' => 'success',
                'htmldr' => $htmldr,
                'htmlyt' => $htmlyt
            ];
            die(json_encode($data_mess));
        }
    }
}//endproductpdu

