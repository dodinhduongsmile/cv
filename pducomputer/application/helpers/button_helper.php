<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('button_admin')) {
    function button_admin($args = array('add', 'delete'))
    {
        $_this =& get_instance();
        $controller = $_this->uri->segment(2);
        if ($_this->session->userdata['user_id'] == 1) {//nếu là admin thì hiện luôn
            showButtonAdd().showButtonDelete().showButtonReload();
        } else {
            if (in_array('add', $args)) {
                if (isset($_this->session->admin_permission[$controller]['add'])) {
                    showButtonAdd();
                }
            }
            if (in_array('delete', $args)) {
                if (isset($_this->session->admin_permission[$controller]['delete'])) {
                    showButtonDelete();
                }
            }
            showButtonReload();
        }
    }
}
if (!function_exists('showButtonAdd')) {
    function showButtonAdd()
    {
        echo '<a href="javascript:;" class="btn btn-primary m-btn m-btn--icon m-btn--air m-btn--pill btnAddForm">
                <span>Add</span>
            </a> ';
    }
}
//nếu không tồn tại hàm showButtonDelete ở chỗ khác, thì nó mới có hàm này
if (!function_exists('showButtonDelete')) {
    function showButtonDelete()
    {
        echo '<a href="javascript:;" class="btn btn-danger m-btn m-btn--icon m-btn--air m-btn--pill btnDeleteAll">
                <span>Delete</span>
            </a> ';
    }
}

if (!function_exists('showButtonReload')) {
    function showButtonReload()
    {
        echo '<a href="javascript:;" class="btn btn-info m-btn m-btn--icon m-btn--air m-btn--pill btnReload">
                <span>Refresh</span>
            </a>';
    }
}
