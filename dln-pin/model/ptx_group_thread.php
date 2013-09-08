<?php
class ptx_group_thread extends spModelMulti
{
	public $pk = 'thread_id';
	public $table = 'ptx_group_thread';
	var $linker = array(
		'user'=>array(
			'type' => 'hasone',  
			'map' => 'user',
			'mapkey' => 'user_id', 
			'fclass' => 'ptx_user',
			'fkey' => 'user_id',
			'enabled' => true
	),
		'pgroup'=>array(
			'type' => 'hasone',  
			'map' => 'pgroup',
			'mapkey' => 'group_id', 
			'fclass' => 'ptx_group',
			'fkey' => 'group_id',
			'enabled' => true
	),
	);

	var $select_fields = " ptx_group_thread.*,pgroup.group_title,user.email,user.nickname,user.user_title,user.total_likes ";

	private function init_conditions($conditions){
		$conditions_group_thread = NULL;
		if(isset($conditions['keyword'])){
			$keyword = $this->escape($conditions['keyword']);
			$conditions_group_thread .= "AND MATCH (ptx_group_thread.keyword_search) AGAINST ('{$keyword}' IN BOOLEAN MODE) ";
		}
		if(isset($conditions['group_id'])){
			$group_id = $this->escape($conditions['group_id']);
			$conditions_group_thread .= "AND ptx_group_thread.group_id={$group_id} ";
		}
		if(isset($conditions['user_id'])){
			$user_id = $this->escape($conditions['user_id']);
			$conditions_group_thread .= "AND ptx_group_thread.user_id={$user_id} ";
		}
		if(strpos($conditions_group_thread, 'AND') === 0){
			$conditions_group_thread = substr($conditions_group_thread, 3);
		}
		return $conditions_group_thread;
	}

	public function search($conditions=NULL,$page,$pagesize,$fields = null,$sort=null){
		$conditions = $this->init_conditions($conditions);
		if(!$sort)
			$sort = " ptx_group_thread.thread_id DESC ";
		if(!$fields){
			$fields = $this->select_fields;
		}
		return $this->spPager($page, $pagesize)->findAllJoin($conditions,$sort,$fields);
	}

	public function search_no_page($conditions=NULL,$fields = null,$sort=null,$limit){
		$conditions = $this->init_conditions($conditions);
		if(!$sort)
			$sort = " ptx_group_thread.thread_id DESC ";
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
		if(!is_numeric($data['group_id'])){
			return false;
		}
		return true;
	}

	public function add_view($thread_id)
	{
		return $this->runSql("UPDATE {$this->tbl_name} SET total_view=total_view+1 WHERE thread_id='{$thread_id}'");
	}
	public function add_reply($thread_id)
	{
		return $this->runSql("UPDATE {$this->tbl_name} SET total_reply=total_reply+1 WHERE thread_id='{$thread_id}'");
	}

}
