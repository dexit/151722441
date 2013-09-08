<?php
/**
 *      [PinTuXiu] (C)2001-2099 ONightjar.com Pintuxiu.com.
 *      This is NOT a freeware, use is subject to license terms
 */
class pub extends baseuser {

	public function __construct() {
		parent::__construct();
	}
	
	public function index(){
		$this->timeline();
	}
	
	public function user(){
		$this->parameter_need('sname');
		
		$ptx_user = spClass('ptx_user');
		$user = $ptx_user->find(array('domain'=>$this->sname),' ptx_user.user_id ');
		$this->user_id = $user['user_id'];
		
		$act =  $this->spArgs("act");
		
		if(in_array($act, array('focus','shares','album','favorite_share','following','fans','timeline','forumline'))){
			eval("\$this->$act();");
		}else{
			$this->timeline();
		}
	}
	
	public function focus( $user_id = null ){
		$this->parameter_need('user_id');
		if($this->page==1){
			$this->userControlPub($this->user_id);
		}
		parent::focus($this->user_id);
	}
	
	public function shares( $user_id = null ){
		$this->parameter_need('user_id');
		if($this->page==1){
			$this->userControlPub($this->user_id);
		}
		parent::shares($this->user_id);
	}
	
	public function album( $user_id = null ){
		$this->parameter_need('user_id');
		if($this->page==1){
			$this->userControlPub($this->user_id);
		}
		parent::album($this->user_id);
	}

	public function favorite_share( $user_id = null ){
	$this->parameter_need('user_id');
		if($this->page==1){
			$this->userControlPub($this->user_id);
		}
		parent::favorite_share($this->user_id);
	}

	public function following( $user_id = null, $my_id = null ){
		$this->parameter_need('user_id');
		if($this->page==1){
			$this->userControlPub($this->user_id);
		}
		parent::following($this->user_id,$this->current_user['user_id']);
	}

	public function fans( $user_id = null, $my_id = null ){
		$this->parameter_need('user_id');
		if($this->page==1){
			$this->userControlPub($this->user_id);
		}
		parent::fans($this->user_id,$this->current_user['user_id']);
	}
	
	public function timeline( $user_id = null ){
		$this->parameter_need('user_id');
		if($this->page==1){
			$this->userControlPub($this->user_id);
			//$this->set_user_banner($this->user_id);
		}
		parent::timeline($this->user_id);
	}
	
	public function forumline( $user_id = null ){
		$this->parameter_need('user_id');
		if($this->page==1){
			$this->userControlPub($this->user_id);
			//$this->set_user_banner($this->user_id);
		}
		parent::forumline($this->user_id);
	}
	
}

