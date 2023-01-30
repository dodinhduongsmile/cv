<?php defined('BASEPATH') OR exit('No direct script access allowed');
// $config['protocol'] = 'smtp';
// $config['smtp_host'] = 'smtp.gmail.com';//smtp.gmail.com
// $config['smtp_hostssl'] =  'ssl://smtp.googlemail.com' ;
// $config['smtp_user'] = 'themepdu@gmail.com';
// $config['smtp_pass'] = 'computer1997';
// $config['smtp_port'] = 587;
// $config['smtp_portssl'] = 465;
// $config['charset'] = 'utf-8';
// $config['mailtype'] = 'html';
// $config['newline'] = "\r\n";
// $config['crlf'] = "\r\n";
// $config['wordwrap'] = TRUE;


//godaddy
// $config = array(
//     'protocol' => 'ssmtp', // 'mail', 'sendmail', or 'smtp'
//     'smtp_host' => 'smtp.gmail.com',
//     'smtp_hostssl' => 'ssl://ssmtp.googlemail.com',
//     'smtp_port' => 587,
//     'smtp_portssl' => 465,
//     'smtp_user' => 'themepdu@gmail.com',
//     'smtp_pass' => 'computer1997',
//     'mailtype' => 'html', //plaintext 'text' mails or 'html'
//     'smtp_timeout' => '4', //in seconds
//     'charset' => 'utf-8',
//     'wordwrap' => TRUE
// );

//send mail inet
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://smtp.googlemail.com';
$config['smtp_user'] = 'themepdu@gmail.com';
$config['smtp_pass'] = 'ubahyauemwkudbbl';
$config['smtp_port'] = 465;
$config['charset'] = 'utf-8';
$config['_smtp_auth'] = true;
$config['mailtype'] = 'html';
$config['newline'] = "\r\n";
$config['crlf'] = "\r\n";
$config['wordwrap'] = TRUE;