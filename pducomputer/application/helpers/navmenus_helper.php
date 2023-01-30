<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('navMenuTop')) {
    function navMenuTop($classname = '', $id = '', $submenuclass = ''){
        return menus(0, $classname, $id, $submenuclass);
    }
}
if (!function_exists('navMenuMain')) {
    function navMenuMain($classname = '', $id = '', $submenuclass = ''){
        return menusHome(0, $classname, $id, $submenuclass);
    }
}

if (!function_exists('navMenuMainMobile')) {
    function navMenuMainMobile($classname = '', $id = '', $submenuclass = ''){
        return menusHome(4, $classname, $id, $submenuclass);
    }
}

if (!function_exists('navMenuFooter')) {
    function navMenuFooter($classname = '', $id = '', $submenuclass = ''){
        return menus(1, $classname, $id, $submenuclass);
    }
}

if (!function_exists('navMenuFooter2')) {
    function navMenuFooter2($classname = '', $id = '', $submenuclass = ''){
        return menus(3, $classname, $id, $submenuclass);
    }
}

function menus($location, $classname, $id, $submenuclass){
    $ci =& get_instance();
    $ci->load->model('menus_model');
    $ci->load->library('NavsMenu');
    $ci->load->helper('link');
    $menuModel = new Menus_model();
    $q = $menuModel->getMenu($location);
    $menuModel->listmenu($q);
    $listMenu = $menuModel->listmenu;
    $navsMenu = new NavsMenu();
    $navsMenu->set_items($listMenu);
    $config["nav_tag_open"]          = "<ul id='$id' class='$classname'>";
    $config["parent_tag_open"]       = "<li class='%s'>";
    if($location == 1){
        $config["item_anchor"]          = "<a href=\"%s\" title=\"%s\">%s</a>";
        $config["parent_anchor"]          = "<a href=\"%s\" title=\"%s\">%s</a>";
    }
    $config["item_active_class"]       = "active";
    $config["children_tag_open"]     = "<ul class='$submenuclass'>";
    $navsMenu->initialize($config);
    $menuHtml = $navsMenu->render();
    return $menuHtml;

}
function menusHome($location, $classname, $id, $submenuclass){
    $ci =& get_instance();
    $ci->load->model('menus_model');
    $ci->load->library('NavsMenu');
    $ci->load->helper('link');
    $menuModel = new Menus_model();
    $q = $menuModel->getMenu($location);
    $menuModel->listmenu($q);
    $listMenu = $menuModel->listmenu;
    $navsMenu = new NavsMenu();
    $navsMenu->set_items($listMenu);
    $config["nav_tag_open"]          = "<ul id='$id' class='$classname'>";
    $config["item_tag_open"]     = '<li class="'.$classname.'-item">';
    $config["item_tag_close"]    = '</li>';
    $config["item_active_class"] = 'active';
    $config["children_tag_open"]     = "<ul class='$submenuclass'>";
    $navsMenu->initialize($config);
    $menuHtml = $navsMenu->render();
    return $menuHtml;

}


?>
