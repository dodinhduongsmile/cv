<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['default'] = 'home';
$route['translate_uri_dashes'] = FALSE;
$route['404.html'] = 'page/notfound';
$route['admin'] = 'admin/dashboard';

//product
$route['pdu(:num)_(:any).html'] = 'product/detail/$1';
$route['pd(:num)_(:any).html'] = 'product/category/$1';
$route['pd(:any)_(:any).html/page/(:num)'] = 'product/category/$1/$3';

//product_type
$route['dh(:num)_(:any).html'] = 'product/product_type/$1';
$route['dh(:any)_(:any).html/page/(:num)'] = 'product/product_type/$1/$3';
//post
$route['ad(:num)_(:any).html'] = 'post/detail/$1';
$route['ac(:num)_(:any).html'] = 'post/category/$1';
$route['ac(:any)_(:any).html/page/(:num)'] = 'post/category/$1/$3';
//edu
$route['ed(:num)_(:any).html'] = 'edu/detail/$1';
$route['edu(:num)_(:any).html'] = 'edu/category/$1';
$route['edu(:any)_(:any).html/page/(:num)'] = 'edu/category/$1/$3';
//detail codesale
$route['voucher(:num)_(:any).html'] = 'post/detail_codesale/$1';
//cart
$route['cart.html'] = 'cart/index';
$route['thanhtoan.html'] = 'cart/checkout';
$route['done.html'] = 'cart/done';
//search
$route['pa_ket-qua-tim-kiem.html'] = 'search/index';
$route['pa_ket-qua-tim-kiem.html/(:num)'] = 'search/index/$1';
//page action
$route['am_(:any).html'] = 'page/build_pc/$1';
// $route['am_(:any).html/page/(:num)']    = 'page/build_pc/$1/$2';
//in bao gia
$route['print_bao_gia.html']  = 'page/print_bao_gia';
$route['vouchers_(:any).html']  = 'page/sale_voucher/$1';
$route['voucher(:num)_(:any).html']  = 'sale/detail/$1';
//page
$route['(:any).html']  = 'page/index/$1';
$route['sitemap.xml']  = 'seo/sitemap';

//user
$route['ref/(:any)']  = 'user/ref/$1';

