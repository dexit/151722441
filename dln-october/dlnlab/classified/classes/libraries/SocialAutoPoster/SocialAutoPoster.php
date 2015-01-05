<?php
define('SOCIALAUTOPOSTER_PATH',dirname(__FILE__).DIRECTORY_SEPARATOR);
define('SOCIALAUTOPOSTER_APIPATH',dirname(__FILE__).DIRECTORY_SEPARATOR.'api'.DIRECTORY_SEPARATOR);
define('SOCIALAUTOPOSTER_LIBPATH',dirname(__FILE__).DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR);

require_once SOCIALAUTOPOSTER_APIPATH."Abstract.php";

class SocialAutoPoster{
    
    public function getApi($api,$options = array()){
        try{
            $api = ucfirst(strtolower($api));
            if(!file_exists(SOCIALAUTOPOSTER_APIPATH.$api.".php")){
                throw new Exception("File \"$api.php\" not found");
            }
            include_once SOCIALAUTOPOSTER_APIPATH.$api.".php";
            $api = "SocialAutoPoster_".$api;
            return new $api($options);
        }catch(Exception $e){
            echo $e->getMessage();
            exit;
        }
    }

}
