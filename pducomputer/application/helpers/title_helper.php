<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('getTitle')) {
    function getTitle($oneData = []){
        $_this =& get_instance();
        $_this->load->model('setting_model');
        $settings = $_this->setting_model->getAll();
        $setting_title = !empty($settings['title']) ? $settings['title'] : '';
        if(!empty($oneData)) $title = !empty($oneData->meta_title)?$oneData->meta_title:(!empty($oneData->title)?$oneData->title:'');
        else $title = $setting_title;
        return str_replace('"','\'',$title)." - ".$setting_title;
    }
}
