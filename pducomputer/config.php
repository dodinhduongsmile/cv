<?php

date_default_timezone_set("asia/ho_chi_minh");
$root = realpath(dirname(__FILE__));
$domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';

$url = "http://";

$root = str_replace("\\",'/',$root);
$url .= $domain;

define('ASSET_VERSION', '1.6.9');
define('AMP_ASSET_VERSION', '1.0.0');
define('BASE_URL', $url.'/');//http://domain.com/
define('DOMAIN_PLAY', $url.'/');
define('BASE_ADMIN_URL', BASE_URL."admin/");
define('MEDIA_NAME',"public/media/"); //Tên đường dẫn lưu media
define('MEDIA_PATH',str_replace('\\','/',$root . DIRECTORY_SEPARATOR . MEDIA_NAME)); //Đường dẫn lưu media
define('USER_PATH',str_replace('\\','/',$root . DIRECTORY_SEPARATOR . "public/uploads/memberpdu/")); //Đường dẫn lưu media
define('PUBLIC_PATH',str_replace('\\','/',$root . DIRECTORY_SEPARATOR . "public/")); //public path
define('MEDIA_URL', BASE_URL . MEDIA_NAME);
define('TEMPLATES_ASSETS',BASE_URL . 'public/');


define('DB_DEFAULT_HOST','localhost');
define('DB_DEFAULT_USER','root');
define('DB_DEFAULT_PASSWORD','');
define('DB_DEFAULT_NAME','db_pducomputer');


define('MAINTAIN_MODE',FALSE); //Bảo trì thì bật

define('DEBUG_MODE', true);
define('CACHE_MODE', FALSE);
define('CACHE_FILE_MODE',FALSE);
define('CACHE_PREFIX_NAME','KS_');

define('MEDIA_HIDE_FOLDER', 'mcith|thumb|2019');
define('CACHE_ADAPTER',(!empty($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1') ? 'memcached' : 'file');
define('CACHE_TIMEOUT_LOGIN',1800);

//Config zalo
define('ZALO_APP_ID_CFG','1250780810165803242');
define('ZALO_APP_SECRET_KEY_CFG','Ui7fBnBF3r45Y3N1Igk9');
define('ZALO_CAL_BACK',BASE_URL.'auth/loginzalo');
//define('ZALO_OA_SECRET_KEY_CFG','APS_');
//Config zalo
define('API_KEY','bsyb9w9vu7njewraemygpam3');

define('FB_API','2618030124890231');
define('FB_SECRET','6257cf7cd74343b5527dd43efba55880');
define('FB_VER','v2.9');

define('GG_API','905435334446-60a7c0ikb1jm1anldff7fqjeuos7duk7.apps.googleusercontent.com');
define('GG_SECRET','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');
define('GG_KEY','AIzaSyCOBA11YRsaiqqftlxbwZG_4FZbhmO9Mes');//AIzaSyAhR8OG9cUL1jDfAAc6i35nt5Ki1ZJnykA
define('GG_rediect','http://pducomputer.com/googleapp/file_drive');

define('GG_CAPTCHA_MODE', FALSE);
define('GG_CAPTCHA_SITE_KEY','6LdnG70UAAAAAGf8iRAzYQt7oFpEGhWLeh1s1UW7');
define('GG_CAPTCHA_SECRET_KEY','6LdnG70UAAAAAIHDHvUHO0Pdlw4lgO9CWinYEcbM');

define('ROOT_UPLOAD_IMPORT_PATH', str_replace("\\", "/", dirname(__FILE__)) . '/public/uploads/');
define('HTTP_UPLOAD_IMPORT_PATH', BASE_URL . 'public/uploads/');