<?php
class ptx_group_post extends spModelMulti
{
	public $pk = 'post_id';
	public $table = 'ptx_group_post';
	var $linker = array(
		'user'=>array(
			'type' => 'hasone',  
			'map' => 'user',
			'mapkey' => 'user_id', 
			'fclass' => 'ptx_user',
			'fkey' => 'user_id',
			'enabled' => true
	),
		'thread'=>array(
			'type' => 'hasone',  
			'map' => 'thread',
			'mapkey' => 'thread_id', 
			'fclass' => 'ptx_group_thread',
			'fkey' => 'thread_id',
			'enabled' => true
	),
	);

	var $select_fields = " ptx_group_post.*,user.email,user.nickname,user.user_title,user.total_likes ";

	private function init_conditions($conditions){
		$conditions_group_post = NULL;
		if(isset($conditions['thread_id'])){
			$thread_id = $this->escape($conditions['thread_id']);
			$conditions_group_post .= "AND ptx_group_post.thread_id={$thread_id} ";
		}
		if(isset($conditions['user_id'])){
			$user_id = $this->escape($conditions['user_id']);
			$conditions_group_post .= "AND ptx_group_post.user_id={$user_id} ";
		}
		if(strpos($conditions_group_post, 'AND') === 0){
			$conditions_group_post = substr($conditions_group_post, 3);
		}
		return $conditions_group_post;
	}

	public function search($conditions=NULL,$page,$pagesize,$fields = null,$sort=null){
		$conditions = $this->init_conditions($conditions);
		if(!$sort)
			$sort = " ptx_group_post.post_id DESC ";
		if(!$fields){
			$fields = $this->select_fields;
		}
		return $this->spPager($page, $pagesize)->findAllJoin($conditions,$sort,$fields);
	}

	public function search_no_page($conditions=NULL,$fields = null,$sort=null,$limit){
		$conditions = $this->init_conditions($conditions);
		if(!$sort)
			$sort = " ptx_group_post.post_id DESC ";
		if(!$fields){
			$fields = $this->select_fields;
		}
		return $this->findAllJoin($conditions,$sort,$fields,$limit);
	}

	public function find_one($conditions=NULL){
		return $this->findJoin($conditions);
	}

	public function add_one($data){
		if($this->check_value($data)){
			$data['create_time'] = time();
			$result = $this->create($data);
			return $result;
		}
		return false;
	}

	private function check_value($data){
		if(!is_numeric($data['thread_id'])){
			return false;
		}
		return true;
	}

}
