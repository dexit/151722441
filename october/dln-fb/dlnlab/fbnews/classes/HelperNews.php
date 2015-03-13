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
    
}