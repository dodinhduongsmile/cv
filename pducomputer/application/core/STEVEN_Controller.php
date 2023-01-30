<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class STEVEN_Controller extends CI_Controller
{
    public $template_path = '';
    public $template_main = '';
    public $templates_assets = '';
    public $template_include = '';
    public $_controller;
    public $_method;
    public $_memcache;
    public $_settings;
    public $_settings_social;
    public $_message = array();

    public function __construct()
    {
        parent::__construct();

        //1.Load library
        $this->load->library(array('session', 'form_validation', 'user_agent','cart'));
        $this->load->helper(array('cookie', 'data', 'security', 'url', 'directory', 'file', 'form', 'datetime', 'debug', 'text'));

        //$this->config->load('languages');
        //2.Load database
        $this->load->database();
        //3. lấy class, action của router
        $this->_controller = $this->router->fetch_class();//lấy class controller
        $this->_method = $this->router->fetch_method();//lấy action
        //load cache driver
        if (CACHE_MODE == TRUE){
            $this->load->driver('cache', array('adapter' => CACHE_ADAPTER, 'backup' => 'file', 'key_prefix' => CACHE_PREFIX_NAME));
        }
    }

    public function setCacheFile($timeOut = 1){
        if (CACHE_FILE_MODE == TRUE) {
            $this->output->cache($timeOut);
        }
    }
    
    public function setCache($key, $data, $timeOut = 3600)
    {
        if (CACHE_MODE == TRUE) {
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


    public function delete_cache_file($url = ''){
        if (empty($url)){
            $this->load->helper('file');
            $url = $this->input->get('url');
        }

        if(!empty($url)){
            $uri = str_replace(base_url(),'/',$url);
            if($this->output->delete_cache($uri)) echo 'Delete cache'.$uri."<br>";
            else  echo "$uri has been deleted !<br>";
        }else{
            if(delete_files(FCPATH . 'application' . DIRECTORY_SEPARATOR . 'cache')) die("Delete all page statistic success !");
            else  die("Delete all page statistic error !");
        }

    }
    public function checkRequestGetAjax()
    {
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'))
            die('Not Allow');;
    }

    public function checkRequestPostAjax()
    {
        if ($this->input->server('REQUEST_METHOD') !== 'POST'
            || empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            || (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
        )
            die('Not Allow');
    }

    public function returnJson($data = null)
    {
        if ($this->config->item('csrf_protection') == TRUE) {
            $csrf = [
                'csrf_form' => [
                    'csrf_name' => $this->security->get_csrf_token_name(),
                    'csrf_value' => $this->security->get_csrf_hash()
                ]
            ];
            if (empty($data)) $data = $this->_message;
            $data = array_merge($csrf, (array)$data);
        }
        die(json_encode($data));
    }

    public function toSlug($doc)
    {
        $str = addslashes(html_entity_decode($doc));
        $str = $this->toNormal($str);
        $str = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
        $str = preg_replace('~[^\pL\d]+~u', '-', $str);
        $str = preg_replace('~[^-\w]+~', '', $str);;
        $str = preg_replace("/( )/", '-', $str);
        $str = str_replace('/', '', $str);
        $str = str_replace("\/", '', $str);
        $str = str_replace("+", "", $str);
        $str = str_replace(" - ", "-", $str);
        $str = str_replace("---", "-", $str);
        $str = strtolower($str);
        $str = stripslashes($str);
        return trim($str, '-');
    }

    public function toNormal($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        return $str;
    }

    
    public function encrypt_decrypt($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'steven_secret_key';
        $secret_iv = 'steven_secret_iv';
        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }


}
//controller của admin
class Admin_Controller extends STEVEN_Controller
{

    public function __construct()
    {
        parent::__construct();

        //set đường dẫn template
        $this->template_path = 'admin/';
        $this->template_main = $this->template_path . '_layout';
        $this->templates_assets = base_url() . 'public/admin/';

        //Language
        // $this->switchLanguage($this->input->get('lang'));

        //tải thư viện
        $this->load->library(array('breadcrumbs'));
        //load helper tự viết
        $this->load->helper(array('banner','image','format', 'link','button'));
        //Load config
        $this->config->load('seo');
        $this->config->load('permission');

        //check phân quyền
        $this->check_auth();
        
    }
/*kiểm tra quyền truy cập modul*/
    public function check_auth()
    {
        // $this->session->sess_destroy();
        // dd($this->session->userdata());
        
        $userpdu =$this->session->userdata();
    if (
        ($this->_controller !== 'user' || ($this->_controller === 'user' && !in_array($this->_method, ['login', 'ajax_login','logout']))) && empty($userpdu['admin_backend'])) {
            //chưa đăng nhập thì chuyển về page login
            redirect(site_admin_url('user/login') . '?url=' . urlencode(current_url()), 'refresh');

        }else {
            if (!empty($userpdu['admin_backend'])) {
                if ($userpdu['group_id'] != 1) {//nếu không thuộc group số 1, thì sẽ check quyền
                    if (!$this->session->admin_permission) {//nếu chưa có session admin_permission

                        $this->load->model('Groups_model', 'group');
                        $groupModel = new Groups_model();
                        $data = $groupModel->get_group_by_groupid((int)$userpdu['group_id']);
                        
                        if (!empty($data)) {
                            $this->session->admin_permission = json_decode($data->permission, true);
                        }
                    }


                    $request_ajax = $this->input->server(array('REQUEST_URI'));
                    //chạy vào 1 đường dẫn nào đó, check quyền xem
                    if (!in_array($this->_controller, array('dashboard')) && $this->_method !== 'logout') {
                        if (($request_ajax['REQUEST_URI'] !== '/admin/category/ajax_load/post') && ($request_ajax['REQUEST_URI'] !== '/admin/category/ajax_load/tag') && ($request_ajax['REQUEST_URI'] !== '/admin/category/ajax_load/property')) {
                            if (empty($this->session->admin_permission[$this->_controller]['view'])) {//check quyen view
                                $this->load->view($this->template_main, ['main_content' => $this->load->view($this->template_path.'not_permission', [], TRUE)]);
                            }
                        }

                    }
                }
            }


        }
    }

/*switchLanguage có vẻ thừa*/
    public function switchLanguage($lang_code = "")
    {
        $language_code = !empty($lang_code) ? $lang_code : $this->config->item('language_default');
        //$this->session->set_userdata('admin_lang', $language_code);
        $languageFolder = $this->config->item('language_folder')[$language_code];
        //$this->session->set_userdata('admin_lang_folder', $languageFolder);
        if (!empty($lang_code)) redirect($_SERVER['HTTP_REFERER']);
    }

    // add log action, thêm log vào log user
    public function addLogAction($module,$data,$module_id,$note,$action)
    {
        $this->load->model("logs_model");
        $logActionModel = new Logs_model();
        $data_store = [
            'module' => $module,
            'ip' => $this->input->ip_address(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'module_id' => $module_id,
            'note' => $note,
            'action' => $action,
            'uid' => $this->session->user_id,
            'data' => json_encode($data)
        ];
        $logActionModel->save($data_store);
    }
    public function addLogWarehouse($data,$module_id,$note,$action)
    {
        $this->load->model("logsware_model");
        $logActionModel = new Logsware_model();
        $data_store = [
            'ip' => $this->input->ip_address(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'module_id' => $module_id,
            'note' => $note,
            'action' => $action,
            'user' => $this->session->user_id,
            'data' => json_encode($data)
        ];
        $logActionModel->save($data_store);
    }

}
//Controller dùng của frontend
class Public_Controller extends STEVEN_Controller
{
    public function __construct() {
        parent::__construct();

        //set đường dẫn template
        $this->template_path = 'public/default/';
        $this->template_main = $this->template_path . '_layout';//url vào view bố cục
        $this->templates_assets = base_url() . 'public/';

        //tải thư viện
        $this->load->library(array('breadcrumbs'));

        //load helper
        $this->load->helper(array('cookie','link', 'title', 'format', 'image', 'download'));

        //bảo trì thì load view này, cấu hình ở config
        if(MAINTAIN_MODE == TRUE) $this->load->view('public/coming_soon');

        // $this->load->model(['post_model','category_model']);

        //Set flash message
        $this->_message         = $this->session->flashdata('message');

        //5. lấy database bảng setting hệ thống
        $this->_settings        = getSetting('data_seo');
        $this->_settings_social = getSetting('data_social');
        $this->_settings_email  = getSetting('data_email');
        $this->_settings_home  = getSetting('data_home');
        $this->_data_store      = getStore('store');
        //6. config brecrumb
        $configBreadcrumb['crumb_divider'] = $this->config->item('frontend_crumb_divider');
        $configBreadcrumb['tag_open'] = $this->config->item('frontend_tag_open');
        $configBreadcrumb['tag_close'] = $this->config->item('frontend_tag_close');
        $configBreadcrumb['crumb_open'] = $this->config->item('frontend_crumb_open');
        $configBreadcrumb['crumb_first_open'] = $this->config->item('frontend_crumb_first_open');
        $configBreadcrumb['crumb_last_open'] = $this->config->item('frontend_crumb_last_open');
        $configBreadcrumb['crumb_close'] = $this->config->item('frontend_crumb_close');
        $this->breadcrumbs->init($configBreadcrumb);
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if (DEBUG_MODE == TRUE) {
            if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')) {
                $this->load->add_package_path(APPPATH . 'third_party', 'codeigniter-debugbar');
                $this->output->enable_profiler(TRUE);
            }
        }
        

    }
    

    public function addLogRef($data)
    {
        $this->load->model("logsref_model");
        $logActionModel = new Logsref_model();
        $data_store = [
            'type' => $data['type'],
            'user_id' => $data['user_id'],
            'child_id' => $data['child_id'],
            'reward' => $data['reward'],
            'note' => $data['note'],
            
        ];
        $logActionModel->save($data_store);
    }

    public function getUrlLogin()
    {
        $url = $this->zalo->getUrlLogin();
        return $url;
    }
//validate text
    function alpha_numeric_space($str)
    {
        if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\+=\{\}\[\]\|;:"\<\>\.\?\\\]/', $str)) {
            $this->form_validation->set_message('alpha_numeric_space', '%s không được chứa ký tự đặc biệt');
            return false;
        }
        return true;
    }

    /**
     * @return array A CSRF key-value pair
     */
    public function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);
        return array($key => $value);
    }

    /**
     * @return bool Whether the posted CSRF token matches
     */
    public function _valid_csrf_nonce()
    {
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function sendMail($to_mail, $subject, $contentHtml, $emailToCC = '', $emailToBCC = '')
    {
        try {
            $this->load->library('email');
            if (!empty($this->settings['protocol'])) {
                $this->email->protocol = $this->settings['protocol'];
                $this->email->smtp_host = $this->settings['smtp_host'];
                $this->email->smtp_user = $this->settings['smtp_user'];
                $this->email->smtp_port = $this->settings['smtp_port'];
            }
            if (!empty($this->settings['email_admin'])) {
                $from_mail = $this->settings['email_admin'];
            } else {
                $from_mail = $this->email->smtp_user;
            }
            $this->email->from($from_mail);
            $this->email->to($to_mail);
            if (!empty($emailToCC)) $this->email->cc($emailToCC);
            if (!empty($emailToBCC)) $this->email->bcc($emailToBCC);
            $this->email->subject($subject);
            $this->email->message($contentHtml);
            if ($this->email->send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            $this->_message = array(
                'type' => 'danger',
                'message' => 'Co lỗi khi gửi mail'
            );
        }
    }


}

class API_Controller extends CI_Controller
{
    public $time_start;
    public $time_end ;

    function __construct()
    {
        parent::__construct();
        $this->time_start = $this->microtime_float();
        $this->load->database();
    $this->load->helper(array('cookie', 'data', 'security', 'url', 'directory', 'file', 'form', 'datetime', 'language', 'debug', 'text'));
        
        if (CACHE_MODE == TRUE) $this->load->driver('cache', array('adapter' => CACHE_ADAPTER, 'backup' => 'file', 'key_prefix' => CACHE_PREFIX_NAME));
    }
    public function setCache($key, $data, $timeOut = 3600)
    {
        if (CACHE_MODE == TRUE) {
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
    public function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

}


class Crawler_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('security', 'url', 'form', 'debug', 'data'));
    }

    public function checkRequestGetAjax()
    {
        if ($this->input->server('REQUEST_METHOD') !== 'GET')
            die('Not Allow');;
    }

    public function checkRequestPostAjax()
    {
        if ($this->input->server('REQUEST_METHOD') !== 'POST')
            die('Not Allow');
    }

    public function returnJsonData($data)
    {
        header('Content-Type: application/json; charset=utf-8');
        die(json_encode($data));
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

    public function toSlug($doc)
    {
        $str = addslashes(html_entity_decode($doc));
        $str = $this->toNormal($str);
        $str = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
        $str = preg_replace('~[^\pL\d]+~u', '-', $str);
        $str = preg_replace('~[^-\w]+~', '', $str);;
        $str = preg_replace("/( )/", '-', $str);
        $str = str_replace('/', '', $str);
        $str = str_replace("\/", '', $str);
        $str = str_replace("+", "", $str);
        $str = str_replace(" - ", "-", $str);
        $str = str_replace("---", "-", $str);
        $str = strtolower($str);
        $str = stripslashes($str);
        return trim($str, '-');
    }

    public function toNormal($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        return $str;
    }

    public function curl_html($url)
    {
        $pointer = curl_init();
        curl_setopt($pointer, CURLOPT_URL, $url);
        curl_setopt($pointer, CURLOPT_TIMEOUT, 40);
        curl_setopt($pointer, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($pointer, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.28 Safari/534.10");
        curl_setopt($pointer, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($pointer, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($pointer, CURLOPT_HEADER, false);
        curl_setopt($pointer, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($pointer, CURLOPT_AUTOREFERER, true);

        $return_val = curl_exec($pointer);

        $http_code = curl_getinfo($pointer, CURLINFO_HTTP_CODE);
        if ($http_code == 404) {
            return false;
        }
        curl_close($pointer);
        unset($pointer);
        return $return_val;
    }

}
