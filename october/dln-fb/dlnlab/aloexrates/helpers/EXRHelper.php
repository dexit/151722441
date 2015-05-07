<?php
namespace DLNLab\ALoExrates\Helpers;

use User;
use Session;
use Input;
use Response;

/**
 * Helpers class for SNSContacts.
 *
 * @author dinhln
 * @since 22/04/2015
 */
class EXRHelper
{

    /**
     * Function to check csrf token.
     *
     * @param string $token
     * @throws Illuminate\Session\TokenMismatchException
     * @return boolean
     */
    public static function checkToken($token = '')
    {
        if (!$token) {
            return false;
        }

        if (Session::token() != $token) {
            throw new Illuminate\Session\TokenMismatchException();
            return false;
        }

        return true;
    }

    /**
     * Function to get csrf token.
     *
     * @return string
     */
    public static function getToken()
    {
        return Session::token();
    }

    /**
     * Get custom message for SNSContacts.
     *
     * @return multitype:string
     */
    public static function getMessage()
    {
        return [
            'required' => 'Thuộc tính :attribute bắt buộc.',
            'email' => 'email',
            'confirmed' => 'confirmed',
            'required' => ':attribute bị thiếu',
            'array' => ':attribute phải đúng dạng array',
            'between' => ':attribute phải nằm trong khoảng :min - :max số.',
            'numeric' => ':attribute phải dùng dạng số',
            'alpha_num' => ':attribute không được có ký tự đặc biệt',
            'size' => ':attribute bị giới hạn :size ký tự',
            'min' => ':attribute phải lớn hơn :min',
            'max' => ':attribute phải nhỏ hơn :max',
            'regex' => ':attribute không hợp lệ',
            'boolean' => ':attribute phải là giá trị đúng hoặc sai'
        ];
    }

    /**
     * Common method for get error messages response.
     *
     * @param array $messages
     * @return Response
     */
    public static function getErrorMsg($messages = array())
    {
        return Response::json(array(
            'status' => 'error',
            'data' => $messages
        ), 500);
    }

    /**
     * Common method for get success response.
     *
     * @param array $data
     * @return Response
     */
    public static function getSuccess($data = array())
    {
        return Response::json(array(
            'status' => 'success',
            'data' => $data
        ), 200);
    }

    /**
     * Helper function for convert utf8 string become to slug
     *
     * @param string $str
     * @return boolean|Ambigous <string, mixed>
     */
    public static function slugUTF8($str = '')
    {
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

    /**
     * Helper function for build full-text-search string.
     *
     * @param array $data
     * @return boolean|string
     */
    public static function buildFullTextSearch($data = array())
    {
        if (!empty($data)) {
            return false;
        }

        $fulltext = '';
        foreach ($data as $i => $item) {
            if ($item) {
                $fulltext .= str_replace('-', ' ', self::slugUTF8(strtolower($item))) . ' ';
            }
        }

        return $fulltext;
    }

    /**
     * Helper function for get http content using curl.
     *
     * @param $url
     * @param array $fields
     * @param array $headers
     * @return json
     */
    public static function curl($url, $fields = array(), $headers = array())
    {
        try {
            $fields_string = '';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            if (count($fields))
            {
                //url-ify the data for the POST
                foreach ($fields as $key => $value) {
                    $fields_string .= $key . '=' . $value . '&';
                }
                rtrim($fields_string, '&');

                curl_setopt($ch, CURLOPT_POST, count($fields));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            }
            if (count($headers))
            {
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            }

            // Get the response and close the channel.
            $response = curl_exec($ch);

            curl_close($ch);

            return $response;
        } catch (\Exception $ex) {
            var_dump($ex);
            die();
        }
    }

    /**
     * Helper function for convert number to money.
     *
     * @param $value
     * @param string $symbol
     * @param int $decimals
     * @return string
     */
    public static function numberToMoney($value, $symbol = 'VND', $decimals = 2)
    {
        return ($value < 0 ? '-' : '') . number_format(abs($value), $decimals) . $symbol;
    }
}
