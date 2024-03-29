<?php
class SocialAutoPoster_Googleplus extends SocialAutoPoster_Abstract{
    
    protected $_defaultOptions = array(
         'page_id' => ''
        ,'email' => ''
        ,'pass' => ''
        ,'uagent' => 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1'
        ,'login_url' => 'https://accounts.google.com/ServiceLogin'
        ,'logout_url' => 'https://www.google.com/m/logout'
        ,'post_page' => 'https://plus.google.com/b/$PAGE_ID/$PAGE_ID/posts'
        ,'post_url' => 'https://plus.google.com/b/$PAGE_ID/_/sharebox/post'
        ,'auth_email_field' => 'Email'
        ,'auth_pass_field' => 'Passwd'
    );

    protected $_cookies = array();
    protected $_begin = false;
    protected $_at = null;
    
    protected function _setCookies($response = array()){
        if(count($response['cookies'])){
            $this->_cookies = array_merge($this->_cookies,$response['cookies']);
        }
    }
    
    protected function _getCookies(){
        $cookies = "";
        foreach($this->_cookies as $key => $value){
            $cookies .= $key."=".$value."; ";
        }
        return $cookies;
    }
    
    protected function _quoteMessage($message = ''){
        $message = addslashes($message);
        $message = strip_tags($message);
        $message = preg_replace("#\t#si",' ',$message);
        $message = preg_replace("#\n|\r#si",'\n',$message);
        $message = preg_replace('#(\\\n)+#si','\n',$message);
        return trim($message);
    }
    
    protected function _getAtToken($code = ''){
        if(!$this->_at){
            if(preg_match('#AObGSA.*:\d+#', $code, $match) && isset($match[0]) && $match[0]){
                $this->_at = $match[0];
            }else{
                $this->_addError('Access token parsing error');
            }
        }
        return $this->_at;
    }
    
    protected function _getPage($url,$post = null){
        $options = array(
             CURLOPT_USERAGENT => $this->_getOption('uagent')
            ,CURLOPT_URL => $url
            ,CURLOPT_COOKIE => $this->_getCookies()
            ,CURLOPT_RETURNTRANSFER => TRUE
            ,CURLOPT_FOLLOWLOCATION => TRUE
            ,CURLOPT_SSL_VERIFYPEER => FALSE
        );
        if($post){
            $options[CURLOPT_POST] = TRUE;
            $options[CURLOPT_POSTFIELDS] = $post;
        }
        $response = $this->_sendRequest($options);
        $this->_setCookies($response);
        return $response;
    }

    protected function _getLoginData(){
        $response = $this->_getPage($this->_getOption('login_url'));
        $this->_setCookies($response);
        $buf = html_entity_decode($response['body']);
        $buf = utf8_decode($buf);
        $buf = str_replace( '&amp;', '&', $buf ); 
        $buf = str_replace( '&', '&amp;', $buf ); 
        $toreturn = '';
        $doc = new DOMDocument;
        $doc->loadHTML(utf8_encode($buf));
        $inputs = $doc->getElementsByTagName('input');
        $auth_email_field = $this->_getOption('auth_email_field');
        $auth_pass_field = $this->_getOption('auth_pass_field');
        foreach ($inputs as $input) {
            switch ($input->getAttribute('name')) {
                case $auth_email_field:
                $toreturn .= $auth_email_field.'=' . urlencode($this->_getOption('email')) . '&';
                break;
                case $auth_pass_field:
                $toreturn .= $auth_pass_field.'=' . urlencode($this->_getOption('pass')) . '&';
                break;
                default:
                $toreturn .= $input->getAttribute('name') . '=' . urlencode($input->getAttribute('value')) . '&';
            }
        }
        $toreturn = rtrim($toreturn, "&");
        return array($toreturn, $doc->getElementsByTagName('form')->item(0)->getAttribute('action'));
    }
    
    protected function _login(){
        $this->_cookies = array();
        $loginData = $this->_getLoginData();
        $response = $this->_getPage($loginData[1],$loginData[0]);
        var_dump($response);die();
        if(!$response['status'] || !isset($this->_cookies['SSID'])){
            $this->_addError('Authorization Error');
            return false;
        }
        return true;
    }
    
    protected function _logout(){
        $this->_getPage($this->_getOption('logout_url'));
    }
    
    public function begin($page_id = null){
        if($this->_login()){
            if($page_id){
                $this->_setOption('page_id',$page_id);
            }
            $page_id = $this->_getOption('page_id'); 
            if(!$page_id){
                $this->_addError('Page ID is empty');
                return false;
            } 
            $post_page = $this->_getOption('post_page');
            $post_page = str_replace('$PAGE_ID',$page_id,$post_page);
            $response = $this->_getPage($post_page); 
            if($this->_getAtToken($response['body'])){
                $this->_begin = true;
            }
        }
    }
    
    public function end(){
        $this->_logout();
    }
    
    public function postToWall($message = ''){   
        if($this->isHaveErrors()){
            $this->_logout();
            return false;
        }
        $message = $this->_quoteMessage($message);
        if(!$message){
            $this->_addError('Message is empty');
            $this->_logout();
            return false;
        }
        $page_id = $this->_getOption('page_id'); 
        if(!$page_id){
            $this->_logout();
            return false;
        } 
        if($this->_begin){
            $at = $this->_getAtToken();
            if($at){
                $post = array(
                    'at' => $at,
                    'f.req' => '["'.$message.'","oz:'.$page_id.'.'.(time()).'.0",null,null,null,null,"[]",null,null,true,[],false,null,null,[],null,false,null,null,null,null,null,null,null,null,null,null,false,false,false,null,null,null,null,null,null,[],[[[null,null,1]],null]]'
                );
                $post_url = $this->_getOption('post_url');
                $post_url = str_replace('$PAGE_ID',$page_id,$post_url);
                $response = $this->_getPage($post_url."/?spam=20&_reqid=".(time() % 1e6)."&rt=j",$post);
                if(!$response['status']){
                    $this->_addError('Posting Error');
                    $this->_logout();
                    return false;
                }
                return true;
            }
        }
    }
    
}
?>
