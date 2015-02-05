<?php

namespace DLNLab\Classified\Classes;

class HelperClassified {
    
    public static function slug_utf8($str) {
        if (!$str)
            return false;
        $unicode = array(
            "a" => "á|à|ạ|ả|ã|ă|ắ|ằ|ặ|ẳ|ẵ|â|ấ|ầ|ậ|ẩ|ẫ|A|Á|À|Ạ|Ả|Ã|Ă|Ắ|Ằ|Ặ|Ẳ|Ẵ|Â|Ấ|Ầ|Ậ|Ẩ|Ẫ",
            "o" => "ó|ò|ọ|ỏ|õ|ô|ố|ồ|ộ|ổ|ỗ|ơ|ớ|ờ|ợ|ở|ỡ|O|Ó|Ò|Ọ|Ỏ|Õ|Ô|Ố|Ồ|Ộ|Ổ|Ỗ|Ơ|Ớ|Ờ|Ợ|Ở|Ỡ",
            "e" => "é|è|ẹ|ẻ|ẽ|ê|ế|ề|ệ|ể|ễ|E|É|È|Ẹ|Ẻ|Ẽ|Ê|Ế|Ề|Ệ|Ể|Ễ",
            "u" => "ú|ù|ụ|ủ|ũ|ư|ứ|ừ|ự|ử|ữ|U|Ú|Ù|Ụ|Ủ|Ũ|Ư|Ứ|Ừ|Ự|Ử|Ữ",
            "i" => "í|ì|ị|ỉ|ĩ|I|Í|Ì|Ị|Ỉ|Ĩ",
            "y" => "ý|ỳ|ỵ|ỷ|ỹ|Y|Ý|Ỳ|Ỵ|Ỷ|Ỹ",
            "d" => "đ|D|Đ",
            "b" => "B",
            "c" => "C",
            "f" => "F",
            "g" => "G",
            "h" => "H",
            "j" => "J",
            "k" => "K",
            "l" => "L",
            "m" => "M",
            "n" => "N",
            "p" => "P",
            "q" => "Q",
            "r" => "R",
            "s" => "S",
            "t" => "T",
            "v" => "V",
            "w" => "W",
            "x" => "X",
            "z" => "Z",
            '' => '- |--',
            '' => '-',
            ' ' => '\/',
            '' => ',|:',
            '-' => ' '
        );
        foreach ($unicode as $nonUnicode => $uni)
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        return $str;
    }
    
    public static function trim_value($value) {
        if (! $value)
            return null;
        
        return trim($value);
    }
}