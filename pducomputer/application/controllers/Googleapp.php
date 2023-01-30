<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Googleapp extends Public_Controller {

	protected $_contact;

    public function __construct() {
        parent::__construct();
        // $this->config->load('Google');
        $this->load->model('edu_model');
        // $this->load->model('users_model');
        // $this->_user = new Users_model();
        $this->_edu = new Edu_model();
        
        $this->load->library('google_api');
        $this->check_auth();
    }
public function check_auth(){
    $userpdu =$this->session->userdata();
    if (empty($userpdu['user_id']) &&  empty($userpdu['admin_backend'])) {
        //chưa đăng nhập thì chuyển về page login
        redirect(base_url('user/login') . '?url=' . urlencode(current_url()), 'refresh');
    }
}


    public function testview()
    {
        $this->load->view($this->template_path . 'itme/testview',[], false);
    }
    public function file_drive()
    {
        // unset($_SESSION['GOOGLE_ACCESS_TOKEN']);
        // dd($_SESSION['GOOGLE_ACCESS_TOKEN']);
        //cách 1: login để lấy client rồi mới tạo service, phải đăng nhập
        $rediect_uri = GG_rediect;
        $this->google_api->login($rediect_uri,'drive');
       
        $this->load->view($this->template_path . 'itme/app_googledrive',[], false);
        
    }

    public function ajax_file_drive()
    {
        set_time_limit(0);
        $this->checkRequestGetAjax();
        $data = $this->input->get();
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
            if(!empty($data['id_edu'])){
                /*update*/

                $dataupdate = [
                    "listdrive" => $listdrive,
                    "type" => 1,
                    'link_drive' => $data['link']
                ];
                $this->_edu->update(['id'=>(int)$data['id_edu']],$dataupdate);  
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
            $html = $this->load->view('public/default/itme/ajax_app_googledrive', $dataview, TRUE);
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
    public function test() { 
        /*
        1. load view để điền link scan, và login google drive
        2. ấn search thì ajax xử lý dữ liệu (có thể viết 1 hàm xử lý ajax khác)
        - check link xem tồn tại chưa, chưa thì insert vào database
        - trả về html để hiển thị ra demo
         */
        
        $rediect_uri = "http://localhost/ctytoan/pducomputer/googleapp/file_drive";
        $this->google_api->login($rediect_uri,'drive');
        $info = $this->google_api->getListFile();
       
    }
    public function test2() { 
        // use Google_\Google\Client;
        $gClient = new \Google_Client();
        $gClient->setApplicationName('Login to cole.vn');
        $gClient->setClientId($this->config->item('OAUTH2_CLIENT_ID'));
        $gClient->setClientSecret($this->config->item('OAUTH2_CLIENT_SECRET'));
        $gClient->setRedirectUri($this->config->item('REDIRECT_URI'));

        foreach ($this->config->item('scope') as $scope){
            $gClient->addScope($scope);
        }
        $auth_url = $gClient->createAuthUrl(); //dd($auth_url);
        $authCode = $this->input->get('code');
        if (empty($authCode)) {
            //rediect to login page
            return redirect(filter_var($auth_url, FILTER_SANITIZE_URL));
        } else {
            $accessToken = $gClient->fetchAccessTokenWithAuthCode($authCode);
            $gClient->setAccessToken($accessToken);
            $google_oauth = new \Google_Service_Oauth2($gClient);
            $userInfo = $google_oauth->userinfo->get();
            if ($userInfo) {
                dd($userInfo);
                return $this->createMemberFromSocialAndCheckLogin([
                    'name'=>$userInfo->name,
                    'email'=>$userInfo->email,
                    'source'=>'google'
                ]);
            }
        }
        
    }

    public function callCURL($url, $data = array(), $type = "GET")
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
            /*
     * send request
     */
       
    public  function sendRequest($url, $params = array(), $requestType = 'get', $token = '', $contentType = 'http', $returnError404 = false) {
        $ch = curl_init();
        $headers = [];
        $requestType = strtoupper($requestType);
        if (is_string($params)) {
            $url .= "?" . $params;
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $requestType);
        if (is_array($params)) {
            curl_setopt($ch, CURLOPT_POST, count($params));
            if ($contentType == 'json') {
                $params = json_encode($params);
                $headers[] = "Content-type: application/json";
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            } else
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }
        //add header
        $headers[] = 'X-HTTP-Method-Override: ' . $requestType;
        //token / gogle drive token
        if ($token) {
            $headers[] = "Authorization: Bearer " . $token;
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //pr($headers);
        // remove verify ssl
        //if(ereg("^(https)",$url)){
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //}
        //call api
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        /* Check for 404 (file not found). */
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // Check the HTTP Status code
        switch ($httpCode) {
            case 200:
                $error_status = "200: Success";
                curl_close($ch);
                return $response;
            case 201:
                $error_status = "201: Created";
                curl_close($ch);
                return $response;
            case 400:
                if (strpos($url, 'api.instagram.com') !== -1) {
                    curl_close($ch);
                    return $response;
                }
            case 404:
                if ($returnError404) {
                    return ['error' => 404];
                }
                $error_status = "404: API Not found.";
                break;
            case 500:
                $error_status = "500: servers replied with an error.";
                break;
            case 502:
                $error_status = "502: servers may be down or being upgraded. Hopefully they'll be OK soon!";
                break;
            case 503:
                $error_status = "503: service unavailable. Hopefully they'll be OK soon!";
                break;
            default:
                $error_status = "Undocumented error: " . $httpCode . " : " . curl_error($ch);
                break;
        }
        curl_close($ch);
        $paramsString = is_array($params) ? json_encode($params) : $params;
        echo $error_status . " , {$requestType} {$url}, params: {$paramsString}, errors : " . static::getResponseErrors($response);
        die;
    }

    public static function getResponseErrors($response) {
        $error = '';
        if (isset($response['errors'])) {
            $error = is_array($response['errors']) ? json_encode($response['errors']) : $response['errors'];
        }
        return $error;
    }
}

/* End of file Ajax.php */
/* Location: ./application/controllers/Ajax.php */