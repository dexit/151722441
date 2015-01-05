<?php
abstract class SocialAutoPoster_Abstract {
    
    protected $_errors = array();
    protected $_intersectOptions = true;
    protected $_options = array();
    protected $_defaultOptions = array();
    
    public function __construct($options = array()){
        $this->_mergeOptions($options);
        $this->_init();
    }
    
    protected function _init(){}
    
    protected function _mergeOptions($options = array()){
        if($this->_intersectOptions){
            $options = array_intersect_key((array)$options,(array)$this->_defaultOptions);
        }
        $this->_options = array_merge((array)$this->_defaultOptions,(array)$options);
    }
     
    protected function _getOption($key = null,$array = false){
        $value = $this->_handleCall($key,$this->_options,null,false,true);
        return ($array ? (array)$value : $value);
    }
    
    protected function _setOption($key,$value){
        $this->_handleCall($key,$this->_options,$value);
    }
    
    protected function _addOption($key,$value){
        $this->_handleCall($key,$this->_options,$value,true);
    }
    
    protected function _addError($error = ''){
        $this->_errors[] = $error;
    }
    
    public function getErrors(){
        return $this->_errors;
    }
    
    public function isHaveErrors(){
        return (count($this->_errors) ? true : false);
    }
    
    final private function _handleCall($key,&$data,$value = null,$valueAsArray = false,$get = false,$separator = '/'){
        $keys = explode($separator,$key);
        $firstKey = $keys[0];
        if(!isset($data[$firstKey])){
            if($get){
                return null;
            }else{ 
                $data[$firstKey] = null;
            }
        }
        $keys = array_slice($keys,1,count($keys));
        if(count($keys)){
            return $this->_handleCall(implode($separator,$keys),$data[$firstKey],$value,$valueAsArray,$get,$separator);
        }else{
            if($get){
                return $data[$firstKey];
            }else{
                if($valueAsArray){
                    if(!is_array($data[$firstKey])){
                        $data[$firstKey] = array();
                    }
                    $data[$firstKey][] = $value;
                }else{
                    $data[$firstKey] = $value;
                }
            }
        }
        return null;
    }
    
    protected function _sendRequest($options){
        $curl = curl_init();
        $options[CURLOPT_HEADER] = TRUE;
        curl_setopt_array($curl,$options);
        $result = curl_exec($curl);
        $headerPos = curl_getinfo($curl,CURLINFO_HEADER_SIZE);
        $header = substr($result,0,$headerPos);
        $response = array(
            'header' => $header,
            'body' => substr($result,$headerPos),
            'cookies' => array(),
            'status' => 0
        );
        if($header){
            preg_match_all("/Set-Cookie: (.+)/i",$header,$match);
            if(isset($match[1]) && $match[1] && is_array($match[1])){
                foreach($match[1] as $item){
                    $aCp = explode(';',$item);
                    if(isset($aCp[0]) && $aCp[0]){
                        $aCVp = explode('=',$aCp[0],2);
                        if(isset($aCVp[0]) && isset($aCVp[1])){
                            $response['cookies'][$aCVp[0]] = $aCVp[1];
                        }
                    }
                }
            }
            if(preg_match("/HTTP\/1\.1 200 OK/i",$header,$match)){
                $response['status'] = 1;
            }
        }
        curl_close($curl);
        return $response;
    } 

}
