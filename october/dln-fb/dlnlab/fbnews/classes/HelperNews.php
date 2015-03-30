<?php

namespace DLNLab\FBNews\Classes;

class HelperNews {
    
    public static function curl($url) {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

            // Get the response and close the channel.
            $response = curl_exec($ch);

            curl_close($ch);

            return $response;
        } catch (\Exception $ex) {
            var_dump($ex);die();
        }
    }

    public static function genBitly($longUrl = '') {
        if (empty($longUrl))
            return false;

        $url = "https://api-ssl.bitly.com/v3/shorten?longUrl={$longUrl}&access_token=" . BIT_TOKEN;
        $obj = json_decode(self::curl($url));

        if (empty($obj->data))
            return false;

        return $obj->data->url;
    }
    
}