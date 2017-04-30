<?php

// Persian date function this function is simillar than date function in PHP you can find more about it in http://persiandates.osp.ir
// It is convertor to and from Gregorian and shamsi Date calendars.
// Copyright (C) 2000  Roozbeh Pournader and Mohammad Toossi 
// Copyright (C) 2003-2007  Milad Rastian
// This program is free software; you can redistribute it and/or 
// modify it under the terms of the GNU General Public License 
// as published by the Free Software Foundation; either version 2 
// of the License, or (at your option) any later version. 
// 
// This program is distributed in the hope that it will be useful, 
// but WITHOUT ANY WARRANTY; without even the implied warranty of 
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
// GNU General Public License for more details. 
// 
// vesrion 1.0



function pdate($type, $maket = "now") {
    //set 1 if you want translate number to farsi or if you don't like set 0
    $transnumber = 0;
    ///chosse your timezone
    $TZhours = 0;
    $TZminute = 0;

    if ($maket == "now") {
        $year = date("Y");
        $month = date("m");
        $day = date("d");
        list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($year, $month, $day);
        $maket = pmktime(date("h") + $TZhours, date("i") + $TZminute, date("s"), $jmonth, $jday, $jyear);
    } else {
        $maket+=$TZhours * 3600 + $TZminute * 60;
        $date = date("Y-m-d", $maket);
        list( $year, $month, $day ) = preg_split('/-/', $date);

        list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($year, $month, $day);
    }

    $need = $maket;
    $year = date("Y", $need);
    $month = date("m", $need);
    $day = date("d", $need);
    $i = 0;
    while ($i < strlen($type)) {
        $subtype = substr($type, $i, 1);
        switch ($subtype) {

            case "A":
                $result1 = date("a", $need);
                if ($result1 == "pm")
                    $result.= "PM";
                else
                    $result.="AM";
                break;

            case "a":
                $result1 = date("a", $need);
                if ($result1 == "pm")
                    $result.= "PM";
                else
                    $result.="AM";
                break;
            case "d":
                list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($year, $month, $day);
                if ($jday < 10)
                    $result1 = "0" . $jday;
                else
                    $result1 = $jday;
                if ($transnumber == 1)
                    $result.=Convertnumber2farsi($result1);
                else
                    $result.=$result1;
                break;
            case "D":
                $result1 = date("D", $need);
                if ($result1 == "Thu")
                    $result1 = "&#1662;";
                else if ($result1 == "Sat")
                    $result1 = "&#1588;";
                else if ($result1 == "Sun")
                    $result1 = "&#1609;";
                else if ($result1 == "Mon")
                    $result1 = "&#1583;";
                else if ($result1 == "Tue")
                    $result1 = "&#1587;";
                else if ($result1 == "Wed")
                    $result1 = "&#1670;";
                else if ($result1 == "Thu")
                    $result1 = "&#1662;";
                else if ($result1 == "Fri")
                    $result1 = "&#1580;";
                $result.=$result1;
                break;
            case"F":
                list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($year, $month, $day);
                $result.=monthname($jmonth);
                break;
            case "g":
                $result1 = date("g", $need);
                if ($transnumber == 1)
                    $result.=Convertnumber2farsi($result1);
                else
                    $result.=$result1;
                break;
            case "G":
                $result1 = date("G", $need);
                if ($transnumber == 1)
                    $result.=Convertnumber2farsi($result1);
                else
                    $result.=$result1;
                break;
            case "h":
                $result1 = date("h", $need);
                if ($transnumber == 1)
                    $result.=Convertnumber2farsi($result1);
                else
                    $result.=$result1;
                break;
            case "H":
                $result1 = date("H", $need);
                if ($transnumber == 1)
                    $result.=Convertnumber2farsi($result1);
                else
                    $result.=$result1;
                break;
            case "i":
                $result1 = date("i", $need);
                if ($transnumber == 1)
                    $result.=Convertnumber2farsi($result1);
                else
                    $result.=$result1;
                break;
            case "j":
                list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($year, $month, $day);
                $result1 = $jday;
                if ($transnumber == 1)
                    $result.=Convertnumber2farsi($result1);
                else
                    $result.=$result1;
                break;
            case "l":
                $result1 = date("l", $need);
                if ($result1 == "Saturday")
                    $result1 = "&#1588;&#1606;&#1576;&#1607;";
                else if ($result1 == "Sunday")
                    $result1 = "&#1610;&#1603;&#1588;&#1606;&#1576;&#1607;";
                else if ($result1 == "Monday")
                    $result1 = "&#1583;&#1608;&#1588;&#1606;&#1576;&#1607;";
                else if ($result1 == "Tuesday")
                    $result1 = "&#1587;&#1607;&#32;&#1588;&#1606;&#1576;&#1607;";
                else if ($result1 == "Wednesday")
                    $result1 = "&#1670;&#1607;&#1575;&#1585;&#1588;&#1606;&#1576;&#1607;";
                else if ($result1 == "Thursday")
                    $result1 = "&#1662;&#1606;&#1580;&#1588;&#1606;&#1576;&#1607;";
                else if ($result1 == "Friday")
                    $result1 = "&#1580;&#1605;&#1593;&#1607;";
                $result.=$result1;
                break;
            case "m":
                list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($year, $month, $day);
                if ($jmonth < 10)
                    $result1 = "0" . $jmonth;
                else
                    $result1 = $jmonth;
                if ($transnumber == 1)
                    $result.=Convertnumber2farsi($result1);
                else
                    $result.=$result1;
                break;
            case "M":
                list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($year, $month, $day);
                $result.=monthname($jmonth);
                break;
            case "n":
                list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($year, $month, $day);
                $result1 = $jmonth;
                if ($transnumber == 1)
                    $result.=Convertnumber2farsi($result1);
                else
                    $result.=$result1;
                break;
            case "s":
                $result1 = date("s", $need);
                if ($transnumber == 1)
                    $result.=Convertnumber2farsi($result1);
                else
                    $result.=$result1;
                break;
            case "S":
                $result.="&#1575;&#1605;";
                break;
            case "t":
                $result.=lastday($month, $day, $year);
                break;
            case "w":
                $result1 = date("w", $need);
                if ($transnumber == 1)
                    $result.=Convertnumber2farsi($result1);
                else
                    $result.=$result1;
                break;
            case "y":
                list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($year, $month, $day);
                $result1 = substr($jyear, 2, 4);
                if ($transnumber == 1)
                    $result.=Convertnumber2farsi($result1);
                else
                    $result.=$result1;
                break;
            case "Y":
                list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($year, $month, $day);
                $result1 = $jyear;
                if ($transnumber == 1)
                    $result.=Convertnumber2farsi($result1);
                else
                    $result.=$result1;
                break;
            default:
                $result.=$subtype;
        }
        $i++;
    }
    return $result;
}

function pmktime($hour, $minute, $second, $jmonth, $jday, $jyear) {
    list( $year, $month, $day ) = jalali_to_gregorian($jyear, $jmonth, $jday);
    $i = mktime($hour, $minute, $second, $month, $day, $year);
    return $i;
}

///Find Day Begining Of Month
function mstart($month, $day, $year) {
    list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($year, $month, $day);
    list( $year, $month, $day ) = jalali_to_gregorian($jyear, $jmonth, "1");
    $timestamp = mktime(0, 0, 0, $month, $day, $year);
    return date("w", $timestamp);
}

//Find Number Of Days In This Month
function lastday($month, $day, $year) {
    $lastdayen = date("d", mktime(0, 0, 0, $month + 1, 0, $year));
    list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($year, $month, $day);
    $lastdatep = $jday;
    $jday = $jday2;
    while ($jday2 != "1") {
        if ($day < $lastdayen) {
            $day++;
            list( $jyear, $jmonth, $jday2 ) = gregorian_to_jalali($year, $month, $day);
            if ($pdate2 == "1")
                break;
            if ($pdate2 != "1")
                $lastdatep++;
        }
        else {
            $day = 0;
            $month++;
            if ($month == 13) {
                $month = "1";
                $year++;
            }
        }
    }
    return $lastdatep - 1;
}

//translate number of month to name of month
function monthname($month) {

    if ($month == "01")
        return "&#1601;&#1585;&#1608;&#1585;&#1583;&#1610;&#1606;";

    if ($month == "02")
        return "&#1575;&#1585;&#1583;&#1610;&#1576;&#1607;&#1588;&#1578;";

    if ($month == "03")
        return "&#1582;&#1585;&#1583;&#1575;&#1583;";

    if ($month == "04")
        return "&#1578;&#1610;&#1585;";

    if ($month == "05")
        return "&#1605;&#1585;&#1583;&#1575;&#1583;";

    if ($month == "06")
        return "&#1588;&#1607;&#1585;&#1610;&#1608;&#1585;";

    if ($month == "07")
        return "&#1605;&#1607;&#1585;";

    if ($month == "08")
        return "&#1570;&#1576;&#1575;&#1606;";

    if ($month == "09")
        return "&#1570;&#1584;&#1585;";

    if ($month == "10")
        return "&#1583;&#1610;";

    if ($month == "11")
        return "&#1576;&#1607;&#1605;&#1606;";

    if ($month == "12")
        return "&#1575;&#1587;&#1601;&#1606;&#1583;";
}

////here convert to  number in persian
function Convertnumber2farsi($srting) {
    $num0 = "&#1776;";
    $num1 = "&#1777;";
    $num2 = "&#1778;";
    $num3 = "&#1779;";
    $num4 = "&#1780;";
    $num5 = "&#1781;";
    $num6 = "&#1782;";
    $num7 = "&#1783;";
    $num8 = "&#1784;";
    $num9 = "&#1785;";

    $stringtemp = "";
    $len = strlen($srting);
    for ($sub = 0; $sub < $len; $sub++) {
        if (substr($srting, $sub, 1) == "0")
            $stringtemp.=$num0;
        elseif (substr($srting, $sub, 1) == "1")
            $stringtemp.=$num1;
        elseif (substr($srting, $sub, 1) == "2")
            $stringtemp.=$num2;
        elseif (substr($srting, $sub, 1) == "3")
            $stringtemp.=$num3;
        elseif (substr($srting, $sub, 1) == "4")
            $stringtemp.=$num4;
        elseif (substr($srting, $sub, 1) == "5")
            $stringtemp.=$num5;
        elseif (substr($srting, $sub, 1) == "6")
            $stringtemp.=$num6;
        elseif (substr($srting, $sub, 1) == "7")
            $stringtemp.=$num7;
        elseif (substr($srting, $sub, 1) == "8")
            $stringtemp.=$num8;
        elseif (substr($srting, $sub, 1) == "9")
            $stringtemp.=$num9;
        else
            $stringtemp.=substr($srting, $sub, 1);
    }
    return $stringtemp;
}

///end conver to number in persian

function div($a, $b) {
    return (int) ($a / $b);
}

function gregorian_to_jalali($g_y, $g_m, $g_d) {
    $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);





    $gy = $g_y - 1600;
    $gm = $g_m - 1;
    $gd = $g_d - 1;

    $g_day_no = 365 * $gy + div($gy + 3, 4) - div($gy + 99, 100) + div($gy + 399, 400);

    for ($i = 0; $i < $gm; ++$i)
        $g_day_no += $g_days_in_month[$i];
    if ($gm > 1 && (($gy % 4 == 0 && $gy % 100 != 0) || ($gy % 400 == 0)))
    /* leap and after Feb */
        $g_day_no++;
    $g_day_no += $gd;

    $j_day_no = $g_day_no - 79;

    $j_np = div($j_day_no, 12053); /* 12053 = 365*33 + 32/4 */
    $j_day_no = $j_day_no % 12053;

    $jy = 979 + 33 * $j_np + 4 * div($j_day_no, 1461); /* 1461 = 365*4 + 4/4 */

    $j_day_no %= 1461;

    if ($j_day_no >= 366) {
        $jy += div($j_day_no - 1, 365);
        $j_day_no = ($j_day_no - 1) % 365;
    }

    for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i)
        $j_day_no -= $j_days_in_month[$i];
    $jm = $i + 1;
    $jd = $j_day_no + 1;

    return array($jy, $jm, $jd);
}

function jalali_to_gregorian($j_y, $j_m, $j_d) {
    $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);



    $jy = $j_y - 979;
    $jm = $j_m - 1;
    $jd = $j_d - 1;

    $j_day_no = 365 * $jy + div($jy, 33) * 8 + div($jy % 33 + 3, 4);
    for ($i = 0; $i < $jm; ++$i)
        $j_day_no += $j_days_in_month[$i];

    $j_day_no += $jd;

    $g_day_no = $j_day_no + 79;

    $gy = 1600 + 400 * div($g_day_no, 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
    $g_day_no = $g_day_no % 146097;

    $leap = true;
    if ($g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */ {
        $g_day_no--;
        $gy += 100 * div($g_day_no, 36524); /* 36524 = 365*100 + 100/4 - 100/100 */
        $g_day_no = $g_day_no % 36524;

        if ($g_day_no >= 365)
            $g_day_no++;
        else
            $leap = false;
    }

    $gy += 4 * div($g_day_no, 1461); /* 1461 = 365*4 + 4/4 */
    $g_day_no %= 1461;

    if ($g_day_no >= 366) {
        $leap = false;

        $g_day_no--;
        $gy += div($g_day_no, 365);
        $g_day_no = $g_day_no % 365;
    }

    for ($i = 0; $g_day_no >= $g_days_in_month[$i] + ($i == 1 && $leap); $i++)
        $g_day_no -= $g_days_in_month[$i] + ($i == 1 && $leap);
    $gm = $i + 1;
    $gd = $g_day_no + 1;


    return array($gy, $gm, $gd);
}

/**
 * Returns a string formatted according to the given format string using the given
 * jalali date. format is optional and defaults to 'Y-m-d'.
 *
 * @param string $jal_date jalali date (YYYY-MM-DD) to be converted to gregorian
 * @param string $format format of the gregorian date (output)
 * @return string
 * @access public
 * @version 1.0
 */
function jal2grn($jal_date, $format = 'Y-m-d') {

    list($jal_year, $jal_month, $jal_day) = explode('-', $jal_date);

    $grn_date = jalali_to_gregorian($jal_year, $jal_month, $jal_day);

    return date($format, mktime(0, 0, 0, $grn_date[1], // gregorian month
                    $grn_date[2], // gregorian day
                    $grn_date[0])   // gregorian year
    );
}

function grn2jal($grn_date, $format = 'Y-m-d') {

    list($grn_year, $grn_month, $grn_day) = explode('-', $grn_date);

    $week_day = date('w', mktime(0, 0, 0, $grn_month, // gregorian month
                    $grn_day, // gregorian day
                    $grn_year)  // gregorian year
    );


    $jal_date = gregorian_to_jalali($grn_year, $grn_month, $grn_day);

    $week_days = array('یکﺶﻨﺒﻫ', 'ﺩﻮﺸﻨﺒﻫ', 'ﺲﻫ<200c>ﺸﻨﺒﻫ', 'چﻩﺍﺮﺸﻨﺒﻫ', 'پﻦﺠﺸﻨﺒﻫ', 'ﺞﻤﻌﻫ', 'ﺶﻨﺒﻫ');
    $jal_months = array(
        1 => 'ﻑﺭﻭﺭﺩیﻥ',
        'ﺍﺭﺩیﺐﻬﺸﺗ',
        'ﺥﺭﺩﺍﺩ',
        'ﺕیﺭ',
        'ﻡﺭﺩﺍﺩ',
        'ﺶﻫﺭیﻭﺭ',
        'ﻢﻫﺭ',
        'ﺂﺑﺎﻧ',
        'ﺁﺫﺭ',
        'ﺩی',
        'ﺐﻬﻤﻧ',
        'ﺎﺴﻔﻧﺩ'
    );

    $convmap = array(
        'Y' => $jal_date[0], // 4 digits year
        'y' => substr($jal_date[0] + 100, 1), // 2 digits year
        'm' => substr($jal_date[1] + 100, 1), // month number, with leading zeros
        'n' => $jal_date[1], // month number, without leading zeros
        'd' => substr($jal_date[2] + 100, 1), // day number, with leading zeros
        'j' => $jal_date[2], // day number, without leading zeros
        'F' => $jal_months[$jal_date[1]], // month name
        'l' => $week_days[$week_day], // A full textual representation of the day of the week
        'w' => $week_day,
    );

    return strtr($format, $convmap);
}

function getTime($moment) {
    list($date, $time) = explode(' ', $moment);
    $pos = strpos($time, '.');
    if ($pos !== false) {
        $pos_time = explode('.', $time);
        $time = $pos_time[0];
    }
    $total_time = $time . ' ' . grn2jal($date);
    return $total_time;
}

function trimTime($time) {
    $pos = strpos($time, '.');
    if ($pos !== false) {
        $pos_time = explode('.', $time);
        $time = $pos_time[0];
    }
    return $time;

}



if (!function_exists('is_leap')) {

    function is_leap($year) {
        $rem = array(1, 5, 9, 13, 1722, 26, 30);
        $divres = $year % 33;
        return in_array($divres, $rem);
        return (($year % 4 == 0) && ($year % 100 != 0 || $year % 400 == 0));
    }

}

function time_diff($diff) {
    $years = floor($diff / (365 * 60 * 60 * 24));
    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

    $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));

    $minuts = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);

    $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minuts * 60));

    $final = array('years' => $years,
        'months' => $months,
        'days' => $days,
        'hours' => $hours,
        'minuts' => $minuts,
        'seconds' => $seconds
    );
    //$final = $years .' years '. $months .' months '. $days . ' days '.$hours .' hours ' .$months .' months ' .$seconds .' seconds ';    
    return $final;
}



function time_diff_by_hour($diff) {  
    $hours = floor(($diff) / (60 * 60));
    $minutes = floor(($diff - $hours * 60 * 60) / 60);
    $seconds = floor(($diff - $hours * 60 * 60 - $minutes * 60));

    $final = array(		
        'hours' => $hours,
        'minutes' => $minutes,
        'seconds' => $seconds
    );    
    return $final;
}


function get_duration($diff) {
    $total = array();
    if ((int) $diff['years'] > 0) {
        $total['year'] = $diff['years'];
    }
    if ((int) $diff['months'] > 0) {
        $total['month'] = $diff['monyhs'];
    }
    if ((int) $diff['days'] > 0) {
        $total['day'] = $diff['days'];
    }
    if ((int) $diff['hours'] > 0) {
        $total['hour'] = $diff['hours'];
    }
    $total['minute'] = $diff['minuts'];
    $total['second'] = $diff['seconds'];
    return $total;
}

function get_duration_format($diff) {
    $total = array();    
    
     $total['hour'] = $diff['hours'];
    $total['minute'] = $diff['minuts'];
    $total['second'] = $diff['seconds'];
    $duration_str = sprintf("%s:%s:%s", $total['hour'], $total['minute'], $total['second']);
    return $duration_str;
        
}




function show_hours($diff) {
    $hours = floor(($diff ) / (60 * 60));
    $minuts = floor(($diff - $hours * 60 * 60) / 60);
    $seconds = floor(($diff - $hours * 60 * 60 - $minuts * 60));

    return $hours . ':' . $minuts . ':' . $seconds;
}

function get_diff_time($end_time, $start_time) {
    $time1 = strtotime($start_time);
    $time2 = strtotime($end_time);
    date_default_timezone_set("UTC");
    $diff = $time2 - $time1;
    return $diff;
}

function getGregorianDate($date_time) {
        list($date, $time) = explode(' ', $date_time);    
        return jal2grn($date) . " $time:0";
    }

function getJalaliDate($date_time) {
        list($date, $time) = explode(' ', $date_time);    
        return grn2jal($date,'Y/m/d') . " $time:0";
}

function getJalaliTime($date_time) {
        list($date, $time) = explode(' ', $date_time);    
        return "$time:0";
}

    function getJalali($date) {
        return grn2jal($date,'Y/m/d');
    }    

function getJalaliDateTime($date_time) {
    list($date, $time) = explode(' ', $date_time); 
    return  "$time:0".' '.grn2jal($date,'Y/m/d');      
}

function getMissionDays($start_time,$end_time) {
    $start_date = explode(" ", $start_time); 
     $end_date = explode(" ", $end_time); 
     $end = strtotime($end_date[0] . " +1 days");      
     $start = strtotime($start_date[0]);
     $diff = $end - $start;
     $result = time_diff($diff);             
     return $result['days'];
}



?>
