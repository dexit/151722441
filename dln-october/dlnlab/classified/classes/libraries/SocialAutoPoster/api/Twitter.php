<?php
class SocialAutoPoster_Twitter extends SocialAutoPoster_Abstract{
    
    protected $_defaultOptions = array(
        'consumer_key' => null,
        'consumer_secret' => null,
        'access_token' => null,
        'access_secret' => null
    );
    
    protected $_twitter;
    
    protected function _init(){
        include_once SOCIALAUTOPOSTER_LIBPATH.'twitter/twitteroauth.php';
        $this->_twitter = new TwitterOAuth($this->_getOption('consumer_key'), $this->_getOption('consumer_secret'), $this->_getOption('access_token'), $this->_getOption('access_secret'));
        $user = $this->_twitter->get('account/verify_credentials');
        if(isset($user->error) && $user->error){
            $this->_addError($user->error);
        }
    }
    
    protected function _quoteMessage($message = ''){
        $message = strip_tags($message);
        return trim($message);
    }
    
    public function getTwitter(){
        return $this->_twitter;
    }
    
    public function postToWall($message = ''){
        if($message){
            try{
                $response = $this->getTwitter()->post('statuses/update', array('status' => $this->_quoteMessage($message)));
                if(isset($response->errors) && $response->errors && is_array($response->errors)){
                    foreach($response->errors as $item){
                        $this->_addError($item->message);
                    }
                }
            }catch(Exception $e){
                $this->_addError($e->getMessage());
            }
        }
    }
    
}
?>
