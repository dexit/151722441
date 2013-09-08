<?php
class ptx_topic extends spModelMulti
{
	public $pk = 'topic_id';
	public $table = 'ptx_topic';
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

	var $select_fields = " ptx_topic.*,category.category_name_cn,user.email,user.nickname,user.user_title ";

	private function init_conditions($conditions){
		$conditions_topic = NULL;
		if(isset($conditions['keyword'])){
			$keyword = $this->escape($conditions['keyword']);
			$conditions_topic .= "AND MATCH (ptx_topic.keywords_search) AGAINST ('{$keyword}' IN BOOLEAN MODE) ";
		}
		if(isset($conditions['category_id'])){
			$category_id = $this->escape($conditions['category_id']);
			$conditions_topic .= "AND ptx_topic.category_id={$category_id} ";
		}
		if(isset($conditions['user_id'])){
			$user_id = $this->escape($conditions['user_id']);
			$conditions_topic .= "AND ptx_topic.user_id={$user_id} ";
		}
		if(isset($conditions['total_share_num'])){
			$limit_num = $this->escape($conditions['total_share_num']);
			$conditions_topic .= "AND ptx_album.total_share>={$limit_num} ";
		}
		if(strpos($conditions_topic, 'AND') === 0){
			$conditions_topic = substr($conditions_topic, 3);
		}
		return $conditions_topic;
	}

	public function search($conditions=NULL,$page,$pagesize,$fields = null,$sort=null){
		$conditions = $this->init_conditions($conditions);
		if(!$sort)
			$sort = " ptx_topic.topic_id DESC ";
		if(!$fields){
			$fields = $this->select_fields;
		}
		return $this->spPager($page, $pagesize)->findAllJoin($conditions,$sort,$fields);
	}

	public function search_no_page($conditions=NULL,$fields = null,$sort=null,$limit){
		$conditions = $this->init_conditions($conditions);
		if(!$sort)
			$sort = " ptx_topic.topic_id DESC ";
		if(!$fields){
			$fields = $this->select_fields;
		}
		return $this->findAllJoin($conditions,$sort,$fields,$limit);
	}

	public function find_one($conditions=NULL){
		if(!$fields){
			$fields = $this->select_fields;
		}
		return $this->findJoin($conditions,null,$fields);
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

	public function add_like($topic_id)
	{
		return $this->runSql("UPDATE {$this->tbl_name} SET total_like=total_like+1 WHERE topic_id='{$topic_id}'");
	}
	public function remove_like($topic_id)
	{
		return $this->runSql("UPDATE {$this->tbl_name} SET total_like=total_like-1 WHERE topic_id='{$topic_id}'");
	}

}
