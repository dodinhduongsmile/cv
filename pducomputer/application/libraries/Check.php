<?php
#****************************************#
# * @Author: tshopdn                     #
# * @Email: lvcuong2@gmail.com           #
# * @Website: http://www.tshopdn.com     #
# * @Copyright: 2012 - 2013              #
#****************************************#
if(!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *Class Check:
 *  function is_logined($user, $group, $type = 'admin'): Kiem tra da duoc dang nhap chua
 *  function is_allowed($permission = 'none', $action = ''): Kiem tra quyen truy cap
 *  function is_more($first, $second): Neu so $first > $second thi tra ve true. Nguoc lai tra ve false
 *  function is_same($firstStr, $secondStr): Neu $firstStr va $secondStr la giong nhau thi tra ve true. Nguoc lai tra ve false
 *  function is_phone($phone): Neu dung la so dien thoai theo qui dinh thi tra ve true, nguoc lai tra ve false
 *  function is_id($id): Kiem tra xem $id co phai la ID
 **/
class Check
{
	
   function is_logined($user, $group, $type = 'admin')
    {
       
        switch(strtolower($type))
        {
            case 'admin':
                if($user && trim($user) != '' && (int)$user > 0 && $group && trim($group) != '' && (int)$group >= 1)
                {
                    return true;
                }
                break;
            case 'home':
                if($user && trim($user) != '' && (int)$user > 0 && $group && trim($group) != '' && (int)$group > 0 && (int)$group < 1)
                {
                    return true;
                }
                break;
        }
        return false;
    }

    function is_allowed($permission = 'none', $action = '')
    {
        if($permission && trim($permission) != '' && strtolower($permission) == 'all')
        {
            return true;
        }
        elseif($permission && trim($permission) != '' && strtolower($permission) != 'none' && $action && trim($action) != '' && stristr($permission, $action))
        {
            return true;
        }
        return false;
    }

    function is_more($first, $second, $equal = true)
    {
        if($equal == true)
        {
            if((float)$first >= (float)$second)
            {
                return true;
            }
        }
        else
        {
            if((float)$first > (float)$second)
            {
                return true;
            }
        }
        return false;
    }

    function is_same($firstStr, $secondStr)
    {
        if((string)$firstStr === (string)$secondStr)
        {
            return true;
        }
        return false;
    }

    function is_phone($phone)
    {
        if(preg_match('/[^0-9().]/i', $phone))
        {
            return false;
        }
        return true;
    }

    function is_id($id)
    {
        if(preg_match('/[^0-9]/i', $id) || (int)$id <= 0)
        {
            return false;
        }
        return true;
    }
}
?>