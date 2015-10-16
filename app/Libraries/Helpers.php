<?php

class Helpers
{
    public static function human_datasize($bytes, $decimals = 2, $speed = false)
    {
        $sz = 'BKMGTP';


        if(is_object($bytes)){
            return $bytes;
        }
        if(is_null($bytes)) {
            return 'Unlimited';
        }

        if ($speed) {
            $suffix = 'bps';
        } else {
            $suffix = 'B';
        }

        $factor = floor((strlen($bytes) - 1) / 3);
        $str = sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
        if(substr($str, -1) !== 'B') {
            $str = $str . $suffix;
        }
        return $str;
    }

    public static function human_time($timestamp)
    {
        $years = floor($timestamp / 31536000);
        $days = floor(($timestamp - ($years*31536000)) / 86400);
        $hours = floor(($timestamp - ($years*31536000 + $days*86400)) / 3600);
        $minutes = floor(($timestamp - ($years*31536000 + $days*86400 + $hours*3600)) / 60);
        $seconds = floor(($timestamp - ($years*31536000 + $days*86400 + $hours*3600 + $minutes*60)));
        $timestring = '';
        if ($years > 0){
            $timestring .= $years . ' years ';
        }
        if ($days > 0) {
            $timestring .= $days . ' days ';
        }
        if ($hours > 0) {
            $timestring .= $hours . ' hrs';
        }
        if ($minutes > 0) {
            $timestring .= $minutes . ' mins';
        }
        if ($seconds > 0) {
            $timestring .= $seconds . ' secs';
        }

        return $timestring;
    }

    public static function format_timestamp($timestamp, $time = false)
    {
        if($timestamp == 0) {
            return null;
        } else if(is_string($timestamp)){
            $timestamp = strtotime($timestamp);
        }
        if ($time) {
            $date_string = Date('H:i:s jS M Y', $timestamp);
        } else {
            $date_string = Date('jS M Y', $timestamp);
        }
        return $date_string;
    }

    public static function refactory($array){
        $wasArray = true;
        if(is_object($array)){
            $wasArray = false;
            $array = (array) $array;
        }
        
        foreach ($array as $key => $value) {
            if(is_array($value)){
                $array[$key] = self::refactory($value);
            } else {
                if($value === '' || $value === 'NULL') {
                    $array[$key] = null;
                } else {
                    if (isset($array['magnitude']['data']) && array_key_exists($key, $array['magnitude']['data'])) {
                        $array[$key] = $array[$key] * pow(1024, $array['magnitude']['data'][$key]);
                    } else if (isset($array['magnitude']['time']) && array_key_exists($key, $array['magnitude']['time'])) {
                        if($array['magnitude']['time'][$key] == 'minutes') {
                            $array[$key] = $array[$key] * 60;
                        } else if($array['magnitude']['time'][$key] == 'hours') {
                            $array[$key] = $array[$key] * 60 * 60;
                        } else if($array['magnitude']['time'][$key] == 'days') {
                            $array[$key] = $array[$key] * 60 * 60 * 24;
                        } else if($array['magnitude']['time'][$key] == 'years') {
                            $array[$key] = $array[$key] * 60 * 60 * 24 * 365;
                        }
                    }
                }
            }
        }
        return $wasArray ? $array : (object) $array;
    }

    public static function human_formats($array){
        $wasArray = true;
        if(is_object($array)){
            $wasArray = false;
            $array = (array) $array;
        }
        foreach ($array as $key => $value) {
            if(is_array($value)){
                $array[$key] = self::human_formats($value);
            } else {
                if(strpos($key,'length') !== false 
                    || strpos($key,'_after') !== false 
                    || strpos($key,'timeout') !== false) {
                    $array[$key] = Helpers::human_time($value);
                } elseif (strpos($key, 'data') !== false) {
                    $array[$key] = Helpers::human_datasize($value);
                } elseif (strpos($key, 'speed') !== false) {
                    $array[$key] = Helpers::human_datasize($value, 1, true);
                } elseif (strpos($key, '_at') !== false && $array[$key] !== null) {
                    $array[$key] = Helpers::format_timestamp(strtotime($value), true);
                }
            }
        }
        return $wasArray ? $array : (object) $array;
    }

    public static function route_parameter($name, $default = null)
    {
        $routeInfo = app('request')->route();

        return array_get($routeInfo[2], $name, $default);
    }
}
