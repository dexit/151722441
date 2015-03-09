<?php

namespace DLNLab\FBNews\Classes;

class HelperNews {
    
    public static function curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        // Set so curl_exec returns the result instead of outputting it.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Get the response and close the channel.
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }
    
}