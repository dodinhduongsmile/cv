<?php

defined('BASEPATH') OR exit('No direct script access allowed');
$config['num_links'] = 2;//số mục hiển thị
$config['last_link'] = '››';
$config['first_link'] ='‹‹';
$config['enable_query_strings'] = TRUE;
$config['use_page_numbers'] = TRUE;
/*SET PARAM PAGE*/
$config['page_query_string'] = FALSE;
$config['query_string_segment'] = 'page';
/*SET PARAM PAGE*/
$config['reuse_query_string'] = TRUE;
$config['full_tag_open'] = '<div class="pagination-custom">';
$config['full_tag_close'] = '</div>';
$config['first_tag_open'] = '<span class="page ajaxpagination">';
$config['first_tag_close'] = '</span>';
$config['next_tag_open'] = '<span class="nextPage ajaxpagination">';
$config['next_tag_close'] = '</span>';
$config['prev_tag_open'] = '<span class="nextPage ajaxpagination">';
$config['prev_tag_close'] = '</span>';
$config['cur_tag_open'] = '<span class="page page-node current"><a href="javascript:;" class="page-link">';
$config['cur_tag_close'] = '</a></span>';
$config['num_tag_open'] = '<span class="page ajaxpagination">';
$config['num_tag_close'] = '</span>';
$config['last_tag_open'] = '<span class="page ajaxpagination">';
$config['last_tag_close'] = '</span>';

$config['prev_link'] = '<i class="fa fa-angle-double-left" aria-hidden="true"></i>';
$config['next_link'] = '<i class="fa fa-angle-double-right" aria-hidden="true"></i>';
$config['display_pages'] = true;
