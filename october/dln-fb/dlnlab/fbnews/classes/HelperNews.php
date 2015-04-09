<?php

namespace DLNLab\FBNews\Classes;

class HelperNews {
    
    public static function curl($url, $fields = array()) {
        try {
            $fields_string = '';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            if (count($fields)) {
                //url-ify the data for the POST
                foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
                rtrim($fields_string, '&');

                curl_setopt($ch, CURLOPT_POST, count($fields));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            }

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

    public static function postCommentToFB($fbPostId = 0, $name, $link = '') {
        if (! $fbPostId || ! $name && ! $link) {
            return null;
        }

        $link    = self::genBitly($link);
        $message = FB_COMMENT_PATTERN . $name . "\n" . $link;

        // Build data
        $url = FB_GRAPH . $fbPostId . '/comments?access_token=' . PAGE_TOKEN;
        $fields = array(
            'message' => $message
        );

        // Post to FB
        $response = self::curl($url, $fields);

        return $response;
    }
    
}