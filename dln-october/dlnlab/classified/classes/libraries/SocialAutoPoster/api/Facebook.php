<?php
class SocialAutoPoster_Facebook extends SocialAutoPoster_Abstract{
    
    protected $_defaultOptions = array(
        'page_id' => null,
        'appid' => null,
        'appsecret' => null,
        'access_token' => null,
        'redirect_uri' => null
    );
    
    protected $_facebook;
    
    protected function _init(){
        include_once SOCIALAUTOPOSTER_LIBPATH.'facebook/facebook.php';
        $this->_facebook = new Facebook(array(
          'appId'  => $this->_getOption('appid'),
          'secret' => $this->_getOption('appsecret')
        ));
        $accessToken = $this->_getOption('access_token');
        if($accessToken){
            $this->_facebook->setAccessToken($accessToken);
        }else{
            $this->getAccessToken();
        }
    }
    
    protected function _quoteMessage($message = ''){
        $message = strip_tags($message);
        return trim($message);
    }
    
    public function getFacebook(){
        return $this->_facebook;
    }
    
    public function getAccessToken(){
        return $this->getFacebook()->getAccessToken();
    }
    
    public function getLoginBox($options = array()){
        $html = '';
        $user = $this->getFacebook()->getUser();
        if ($user) {
            try{
                $user = $this->getFacebook()->api('/me');
            }catch(FacebookApiException $e) {
                $this->_addError($e->getMessage());
            }
        }
        if($user){
            $redirect_uri = isset($options['next']) ? $options['next'] : $this->_getOption('redirect_uri');
            $html .= 'You logged in as '.$user['name'].'. <a target="_blank" href="'.$this->getFacebook()->getLogoutUrl(array('next'=>$redirect_uri)).'">Logout</a>';
        }else{
            $redirect_uri = isset($options['redirect_uri']) ? $options['redirect_uri'] : $this->_getOption('redirect_uri');
            $href = $this->getFacebook()->getLoginUrl(array('redirect_uri'=>$redirect_uri,'scope'=>'publish_stream'));
            $html .= '<a href="#" onclick=\'window.open("'.$href.'", "Facebook","height=500,resizable=yes,scrollbars=yes,status=yes");return false;\' >Authorize on Facebook</a>';
        }
        return $html;
    }
    
    public function destroy(){
        $this->getFacebook()->destroySession();
    }
    
    public function postToWall($message = ''){
        try{
            $token = $this->getFacebook()->getAccessToken();
            return $this->getFacebook()->api('/'.$this->_getOption('page_id').'/feed', 'post', array(
                'access_token' => $token,
                'message' => $this->_quoteMessage($message)
            ));
        }catch(Exception $e){
            $this->_addError($e->getMessage());
            return null;
        }
    }
    
}
?>
