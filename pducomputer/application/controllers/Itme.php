<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Itme extends Public_Controller {
protected $_itme;
	public function __construct()
	{
		parent::__construct();
		$this->load->model(['itme_model', 'product_model']);
		$this->_itme = new Itme_model();
        $this->_product      = new Product_model();
	}

/*
Import data file excel to database
 */
 public function upload_excel(){
        $this->load->library('PHPExcel');
        if ($this->input->post('importfile')) {
            
            $path = 'public/uploads/import/';
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls|jpg|png';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('userfile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }

            if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;
            
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);//load file
            } catch (Exception $e) {
                echo $this->messages = '<script>
                                    alert("Bạn chưa chọn file. Vui lòng chọn file và thao tác lại");
                                    window.history.back();
                            </script>';
            }
            $objPHPExcel->setActiveSheetIndex(0);//chọn sheet đầu tiên, số 0
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            
            $key_data = [
                "title" => "A",
                "content" =>"B",
                "album"=>"C",
                "price" =>"D",
                "code" => "E",
                "crawler_href" => "F",
                "attribute" => "G"
            ];

            $arrayCount = count($allDataInSheet);
            $alldata = [];
            set_time_limit(0);
                for ($i = 2; $i <= $arrayCount; $i++) {
                    $data = [];
                    $data['title'] = filter_var(trim($allDataInSheet[$i][$key_data["title"]]), FILTER_SANITIZE_STRING);

                    if ($data['title'] != '') {
                        $data['slug'] = $slug = $this->toSlug($data['title']);

                        $data_content = filter_var(trim($allDataInSheet[$i][$key_data["content"]]), FILTER_SANITIZE_STRING);
                        $data['content'] = str_replace("\n", "<br>", $data_content);
                        
                        $price = filter_var(trim($allDataInSheet[$i][$key_data["price"]]), FILTER_SANITIZE_STRING);
                        $data['price'] = str_replace(",", "", $price);
                        
                        $data['code'] = filter_var(trim($allDataInSheet[$i][$key_data["code"]]), FILTER_SANITIZE_STRING);
                        $data['crawler_href'] = filter_var(trim($allDataInSheet[$i][$key_data["crawler_href"]]), FILTER_SANITIZE_STRING);

                        $data_attribute = filter_var(trim($allDataInSheet[$i][$key_data["attribute"]]), FILTER_SANITIZE_STRING);
                        $data_attribute = explode(', ', $data_attribute);
                        $data_attribute = !empty($data_attribute) ? array_unique($data_attribute) : '';
                        $data['attribute'] = json_encode($data_attribute);

                        $data_album = filter_var(trim($allDataInSheet[$i][$key_data["album"]]), FILTER_SANITIZE_STRING);
                        $data_album = explode(",",$data_album);
                        $thumb_arr = array();
                        if (!empty($data_album)) foreach ($data_album as $key => $value) {
                            
                            $thumb = $data['code'].'-'.$slug.'-pducomputer-'.$key.'.jpg';
                            $dir  = MEDIA_PATH.'product/phukiendienthoai/'. $thumb.'';
                            copy("https://cf.shopee.vn/file/".$value, $dir);
                            $thumb_arr[] = '/product/phukiendienthoai/'.$thumb;
                        }
                        $album = !empty($thumb_arr) ? array_unique($thumb_arr) : '';


                        $data['thumbnail'] = !empty($album) ? $album[0] : '';
                        $data['album'] = !empty($album) ? json_encode($album) : '';
                        
                        $checkHref = $this->_product->checkHref($data['crawler_href']);
                        if (empty($checkHref)) {
                            $id = $this->_product->save($data);
                            $this->save_category($id, ["14","19"]);//017=laptopdell | hp-106 | lenlovo-115 | asus-116, acer-117 | sony-118
                            echo "thanh cong".$i.$data['title']."</br>";

                        }else{
                            echo "Đã tồn tại <br/>" . $data['title'];
                        }
                        

                    
                    }
                    $alldata[] = $data;
                }
                dd($alldata);
        }

    }

	public function ductam()
	{
		$data['listsp'] = $this->_itme->getDataItme(['trangthai <=' => 4]);
        $data['SEO'] = [
            'meta_title' => 'công việc đỗ dương',
            'is_robot' => '',
        ];
		$this->load->view($this->template_path . 'itme/ductam' , $data, false);
        $this->load->view($this->template_main, $data);
	}


	   public function ajax_add(){
        $this->checkRequestPostAjax();
        $data = $this->_convertData();
        dd($data);
        if(!empty($data['son'])){
        	$data['son'] = json_encode($data['son']);
        }

        if($id = $this->_itme->save($data)){
            $message['type'] = 'success';
            $message['message'] = "Thêm mới thành công !";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Thêm mới thất bại !";
        }
        $this->returnJson($message);
    }

//lấy thông tin cái cần sửa
    public function ajax_edit(){
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        if(!empty($id)){
            $output['data_info'] = $this->_itme->single(['id' => $id],$this->_itme->table);
            $output['data_info']->son = json_decode($output['data_info']->son);
            $output['data_info']->ngaynhan = date('Y-m-d',strtotime($output['data_info']->ngaynhan));
            $this->returnJson($output);
        }
    }
//update thông tin vừa sửa
    public function ajax_update(){
        $this->checkRequestPostAjax();
        $data = $this->input->post();
        $id = $data['id'];
        if(!empty($data['son'])){
        	$data['son'] = json_encode($data['son']);
        }
        // thư mục chứa file upload, đứng cùng cấp với index
        		$error = '';
				if(!empty($_FILES["file"])){
					$upload_dir = "public/uploads/ductam/";
					//đường dẫn của file sau khi upload
					$upload_file = $upload_dir.$_FILES["file"]["name"];
					$type_allow = array("png","jpg","jpeg","gif");
					$type = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);//lấy đuôi file
			
					if(!in_array(strtolower($type), $type_allow)){
						$error["file"] = "chỉ được upload file ảnh có dạng png,jpg,jpeg,gif";
					}else{

						#upload file có kích thước cho phép(<20MB ~ 29.000.000 byte)
						$file_size = $_FILES["file"]["size"];
						if($file_size > 29000000){
							$error["file"] = "chỉ được upload file bé hơn 20MB";
						}
						if(empty($error)){
				        	//2.3.1: di chuyển file từ đường dẫn tạm tới thư mục chứa file upload_file
							if(move_uploaded_file($_FILES["file"]["tmp_name"], $upload_file)){//di chuyển file đã tải lên đến vị trí mới $upload_file
								// echo "upload file thành công";
							}else{
								echo "upload file thất bại, không di chuyển đc file tới chỗ lưu, hoặc đéo có file để di chuyển";
							}
				        }
						
					}
				}

        if($this->_itme->update(['id' => $id],$data, $this->_itme->table)){
            $message['type'] = 'success';
            $message['message'] = "Cập nhật thành công !";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Cập nhật thất bại !";
        }
        $this->returnJson($message);
    }

    public function ajax_update_field(){
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        $field = $this->input->post('field');
        $value = $this->input->post('value');
        $response = $this->_itme->update(['id' => $id], [$field => $value]);
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
        $response = $this->_itme->deleteArray('id',$ids);
        if($response != false){
            $message['type'] = 'success';
            $message['message'] = "Xóa thành công !";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Xóa thất bại !";
        }
        $this->returnJson($message);
    }
    public function uploadimg()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
	    //Bước 1: Tạo thư mục lưu file
	    $url = base_url();
	    $error = array();
	    $target_dir = "public/uploads/ductam/";
	    $target_file = $target_dir . basename($_FILES['file']['name']);
	    // Kiểm tra kiểu file hợp lệ
	    $type_file = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
	    $type_fileAllow = array('png', 'jpg', 'jpeg', 'gif');
	    if (!in_array(strtolower($type_file), $type_fileAllow)) {
	        $error['file'] = "File bạn vừa chọn hệ thống không hỗ trợ, bạn vui lòng chọn hình ảnh";
	    }
	    //Kiểm tra kích thước file
	    $size_file = $_FILES['file']['size'];
	    if ($size_file > 5242880) {
	        $error['file'] = "File bạn chọn không được quá 5MB";
	    }
	//Kiểm tra file đã tồn tại trê hệ thống
	    // if (file_exists($target_file)) {
	    //     $error['file'] = "File bạn chọn đã tồn tại trên hệ thống";
	    // }

	    if (empty($error)) {
	        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
	            $flag = true;
	            echo json_encode(array('status' => 'add_ok','file_path' => $target_file,'url' => $url));
	        } else {
	            echo json_encode(array('status' => 'error move file'));
	        }
	    } else {
	        echo json_encode(array('status' => $error['file']));
	    }
	}

    }
    public function ajax_reload()
	{
	    $data['listsp'] = $this->_itme->getDataItme(['trangthai <' => 3],['ngaynhan' => "desc"]);
	    $html = $this->load->view($this->template_path . 'itme/ajax_ductam', $data, TRUE);
	    echo $html;
	    exit();
	}
	public function ajax_sortFilter()
	{

		// $this->checkRequestPostAjax();
        // $data = $this->input->post();
        $dk = [];
        $sortval= $this->input->get("sortval");
        $sortkey= $this->input->get("sortkey");
        $order = '';
        if(!empty($sortkey)){
            $order = array($sortkey=>$sortval);
        }

        $filterkey = $this->input->get("filterkey");
        $filterval = $this->input->get("filterval");

        if(!empty($filterkey)){
        	$dk[$filterkey] = $filterval;
        	// array_merge($a,$b)
        }else{
        	$dk['trangthai <'] = 3;
        }
        
        $data['listsp'] = $this->_itme->getDataItme($dk,$order);
	    $html = $this->load->view($this->template_path . 'itme/ajax_ductam', $data, TRUE);
	    echo $html;
	    exit();
	}
	private function _validation(){
        $this->checkRequestPostAjax();
        $rules = [
            [
                'field' => "tenmay",
                'label' => "tenmay",
                'rules' => "trim|required|min_length[2]"
            ],[
                'field' => "servicetag",
                'label' => "servicetag",
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

    private function save_category($id, $category_id) {
    if (!empty($category_id)) {
        $this->_product->delete(['product_id'=>$id],'product_category');
        // $data_category[] = ["product_id" => $id, 'category_id' => $category_id];
        if(!empty($category_id)) foreach ($category_id as $category_idx){
            $tmp = ["product_id" => $id, 'category_id' => $category_idx];
            $data_category[] = $tmp;
        }

        if(!$this->_product->insertMultiple($data_category, 'product_category')){
            $message['type'] = 'error';
            $message['message'] = "Thêm product_category thất bại !";
            log_message('error', $message['message'] . '=>' . json_encode($data_category));
        }
    }

} 

        /*
     * send request
     */

    public static function sendRequest($url, $params = array(), $requestType = 'get', $token = '', $contentType = 'http', $returnError404 = false) {
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

/* End of file  */
/* Location: ./application/controllers/ */