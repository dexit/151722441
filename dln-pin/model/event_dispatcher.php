<?php
class event_dispatcher
{
	public function __construct() {
		$this->ptx_settings = spClass('ptx_settings');
		$this->settings = $this->ptx_settings->getSettings();
		$this->ptx_usergroup = spClass('ptx_usergroup');
		$this->usergroups = $this->ptx_usergroup->getUsergroups();
		$this->ptx_user = spClass('ptx_user');
	}

	public function invoke($event,$data){
		//join_group
		$event_arr = array('login_everyday','join_group','post_comment','been_comment',
						'post_share','post_video','post_article','forward_share','been_like',
						'been_like_album','add_like','add_follow','been_follow','add_like_album','been_forward',
						'email_active','create_avatar','add_like_topic');
		if(!in_array($event, $event_arr)) return;
		$user_id = $data['to_user_id'];
		eval("\$result=\$this->$event(\$user_id,\$data);");
		if($result['update_credit']){
			$this->credit_strategy_invoke($event, $user_id);
			$this->update_usercredits($user_id);
		}
		if($result['add_log']){
			$ptx_event_log = spClass('ptx_event_log');
			$ptx_event_log->add_one($event,$user_id,$data);
		}
	}

	public function credit_strategy_invoke($event,$user_id){
		$credit_strategy = $this->settings['credit_strategy'];
		$ext_credits_1 = is_numeric($credit_strategy[$event.'_credits_1'])?$credit_strategy[$event.'_credits_1']:0;
		$ext_credits_2 = is_numeric($credit_strategy[$event.'_credits_2'])?$credit_strategy[$event.'_credits_2']:0;
		$ext_credits_3 = is_numeric($credit_strategy[$event.'_credits_3'])?$credit_strategy[$event.'_credits_3']:0;
		$sql = "UPDATE {$this->ptx_user->tbl_name} ".
			   "SET ext_credits_1=ext_credits_1+{$ext_credits_1}, ".
			   " ext_credits_2=ext_credits_2+{$ext_credits_2}, ".
			   " ext_credits_3=ext_credits_3+{$ext_credits_3} ".
			   "WHERE user_id='{$user_id}'";
		$this->ptx_user->runSql($sql);
		return TRUE;
	}

	private function update_usergroup($user_data,$user_update){
		$usergroup = $this->usergroups[$user_data['usergroup_id']];
		if($usergroup['usergroup_type']=='member'&&($user_update['credits']>$usergroup['credits_higher']||$user_update['credits']<$usergroup['credits_lower'])){
			$newgroup = $this->ptx_usergroup->find_one(array('credits'=>$user_update['credits']));
			if($newgroup)
			$user_update['usergroup_id'] = $newgroup['usergroup_id'];
		}
		return $user_update;
	}

	private function update_usercredits($user_id){
		$credit_setting = $this->settings['credit_setting'];
		$credit_formula_exe = $credit_setting['credit_formula_exe'];
		if($credit_formula_exe){
			$user_data = $this->ptx_user->getuser_byid($user_id);
			$total_followers = $user_data['total_followers'];
			$total_likes = $user_data['total_likes'];
			$total_shares = $user_data['total_shares'];
			$ext_credits_1 = $user_data['ext_credits_1'];
			$ext_credits_2 = $user_data['ext_credits_2'];
			$ext_credits_3 = $user_data['ext_credits_3'];
			eval("\$user_update['credits']=$credit_formula_exe;");

			$user_update = $this->update_usergroup($user_data, $user_update);

			$this->ptx_user->update(array('user_id'=>$user_id),$user_update);
			spClass('UserLib')->refresh_session();
		}
	}
	
	private function login_everyday($user_id,$data){
		$condition = array('user_id'=>$user_id);
		$user_data = $this->ptx_user->find($condition,null,' ptx_user.last_login_time ');
		$now = time();
		$now_date = date('Ymd',$now);
		$last_date = date('Ymd',$user_data['last_login_time']);
		$this->ptx_user->update($condition,array('last_login_time'=>$now));
		if($now_date<=$last_date){
			return array('update_credit'=>false,'add_log'=>false);
		}
		$ptx_event_log = spClass('ptx_event_log');
		$ptx_event_log->clean_log_bynum($user_id);
		return array('update_credit'=>true,'add_log'=>true);
	}
	
	private function post_share($user_id,$data){
		$this->ptx_user->add_share($user_id);
		if($this->checkNewbieTask($user_id, 'first_post_share')){
			return array('update_credit'=>true,'add_log'=>true);
		}else{
			$data['event_code'] = 'first_post_share';
			$this->invoke('first_post_share', $data);
			return array('update_credit'=>false,'add_log'=>true);
		}
	}
	private function post_article($user_id,$data){
		$this->ptx_user->add_share($user_id);
		if($this->checkNewbieTask($user_id, 'first_post_share')){
			return array('update_credit'=>true,'add_log'=>true);
		}else{
			$data['event_code'] = 'first_post_share';
			$this->invoke('first_post_share', $data);
			return array('update_credit'=>false,'add_log'=>true);
		}
	}

	private function post_video($user_id,$data){
		$this->ptx_user->add_share($user_id);
		if($this->checkNewbieTask($user_id, 'first_post_share')){
			return array('update_credit'=>true,'add_log'=>true);
		}else{
			$data['event_code'] = 'first_post_share';
			$this->invoke('first_post_share', $data);
			return array('update_credit'=>false,'add_log'=>true);
		}
	}

	private function forward_share($user_id,$data){
		return array('update_credit'=>true,'add_log'=>true);
	}
	
	private function been_forward($user_id,$data){
		return array('update_credit'=>false,'add_log'=>true);
	}

	private function post_comment($user_id,$data){
		return array('update_credit'=>true,'add_log'=>true);
	}
	private function been_comment($user_id,$data){
		return array('update_credit'=>false,'add_log'=>true);
	}
	private function email_active($user_id,$data){
		return array('update_credit'=>true,'add_log'=>true);
	}
	private function been_like($user_id,$data){
		$this->ptx_user->add_like($user_id);
		return array('update_credit'=>true,'add_log'=>true);
	}
	private function been_like_album($user_id,$data){
		return array('update_credit'=>true,'add_log'=>true);
	}
	private function create_avatar($user_id,$data){
		if($this->checkNewbieTask($user_id, 'create_avatar')){
			return array('update_credit'=>false,'add_log'=>false);
		}
		return array('update_credit'=>true,'add_log'=>true);
	}
	private function create_album($user_id,$data){
		if($this->checkNewbieTask($user_id, 'first_create_album')){
			return array('update_credit'=>true,'add_log'=>true);
		}else{
			$data['event_code'] = 'first_create_album';
			$this->invoke('first_create_album', $data);
			return array('update_credit'=>false,'add_log'=>false);
		}
		
	}
	private function add_like_topic($user_id,$data){
		if($this->checkNewbieTask($user_id, 'first_like_topic')){
			return array('update_credit'=>true,'add_log'=>true);
		}else{
			$data['event_code'] = 'first_like_topic';
			$this->invoke('first_like_topic', $data);
			return array('update_credit'=>false,'add_log'=>false);
		}
	
	}
	
	private function checkNewbieTask($user_id,$event){
		if(in_array($event, array('first_post_share','first_add_follow','first_create_album','create_avatar','first_like_topic'))){
			$condition['event_type'] = 'reward';
			$condition['event_code'] = $event;
			$condition['to_user_id'] = $user_id;
			if(spClass('ptx_event_log')->find_one($condition)){
				return true;
			}
		}
		return false;
	}
	
	private function add_like($user_id,$data){
		return array('update_credit'=>true,'add_log'=>true);
	}

	private function add_follow($user_id,$data){
		if($this->checkNewbieTask($user_id, 'first_add_follow')){
			return array('update_credit'=>false,'add_log'=>true);
		}else{
			$data['event_code'] = 'first_add_follow';
			$this->invoke('first_add_follow', $data);
			return array('update_credit'=>false,'add_log'=>false);
		}
	}
	
	private function been_follow($user_id,$data){
		return array('update_credit'=>false,'add_log'=>true);
	}
	
	private function join_group($user_id,$data){
		return array('update_credit'=>true,'add_log'=>true);
	}
	
	private function add_like_album($user_id,$data){
		return array('update_credit'=>true,'add_log'=>true);
	}
}
