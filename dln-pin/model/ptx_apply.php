<?php
class ptx_apply extends spModelMulti
{
	public $pk = 'apply_id';
	public $table = 'ptx_apply';
	var $linker = array(
		'user'=>array(
			'type' => 'hasone',  
			'map' => 'user',
			'mapkey' => 'user_id', 
			'fclass' => 'ptx_user',
			'fkey' => 'user_id',
			'enabled' => true
	),
		'medal'=>array(
			'type' => 'hasone',  
			'map' => 'medal',
			'mapkey' => 'medal_id', 
			'fclass' => 'ptx_medal',
			'fkey' => 'medal_id',
			'enabled' => true
	),
		'storecate'=>array(
			'type' => 'hasone',  
			'map' => 'storecate',
			'mapkey' => 'store_category_id', 
			'fclass' => 'ptx_store_category',
			'fkey' => 'store_category_id',
			'enabled' => true
	),
	);
	var $select_fields = " ptx_apply.*,user.user_id,user.nickname,medal.medal_id,medal.name,storecate.store_category_id,storecate.store_category_name ";

	public function search($conditions=NULL,$page,$pagesize,$fields = null,$sort=null){
		if(!$sort)
			$sort = " ptx_apply.apply_id DESC ";
		if(!$fields)
			$fields = $this->select_fields;
		return $this->spPager($page, $pagesize)->findAllJoin($conditions,$sort,$fields);
	}

	public function find_one($conditions=NULL){
		return $this->findJoin($conditions,null,$this->select_fields);
	}

	public function add_one($data){
		if($this->check_value($data)){
			$data['create_time'] = time();
			$result = $this->create($data);
			return $result;
		}
		return false;
	}

	public function check_exits($user_id,$type){
		$conditions['user_id'] = $user_id;
		$conditions['apply_type'] = $type;
		return $this->find($conditions,null," ptx_apply.apply_id ");
	}

	public function add_starapply($user_id,$medal_id,$message){
		$data['user_id'] = $user_id;
		$data['medal_id'] = $medal_id;
		$data['message_txt'] = $message;
		$data['apply_type'] = '1';
		$data['create_time'] = time();
		return $this->create($data);
	}

	public function add_shopapply($user_id,$category_id,$message){
		$data['user_id'] = $user_id;
		$data['store_category_id'] = $category_id;
		$data['message_txt'] = $message;
		$data['apply_type'] = '2';
		$data['create_time'] = time();
		return $this->create($data);
	}

	private function check_value($data){
		if(!is_numeric($data['user_id'])){
			return false;
		}
		return true;
	}

	public function agree($apply_id)
	{
		$conditions['apply_id'] = $apply_id;
		$apply = $this->find_one($conditions);
		if($apply){
			$this->update(array('apply_id'=>$apply_id),array('status'=>1));
			$ptx_user = spClass("ptx_user");
			if($apply['apply_type']==1){
				$ptx_user->update_staruser($apply['user_id'],1);
				$ptx_staruser = spClass("ptx_staruser");
				$data['user_id'] = $apply['user_id'];
				$data['medal_id'] = $apply['medal_id'];
				$data['star_reason'] = $apply['message_txt'];
				$ptx_staruser->add_one($data);
				$ptx_staruser->update_staruser_cache();

			}elseif ($apply['apply_type']==2){
				$data['user_id'] = $apply['user_id'];
				$data['store_category_id'] = $apply['store_category_id'];
				$data['shop_desc'] = $apply['message_txt'];
				$ptx_goodshop = spClass('ptx_goodshop');
				$ptx_goodshop->add_one($data);
				$ptx_user->update_shopuser($apply['user_id'],1);
			}
			
			$this->deleteByPk($apply_id);
		}

		return;
	}

	public function disagree($apply_id)
	{
		$conditions['apply_id'] = $apply_id;
		$apply = $this->find_one($conditions);
		if($apply){
			$this->update(array('apply_id'=>$apply_id),array('status'=>0));
			$this->deleteByPk($apply_id);
		}

		return;
	}

}
