<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('timeAgo')) {
    function timeAgo($datetime, $full = false) {
        $now = new DateTime();
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'năm',
            'm' => 'tháng',
            'w' => 'tuần',
            'd' => 'ngày',
            'h' => 'giờ',
            'i' => 'phút',
            's' => 'giây',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        else return date($full, strtotime($datetime));
        return $string ? implode(', ', $string) . ' trước' : 'vừa xong';
    }
}

if (!function_exists('day_of_week_vn')) {
    function day_of_week_vn ($day_of_week = '') {
        if ($day_of_week == '') {
            $day_of_week = date('N');
        }
        switch ($day_of_week) {
            case 1 : $day = 'Thứ hai'; break;
            case 2 : $day = 'Thứ ba'; break;
            case 3 : $day = 'Thứ tư'; break;
            case 4 : $day = 'Thứ năm'; break;
            case 5 : $day = 'Thứ sáu'; break;
            case 6 : $day = 'Thứ bảy'; break;
            default : $day = 'Chủ nhật';
        }
        return $day;
    }
}


if (!function_exists('month_vn')) {
    function month_vn ($month = ''){
        if ($month == '') {
            $month = date('n');
        }

        switch ($month) {
            case 1 : $month = 'Tháng Một'; break;
            case 2 : $month = 'Tháng Hai'; break;
            case 3 : $month = 'Tháng Ba'; break;
            case 4 : $month = 'Tháng Tư'; break;
            case 5 : $month = 'Tháng Năm'; break;
            case 6 : $month = 'Tháng Sáu'; break;
            case 7 : $month = 'Tháng Bảy'; break;
            case 8 : $month = 'Tháng Tám'; break;
            case 9 : $month = 'Tháng Chín'; break;
            case 10 : $month = 'Tháng Mười'; break;
            case 11 : $month = 'Tháng Mười Một'; break;
            case 12 : $month = 'Tháng Mười Hai'; break;
        }

        return $month;
    }
}

if (!function_exists('diff_time_vn')) {
    function diff_time_vn ($time_compare){
        $today = date('Y-m-d', time());
        $now = new DateTime($today);
        $time_compare = new DateTime($time_compare);
        $interval = date_diff($now, $time_compare);
        $diff_time = $interval->format('%R%a');
        switch ($diff_time) {
            case '-1' :
                $text = 'Hôm qua';
                break;
            case '0' :
                $text = 'Hôm nay';
                break;
            case '+1':
                $text = 'Ngày mai';
                break;
            default :
                $text = date('d/m', strtotime("$diff_time day"));
                break;
        }
        return $text;

    }
}


if(!function_exists('time_GMT_7x')) {
    function time_GMT_7x ($str,$fomat='d/m/Y'){
        $str = new DateTime($str);
        $str->setTimezone(new DateTimeZone(('Asia/Ho_Chi_Minh')));
//        $str->modify("+7 hour");
        return $str->format($fomat);
    }
}