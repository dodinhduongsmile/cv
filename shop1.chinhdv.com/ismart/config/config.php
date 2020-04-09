<?php
session_start();//khai báo khi dùng session
ob_start();//khai báo khi dùng header();
/*
 * ---------------------------------------------------------
 * BASE URL
 * ---------------------------------------------------------
 * Cấu hình đường dẫn gốc của ứng dụng
 * Ví dụ: 
 * http://hocweb123.com đường dẫn chạy online 
 * http://localhost/yourproject.com đường dẫn dự án ở local
 * 
 */

$config['base_url'] = "http://shop1.chinhdv.com/ismart/";


$config['default_module'] = 'home';
$config['default_controller'] = 'index';
$config['default_action'] = 'index';












