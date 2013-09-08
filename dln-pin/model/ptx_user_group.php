<?php
class ptx_user_group extends spModelMulti
{
	public $pk = 'user_group_id';
	public $table = 'ptx_user_group';

	var $linker = array(
		'pgroup' => 	array(
				'type' => 'hasone',   		
				'map' => 'pgroup',    	
				'mapkey' => 'group_id', 	
				'fclass' => 'ptx_group', 	
				'fkey' => 'group_id',   
				'enabled' => true
	),
		'user' => 	array(
				'type' => 'hasone',   		
				'map' => 'user',    	
				'mapkey' => 'user_id', 	
				'fclass' => 'ptx_user', 	
				'fkey' => 'user_id',  
				'enabled' => true
	)
	);

	var $other_join = array(
		'owner' => 	array(
				'main_table' => 'ptx_user',    	
				'main_alias' => 'owner', 	
				'main_fkey' => 'user_id', 	
				'sec_table_alias' => 'pgroup',    
				'sec_mapkey' => 'user_id', 	
				'enabled' => true	
	),
		'category' => 	array(
				'main_table' => 'ptx_category',    	
				'main_alias' => 'category', 	
				'main_fkey' => 'category_id', 	
				'sec_table_alias' => 'pgroup',    
				'sec_mapkey' => 'category_id', 	
				'enabled' => true
	)
	);

	var $select_fields = " pgroup.*,owner.user_id,owner.nickname,owner.user_title,category.category_id,category.category_name_cn ";


	private function init_conditions($conditions){
		$conditions_group = NULL;
		if(isset($conditions['user_id'])){
			$conditions_group .= 'AND ptx_user_group.user_id='.$conditions['user_id'].' ';
		}

		if(isset($conditions['category_id'])){
			$conditions_group .= 'AND pgroup.category_id='.$conditions['category_id'].' ';
		}
		
		if(isset($conditions['group_id'])){
			$conditions_group .= 'AND ptx_user_group.group_id='.$conditions['group_id'].' ';
		}
		
		if($conditions_group){
			if(strpos($conditions_group, 'AND') === 0){
				$conditions_group = substr($conditions_group, 3);
			}
		}
		return $conditions_group;
	}

	public function search($conditions=NULL,$page,$pagesize,$fields = null){
		$conditions_group = $this->init_conditions($conditions);
		$sort = " ptx_user_group.create_time DESC ";
		if(!$fields){
			$fields = $this->select_fields;
		}
		return $this->spPager($page, $pagesize)->findAllJoin($conditions_group,$sort,$fields);
	}

	public function find_one($conditions=NULL,$fields = null){
		if(!$fields){
			$fields = $this->select_fields;
		}
		return $this->findJoin($conditions,null,$fields);
	}

	public function add_one($data){
		if($this->check_value($data)){
			$data['create_time'] = time();
			return $this->create($data);
		}
		return false;
	}

	private function check_value($data){
		if(!is_numeric($data['user_id'])){
			return false;
		}
		if(!is_numeric($data['group_id'])){
			return false;
		}
		if($this->find_one($data)){
			return false;
		}
		
		return true;
	}

}
