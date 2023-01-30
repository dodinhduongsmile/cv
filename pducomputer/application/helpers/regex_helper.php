<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('toNormalTitle')) {
    function toNormalTitle ($str) {
        $str = str_replace("'", '', $str);
        $str = str_replace('"', '', $str);
        return $str;
    }
}
