<?php
class ptx_group extends spModelMulti
{
	public $pk = 'group_id';
	public $table = 'ptx_group';
	var $linker = array(
		'user'=>array(
			'type' => 'hasone',  
			'map' => 'user',
			'mapkey' => 'user_id', 
			'fclass' => 'ptx_user',
			'fkey' => 'user_id',
			'enabled' => true
	),
		'category'=>array(
			'type' => 'hasone',  
			'map' => 'category',
			'mapkey' => 'category_id', 
			'fclass' => 'ptx_category',
			'fkey' => 'category_id',
			'enabled' => true
	),
	);

	var $select_fields = " ptx_group.*,category.category_name_cn,user.email,user.nickname,user.user_title,user.total_likes ";

	private function init_conditions($conditions){
		$conditions_group = NULL;
		if(isset($conditions['keyword'])){
			$keyword = $this->escape($conditions['keyword']);
			$conditions_group .= "AND MATCH (ptx_group.keyword_search) AGAINST ('{$keyword}' IN BOOLEAN MODE) ";
		}
		if(isset($conditions['category_id'])){
			$category_id = $this->escape($conditions['category_id']);
			$conditions_group .= "AND ptx_group.category_id={$category_id} ";
		}
		if(isset($conditions['user_id'])){
			$user_id = $this->escape($conditions['user_id']);
			$conditions_group .= "AND ptx_group.user_id={$user_id} ";
		}
		if(isset($conditions['total_share_num'])){
			$limit_num = $this->escape($conditions['total_member']);
			$conditions_group .= "AND ptx_group.total_member>={$limit_num} ";
		}
		if(strpos($conditions_group, 'AND') === 0){
			$conditions_group = substr($conditions_group, 3);
		}
		return $conditions_group;
	}
	
	public function count($conditions=NULL){
		$conditions = $this->init_conditions($conditions);
		return $this->findCount($conditions);
	}

	public function search($conditions=NULL,$page,$pagesize,$fields = null,$sort=null){
		$conditions = $this->init_conditions($conditions);
		if(!$sort)
			$sort = " ptx_group.group_id DESC ";
		if(!$fields){
			$fields = $this->select_fields;
		}
		return $this->spPager($page, $pagesize)->findAllJoin($conditions,$sort,$fields);
	}

	public function search_no_page($conditions=NULL,$fields = null,$sort=null,$limit){
		$conditions = $this->init_conditions($conditions);
		if(!$sort)
			$sort = " ptx_group.group_id DESC ";
		if(!$fields){
			$fields = $this->select_fields;
		}
		return $this->findAllJoin($conditions,$sort,$fields,$limit);
	}

	public function find_one($conditions=NULL){
		return $this->findJoin($conditions," ptx_group.group_id DESC ",$this->select_fields);
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
		if(!is_numeric($data['category_id'])){
			return false;
		}
		return true;
	}

	public function update_total_member($group_id){
		$count = spClass('ptx_user_group')->findCount(array('group_id'=>$group_id));
		return $this->runSql("UPDATE {$this->tbl_name} SET total_member='{$count}' WHERE group_id='{$group_id}'");
	}

}
