<?php
class ptx_medal extends spModelMulti
{
	public $pk = 'medal_id';
	public $table = 'ptx_medal';
	var $linker = array();

	var $select_fields = " ptx_medal.* ";

	private function init_conditions($conditions){
		$conditions_medal = NULL;
		if(isset($conditions['type'])){
			$type = $this->escape($conditions['type']);
			$conditions_medal .= "AND ptx_medal.type={$type} ";
		}
		if(strpos($conditions_medal, 'AND') === 0){
			$conditions_medal = substr($conditions_medal, 3);
		}
		return $conditions_medal;
	}
	
	public function count($conditions=NULL){
		$conditions = $this->init_conditions($conditions);
		return $this->findCount($conditions);
	}

	public function search($conditions=NULL,$page,$pagesize,$fields = null,$sort=null){
		$conditions = $this->init_conditions($conditions);
		if(!$sort)
			$sort = " ptx_medal.medal_id DESC ";
		if(!$fields){
			$fields = $this->select_fields;
		}
		return $this->spPager($page, $pagesize)->findAllJoin($conditions,$sort,$fields);
	}

	public function search_no_page($conditions=NULL,$fields = null,$sort=null,$limit){
		$conditions = $this->init_conditions($conditions);
		if(!$sort)
			$sort = " ptx_medal.medal_id DESC ";
		if(!$fields){
			$fields = $this->select_fields;
		}
		return $this->findAllJoin($conditions,$sort,$fields,$limit);
	}

	public function find_one($conditions=NULL){
		return $this->findJoin($conditions," ptx_medal.medal_id DESC ",$this->select_fields);
	}

	public function add_one($data){
		if($this->check_value($data)){
			$data['create_time'] = time();
			$result = $this->create($data);
			$this->getMedals(true);
			return $result;
		}
		return false;
	}

	private function check_value($data){
		if(!$data['name']){
			return false;
		}
		return true;
	}
	
	public function getMedals($refresh=false,$time=1000){
		$medals = spAccess('r','medal_cache');
		if(!$medals||$refresh){
			$medals = $this->findAll();
			spAccess('w','medal_cache',$medals,$time);
		}
		return $medals;
	}
	
	public function getStaruserMedals($refresh=false,$time=1000){
		$medals = spAccess('r','medal_staruser_cache');
		if(!$medals||$refresh){
			$medals = $this->findAll(array('type'=>2));
			spAccess('w','medal_staruser_cache',$medals,$time);
		}
		return $medals;
	}
	
	public function getGoodshopMedals($refresh=false,$time=1000){
		$medals = spAccess('r','medal_goodshop_cache');
		if(!$medals||$refresh){
			$medals = $this->findAll(array('type'=>3));
			spAccess('w','medal_goodshop_cache',$medals,$time);
		}
		return $medals;
	}
}
