<?php

namespace DLNLab\FBNews\Classes;

class HelperNews {
    
    public static function curl($url) {
        try {
            echo $url;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);

            // Set so curl_exec returns the result instead of outputting it.
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

            // Get the response and close the channel.
            $response = curl_exec($ch);


            echo curl_errno($ch) . '<br/>';
            echo curl_error($ch) . '<br/>';
            curl_close($ch);
            var_dump($response);die();

            return $response;
        } catch (\Exception $ex) {
            var_dump($ex);die();
        }
    }
    
}