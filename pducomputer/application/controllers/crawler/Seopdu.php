<?php
defined('BASEPATH') or exit('No direct script access allowed');

// require "public/simple_html_dom.php";

class Seopdu extends Public_Controller
{
    private $_tinhthanh; 
    private $_edu; 
     
    public function __construct(){ 
        parent::__construct();
        $this->load->model(['edu_model']);
        $this->_edu      = new Edu_model();
    } 

 public function index(){
        $dataAPI = $this->callCURL("https://provinces.open-api.vn/api/",'','get');
        $data['listCity'] = json_decode($dataAPI); //json_decode($dataAPI,true) thì sẽ là return array
        // dd($data);
        $this->load->view($this->template_path . 'itme/tinhthanh' , $data, false);
    }
public function getDistric()
{
    $this->checkRequestGetAjax();
    $code = $this->input->get("code");

    $dataAPI = $this->callCURL("https://provinces.open-api.vn/api/p/{$code}?depth=2",'','get');
    echo $dataAPI;
    exit();
    // $listdis = json_decode($dataAPI);
    // dd($listdis);
    
}

public function getWard()
{
    $this->checkRequestGetAjax();
    $code = $this->input->get("code");

    $dataAPI = $this->callCURL("https://provinces.open-api.vn/api/d/{$code}?depth=2",'','get');
    // $listdis = json_decode($dataAPI);
    // dd($listdis);
    echo $dataAPI;
    exit();
    
    
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
}//endproductpdu

