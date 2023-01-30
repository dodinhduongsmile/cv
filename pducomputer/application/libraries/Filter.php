<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
if(!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *Class Filter:
 *  function injection($str): Filter SQL Injection (~`#%'"\--ar( )
 *  function html($str): Filter ma HTML
 *  function injection_html($str): Filter ma HTML va SQL Injection
 *  function link($link): Load bo tien to http:// ra khoi $link
 *  function clear($str): Loai bo tat ca cac ky tu dac biet (~`#%&'"\/<>) trong $str
 **/
class Filter
{
    function injection($str)
    {
        $str = str_replace("~", "&tilde;", $str);
        $str = str_replace("`", "&lsquo;", $str);
        $str = str_replace("#", "&curren;", $str);
        $str = str_replace("%", "&permil;", $str);
        $str = str_replace("'", "&rsquo;", $str);
        $str = str_replace("\"", "&quot;", $str);
        $str = str_replace("\\", "&frasl;", $str);
        $str = str_replace("--", "&ndash;&ndash;", $str);
        $str =  str_replace("ar(", "ar&Ccedil;", $str);
        $str =  str_replace("Ar(", "Ar&Ccedil;", $str);
        $str =  str_replace("aR(", "aR&Ccedil;", $str);
        $str =  str_replace("AR(", "AR&Ccedil;", $str);
        return $str;
    }

    function html($str)
    {
        return htmlspecialchars($str);
    }

    function injection_html($str)
    {
        return $this->injection($this->html($str));
    }

    function link($link)
    {
        $link = str_replace("http://", "", strtolower((string)$link));
        $link = ereg_replace("[^a-zA-Z0-9./_-]", "", strtolower((string)$link));
        return $link;
    }

    function clear($str)
    {
        $str = str_replace("~", "", $str);
        $str = str_replace("`", "", $str);
        $str = str_replace("#", "", $str);
        $str = str_replace("%", "", $str);
        $str = str_replace("&", "", $str);
        $str = str_replace("'", "", $str);
        $str = str_replace("\"", "", $str);
        $str = str_replace("\\", "", $str);
        $str = str_replace("/", "", $str);
        $str = str_replace("<", "", $str);
        $str = str_replace(">", "", $str);
        return $str;
    }
}