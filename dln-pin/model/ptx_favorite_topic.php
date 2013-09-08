<?php
class ptx_favorite_topic extends spModelMulti
{
	public $pk = 'favorite_id';
	public $table = 'ptx_favorite_topic';

	var $linker = array(
		'topic' => 	array(
				'type' => 'hasone',   		
				'map' => 'topic',    	
				'mapkey' => 'topic_id', 	
				'fclass' => 'ptx_topic', 	
				'fkey' => 'topic_id',   
				'enabled' => true
	),
		'user' => 	array(
				'type' => 'hasone',   		
				'map' => 'user',    	
				'mapkey' => 'user_id', 	
				'fclass' => 'ptx_user', 	
				'fkey' => 'user_id',  
				'enabled' => false
	)
	);

	var $other_join = array(
		'owner' => 	array(
				'main_table' => 'ptx_user',    	
				'main_alias' => 'owner', 	
				'main_fkey' => 'user_id', 	
				'sec_table_alias' => 'topic',    
				'sec_mapkey' => 'user_id', 	
				'enabled' => true	
	),
		'category' => 	array(
				'main_table' => 'ptx_category',    	
				'main_alias' => 'category', 	
				'main_fkey' => 'category_id', 	
				'sec_table_alias' => 'topic',    
				'sec_mapkey' => 'category_id', 	
				'enabled' => true
	)
	);

	var $select_fields = " topic.*,owner.user_id,owner.nickname,owner.user_title,category.category_id,category.category_name_cn ";


	private function init_conditions($conditions){
		$conditions_topic = NULL;
		if(isset($conditions['user_id'])){
			$conditions_topic .= 'AND ptx_favorite_topic.user_id='.$conditions['user_id'].' ';
		}

		if(isset($conditions['category_id'])){
			$conditions_topic .= 'AND topic.category_id='.$conditions['category_id'].' ';
		}

		if($conditions_topic){
			if(strpos($conditions_topic, 'AND') === 0){
				$conditions_topic = substr($conditions_topic, 3);
			}
		}
		return $conditions_topic;
	}

	public function search($conditions=NULL,$page,$pagesize,$fields = null){
		$conditions_topic = $this->init_conditions($conditions);
		$sort = " ptx_favorite_topic.create_time DESC ";
		if(!$fields){
			$fields = $this->select_fields;
		}
		return $this->spPager($page, $pagesize)->findAllJoin($conditions_topic,$sort,$fields);
	}

	public function find_one($conditions=NULL){
		$fields = $this->select_fields;
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
		if(!is_numeric($data['topic_id'])){
			return false;
		}
		if($this->find_one($data)){
			return false;
		}
		
		return true;
	}

}
