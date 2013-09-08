<?php
class ptx_message extends spModelMulti
{
	public $pk = 'message_id';
	public $table = 'ptx_message';
	var $linker = array(
		'fromuser'=>array(
			'type' => 'hasone',  
			'map' => 'fromuser',
			'mapkey' => 'from_user_id', 
			'fclass' => 'ptx_user',
			'fkey' => 'user_id',
			'enabled' => true
		),
		'touser'=>array(
			'type' => 'hasone',  
			'map' => 'touser',
			'mapkey' => 'to_user_id', 
			'fclass' => 'ptx_user',
			'fkey' => 'user_id',
			'enabled' => true
		)
	);

	var $select_fields = " ptx_message.*,fromuser.user_id as fuser_id,fromuser.nickname as fnickname,touser.user_id as tuser_id,touser.nickname as tnickname ";

	public function search($conditions=NULL,$page,$pagesize,$fields = null,$sort=null){
		if(!$sort)
		$sort = " ptx_message.message_id DESC ";
		if(!$fields){
			$fields = $this->select_fields;
		}
		return $this->spPager($page, $pagesize)->findAllJoin($conditions,$sort,$fields);
	}

	public function search_no_page($conditions=NULL,$fields = null,$sort=null,$limit){
		if(!$sort)
		$sort = " ptx_message.message_id DESC ";

		if(!$fields){
			$fields = $this->select_fields;
		}
		return $this->findAllJoin($conditions,$sort,$fields,$limit);
	}

	public function find_one($conditions=NULL){
		return $this->findJoin($conditions);
	}


	public function add_apply($fuid,$tuid,$type){
		$data['from_user_id'] = $fuid;
		$data['to_user_id'] = $tuid;
		$data['message_txt'] = T('pass_through').($type==1?T('staruser_apply'):T('shop_apply'));
		return $this->add_one($data);
	}

	public function dis_apply($fuid,$tuid,$type){
		$data['from_user_id'] = $fuid;
		$data['to_user_id'] = $tuid;
		$data['message_txt'] = T('decline').($type==1?T('staruser_apply'):T('shop_apply'));
		return $this->add_one($data);
	}

	public function add_forwarding($sid,$share_title,$fuid,$tuid){
		$data['from_user_id'] = $fuid;
		$data['to_user_id'] = $tuid;
		$url = spUrl('detail','index',array('share_id'=>$sid));
		$data['message_txt'] = T('message_shared_your_item')."<a href='{$url}'/>{$share_title}</a>";
		return $this->add_one($data);
	}

	public function add_comment($sid,$share_title,$fuid,$tuid){
		$data['from_user_id'] = $fuid;
		$data['to_user_id'] = $tuid;
		$url = spUrl('detail','index',array('share_id'=>$sid));
		$data['message_txt'] = T('message_comment_your_item')."<a href='{$url}'/>{$share_title}</a>";
		return $this->add_one($data);
	}

	public function add_at($fuid,$tuid,$type='share'){
		$data['from_user_id'] = $fuid;
		$data['to_user_id'] = $tuid;
		$url = $type=='share'?spUrl('my','at_shares'):spUrl('my','at_comments');
		if($type=='share'){
			$url = spUrl('my','at_shares');
			$data['message_txt'] = T('message_at_you_in_item')."<a href='{$url}'/>".T('check_at_me_item')."</a>";
		}else{
			$url = spUrl('my','at_comments');
			$data['message_txt'] = T('message_at_you_in_comment')."<a href='{$url}'/>".T('check_at_me_comment')."</a>";
		}
		return $this->add_one($data);
	}

	public function add_like($sid,$share_title,$fuid,$tuid){
		$data['from_user_id'] = $fuid;
		$data['to_user_id'] = $tuid;
		$url = spUrl('detail','index',array('share_id'=>$sid));
		$data['message_txt'] = T('message_add_like_item')."<a href='{$url}'/>{$share_title}</a>";
		return $this->add_one($data);
	}

	public function add_like_album($aid,$album_title,$fuid,$tuid){
		$data['from_user_id'] = $fuid;
		$data['to_user_id'] = $tuid;
		$url = spUrl('baseuser','album_shares',array('aid'=>$aid));
		$data['message_txt'] = T('message_add_like_album')."<a href='{$url}'/>{$album_title}</a>";
		return $this->add_one($data);
	}

	public function add_follow($fuid,$tuid){
		$data['from_user_id'] = $fuid;
		$data['to_user_id'] = $tuid;
		$data['message_txt'] = T('message_add_follow');
		return $this->add_one($data);
	}

	public function clean_message($user_id,$start_id){
		$user_id = $this->escape($user_id);
		$start_id = ($start_id)?$this->escape($start_id):$this->escape(0);
		$this->delete(" to_user_id={$user_id} AND message_id<{$start_id} ");
	}
	
	
	public function clean_message_num($user_id,$num){
		$message = $this->findSql("SELECT message_id from {$this->tbl_name} WHERE to_user_id='{$user_id}' ORDER BY message_id DESC LIMIT {$num},1");
		if($message&&$message['message_id']){
			$this->delete(" to_user_id={$user_id} AND message_id<{$message['message_id']} ");
		}
	}

	public function add_one($data){
		if($this->check_value($data)){
			$data['create_time'] = time();
			$id = $this->create($data);
			//$ptx_user = spClass("ptx_user");
			//$ptx_user->add_message($data['to_user_id']);
			return $id;
		}
		return false;
	}


	private function check_value($data){
		if(!is_numeric($data['from_user_id'])||!is_numeric($data['to_user_id'])){
			return false;
		}
		return true;
	}

}
