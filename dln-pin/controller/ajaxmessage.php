<?php
/**
 *      [PinTuXiu] (C)2001-2099 ONightjar.com Pintuxiu.com.
 *      This is NOT a freeware, use is subject to license terms
 */
class ajaxmessage extends basecontroller{

	public function __construct() {
		parent::__construct();
	}

	public function fetch(){
		$event = $this->spArgs("event");
		$event_arr = array('reward','alert','warn','user_message');
		if(!in_array($event, $event_arr)) return;
		eval("\$this->$event();");
	}
//tip,success,error,danger,info
	private function reward(){
		//$event_arr = array('login_everyday','post_comment','been_comment','post_share','post_video','forward_share','been_like','been_like_album','add_like','add_like_album','email_active','create_avatar');
		$this->ajax_check_login();
		$ptx_event_log = spClass('ptx_event_log');
		$start_time = time()-5*24*3600;
		$ptx_event_log->clean_log($this->current_user['user_id'],$start_time);
		$conditions['to_user_id']=$this->current_user['user_id'];
		$conditions['event_type']='reward';
		$conditions['is_read']='0';
		$conditions['event_code']=array('login_everyday','post_comment','post_share','post_video','forward_share','add_like','add_like_album','email_active','create_avatar');
		$logs = $ptx_event_log->search_no_page($conditions);

		$credit_strategy = $this->settings['credit_strategy'];
		$messages = array();
		foreach ($logs as $log) {
			$msg = T($log['event_code']).' ';
			for ($i=1;$i<=3;$i++){
				if($ext_credits=$credit_strategy[$log['event_code'].'_credits_'.$i]){
					$msg .= T("ext_credits_$i").' +'.$ext_credits.' ';
				}
			}
			$messages[] = $msg;
		}
		$conditions_update['to_user_id']=$this->current_user['user_id'];
		$conditions_update['event_type']='reward';
		$conditions_update['is_read']='0';
		$ptx_event_log->update($conditions_update,array('is_read'=>1));
		$this->ajax_success_response($messages, 'tip');
	}
	
	private function user_message(){
		$this->ajax_check_login();
		$ptx_message = spClass('ptx_message');
		
		$message_num=10;
		$message_limit = $ptx_message->clean_message_num($this->current_user['user_id'],$message_num);
		
		$conditions['to_user_id']=$this->current_user['user_id'];
		$conditions['is_read']='0';
		$message_count = $ptx_message->findCount($conditions);
		
		if($message_count > 99){
			$message_html = "<em>N</em>";
		}elseif ($message_count){
			$message_html = "<em>$message_count</em>";
		}else{
			$message_html = "";
		}
		$this->ajax_success_response(array('message_html'=>$message_html), 'user_message');
	}
	
	private function alert(){
		$this->ajax_check_login();
		$ptx_event_log = spClass('ptx_event_log');
		$conditions['to_user_id']=$this->current_user['user_id'];
		$conditions['event_type']='alert';
		$conditions['is_read']='0';
		$message_count = $ptx_event_log->findCount($conditions);
		if($message_count > 99){
			$message_html = "<em>N</em>";
		}elseif ($message_count){
			$message_html = "<em>$message_count</em>";
		}else{
			$message_html = "";
		}
		$this->ajax_success_response(array('message_html'=>$message_html), 'alert');
	}
}