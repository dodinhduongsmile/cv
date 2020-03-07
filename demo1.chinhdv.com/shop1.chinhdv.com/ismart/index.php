<?php

/*
 * --------------------------------------------------------------------
 * app path, dirname(__FILE__); chính là url file hiện tại index.php
 * --------------------------------------------------------------------
 */

$app_path = dirname(__FILE__);
define('APPPATH', $app_path);
/*
 * --------------------------------------------------------------------
 * core path
 * --------------------------------------------------------------------
 */
$core_folder = 'core';
define('COREPATH', APPPATH.DIRECTORY_SEPARATOR.$core_folder);
// echo COREPATH; //in ra E:\xampp\htdocs\unitop\backend\lession\section29\ismart.com\core
// echo DIRECTORY_SEPARATOR; //in ra dấu \
/*
 * --------------------------------------------------------------------
 * modules path
 * --------------------------------------------------------------------
 */
$modules_folder = 'modules';
define('MODULESPATH', APPPATH.DIRECTORY_SEPARATOR.$modules_folder);


/*
 * --------------------------------------------------------------------
 * helper path
 * --------------------------------------------------------------------
 */

$helper_folder = 'helper';
define('HELPERPATH', APPPATH.DIRECTORY_SEPARATOR.$helper_folder);


/*
 * --------------------------------------------------------------------
 * library path
 * --------------------------------------------------------------------
 */
$lib_folder= 'libraries';
define('LIBPATH', APPPATH.DIRECTORY_SEPARATOR.$lib_folder);


/*
 * --------------------------------------------------------------------
 * layout path, định nghĩa đường dẫn layout, hằng số
 * --------------------------------------------------------------------
 */
$layout_folder= 'layout';
define('LAYOUTPATH', APPPATH.DIRECTORY_SEPARATOR.$layout_folder);

/*
 * --------------------------------------------------------------------
 * config path
 * --------------------------------------------------------------------
 */
$config_folder= 'config';
define('CONFIGPATH', APPPATH.DIRECTORY_SEPARATOR.$config_folder);

require COREPATH.DIRECTORY_SEPARATOR.'appload.php';
