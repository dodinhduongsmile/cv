<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| BREADCRUMB CONFIG
| -------------------------------------------------------------------
| This file will contain some breadcrumbs' settings.
|
| $config['crumb_divider']		The string used to divide the crumbs
| $config['tag_open'] 			The opening tag for breadcrumb's holder.
| $config['tag_close'] 			The closing tag for breadcrumb's holder.
| $config['crumb_open'] 		The opening tag for breadcrumb's holder.
| $config['crumb_close'] 		The closing tag for breadcrumb's holder.
|
| Defaults provided for twitter bootstrap 2.0
*/
$config['crumb_divider'] = '<li class="m-nav__separator"> - </li>';
$config['tag_open'] = '<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">';
$config['tag_close'] = '</ul>';
$config['crumb_open'] = '<li class="m-nav__item">';
$config['crumb_first_open'] = '<li class="m-nav__item m-nav__item--home">';
$config['crumb_last_open'] = '<li class="m-nav__item">';
$config['crumb_close'] = '</li>';

//cau hinh html brecrumb
$config['frontend_crumb_divider'] = '';
$config['frontend_tag_open'] = '<div class="breadcrumb-small"><a href="/" title="Quay trở về trang chủ">Trang chủ</a><span aria-hidden="true"> / </span>';
$config['frontend_tag_close'] = '</div>';
$config['frontend_crumb_open'] = '<span>';
$config['frontend_crumb_last_open'] = '<li class="active ccccccc">';
$config['frontend_crumb_close'] = '</span><span aria-hidden="true"> / </span>';
/* End of file breadcrumbs.php */
/* Location: ./application/config/breadcrumbs.php */
