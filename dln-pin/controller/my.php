<?php
/**
 *      [PinTuXiu] (C)2001-2099 ONightjar.com Pintuxiu.com.
 *      This is NOT a freeware, use is subject to license terms
 */
class my extends baseuser {

	public function __construct() {
		parent::__construct();
		$this->seo_title(T('my_pin'));
	}

	public function index(){
		$this->focus();
	}

	public function focus( $user_id = null ){
		$this->check_login();
		if($this->page==1){
			$this->userControl();
		}
		parent::focus($this->current_user['user_id']);
	}

	public function shares( $user_id = null ){
		$this->check_login();
		if($this->page==1){
			$this->userControl();
		}
		parent::shares($this->current_user['user_id']);
	}

	public function at_shares( $user_id = null ){
		$this->check_login();
		if($this->page==1){
			$this->userControl();
		}
		parent::at_shares($this->current_user['user_id']);
	}

	public function at_comments( $user_id = null ){
		$this->check_login();
		$this->userControl();
		parent::at_comments($this->current_user['user_id']);
	}

	public function album( $user_id = null ){
		$this->check_login();
		if($this->page==1){
			$this->userControl();
		}
		parent::album($this->current_user['user_id']);
	}

	public function favorite_share( $user_id = null ){
		$this->check_login();
		if($this->page==1){
			$this->userControl();
		}
		parent::favorite_share($this->current_user['user_id']);
	}

	public function favorite_album( $user_id = null ){
		$this->check_login();
		if($this->page==1){
			$this->userControl();
		}
		parent::favorite_album($this->current_user['user_id']);
	}
	
	public function favorite_topic( $user_id = null ){
		$this->check_login();
		if($this->page==1){
			$this->userControl();
		}
		parent::favorite_topic($this->current_user['user_id']);
	}
	
	public function following( $user_id = null, $my_id = null ){
		$this->check_login();
		if($this->page==1){
			$this->userControl();
		}
		parent::following($this->current_user['user_id'],$this->current_user['user_id']);
	}

	public function fans( $user_id = null, $my_id = null ){
		$this->check_login();
		if($this->page==1){
			$this->userControl();
		}
		parent::fans($this->current_user['user_id'],$this->current_user['user_id']);
	}

	public function timeline( $user_id = null ){
		$this->check_login();
		if($this->page==1){
			//$this->set_user_banner($this->current_user['user_id']);
			$this->userControl();
		}
		parent::timeline($this->current_user['user_id']);
	}

	public function forumline( $user_id = null ){
		$this->check_login();
		if($this->page==1){
			//$this->set_user_banner($this->current_user['user_id']);
			$this->userControl();
		}
		parent::forumline($this->current_user['user_id']);
	}

	public function setting_basic(){
		$this->check_login();
		if($this->page==1){
			$this->userControl();
		}

		$this->output("user/setting_basic");
	}

	public function setting_forum(){
		$this->check_login();
		if($this->page==1){
			$this->userControl();
		}
		$this->output("user/setting_forum");
	}

	public function setting_bind(){
		$this->check_login();
		if($this->page==1){
			$this->userControl();
		}
		$connector = spClass('ptx_connector');
		$this->bind_connectors = $connector->get_bind_connectors($this->user['user_id']);
		$cs = array();
		foreach ($this->bind_connectors as $c){
			$vendor = $c['vendor'];
			$cs[$vendor]['id'] = $c['connect_id'];
			$cs[$vendor]['username'] = $c['username'];
		}
		$this->cs = $cs;
		$this->output("user/setting_bind");
	}

	public function setting_security(){
		$this->check_login();
		if($this->page==1){
			$this->userControl();
		}
		$this->output("user/setting_security");
	}

	public function setting_shop(){
		$this->check_login();
		if($this->page==1){
			$this->userControl();
		}
		$ptx_goodshop = spClass('ptx_goodshop');
		$condition['user_id'] = $this->user['user_id'];
		$this->shop = $ptx_goodshop->find_one($condition);
		$this->output("user/setting_shop");
	}
	
	public function update_shop(){
		$this->ajax_check_login();
		
		$data['store_name'] = $this->spArgs("store_name");
		$data['phone'] = $this->spArgs("phone");
		$data['province'] = $this->spArgs("province");
		$data['city'] = $this->spArgs("city");
		$data['address'] = $this->spArgs("address");
		$data['shop_time'] = $this->spArgs("shop_time");
		$data['shop_desc'] = $this->spArgs("shop_desc");
		
		if($data['store_name']){
			$ptx_goodshop = spClass("ptx_goodshop");
			$ptx_goodshop->update(array('user_id'=>$this->current_user['user_id']),$data);
			$this->ajax_success_response(null, T('operate_succeed'));
			return;
		}
		$this->ajax_failed_response();
	}

	public function setting_star(){
		$this->check_login();
		if($this->page==1){
			$this->userControl();
		}
		$ptx_staruser = spClass('ptx_staruser');
		$condition['user_id'] = $this->user['user_id'];
		$this->staruser = $ptx_staruser->find_one($condition);
		$this->output("user/setting_star");
	}

	public function message(){
		$this->check_login();
		$this->userControl();

		$num_per_page = 10;
		$ptx_user = spClass('ptx_user');
		$ptx_message = spClass('ptx_message');
		//$conditions['to_user_id'] = $this->current_user['user_id'];
		$conditions = ' ptx_message.to_user_id=\''.$this->current_user['user_id'].'\' OR ptx_message.from_user_id=\''.$this->current_user['user_id'].'\' ';
		$this->messages = $ptx_message->search($conditions,$this->page,$num_per_page);
		$this->pages = createTPages($ptx_message->spPager()->getPager(), $this->current_controller, $this->current_action,array());
		
		if($this->page==1){
			$conditions_update['to_user_id']=$this->current_user['user_id'];
			$conditions_update['is_read']='0';
			$ptx_message->update($conditions_update,array('is_read'=>1));
		}
		$this->output("user/message");

	}

	public function alert(){
		$this->check_login();
		$this->userControl();
		$num_per_page = 10;
		$ptx_event_log = spClass('ptx_event_log');
		$conditions = array();
		$conditions['to_user_id']=$this->current_user['user_id'];
		$conditions['event_type']='alert';
		$this->alerts = $ptx_event_log->search($conditions,$this->page,$num_per_page);
		$this->pages = createTPages($ptx_event_log->spPager()->getPager(), $this->current_controller, $this->current_action,array());
		if($this->page==1){
			$conditions_update['to_user_id']=$this->current_user['user_id'];
			$conditions_update['event_type']='alert';
			$conditions_update['is_read']='0';
			$ptx_event_log->update($conditions_update,array('is_read'=>1));
		}
		
		$this->output("user/alert");

	}

	public function topics(){
		$this->check_login();
		$this->userControl();
		
		$num_per_page = 5;
		$ptx_topic = spClass("ptx_topic");
		$category_id =  $this->spArgs("category_id");
		$args = array();
		if($category_id){
			$conditions['category_id'] = $category_id;
			$args['category_id'] = $category_id;
		}
		
		$conditions['user_id'] = $this->current_user['user_id'];;
		
		$topics = $ptx_topic->search($conditions,$this->page,$num_per_page);
		$this->pages = createTPages($ptx_topic->spPager()->getPager(), $this->current_controller, $this->current_action,$args);
		$ptx_share = spClass('ptx_share');
		foreach ($topics as $key=>$topic){
			$share_conditions['keyword'] = 'topic'.$topic['topic_id'].'t';
			$shares = $ptx_share->search($share_conditions,1,5);
			$topics[$key]['shares'] = $shares;
		}
		$this->topics = $topics;
		
		$this->output("user/topics");
	}

	public function album_create(){
		$this->check_login();
		if($this->spArgs("submit")){
			$data = $this->update_album_common();
			$ptx_album = spClass("ptx_album");
			if($albumid = $ptx_album->add_one($data)){
				
				$event_dispatcher = spClass('event_dispatcher');
				$event_data['to_user_id'] = $this->current_user['user_id'];
				$event_data['to_nickname'] = $this->current_user['nickname'];
				$event_data['album_id'] = $albumid;
				$event_data['album_title'] = $data['album_title'];
				$event_dispatcher->invoke('create_album',$event_data);
				
				$this->ajax_success_response(null, T('save_success'));
			}else{
				$this->ajax_failed_response(T('save_failed'));
			}
		}else {
			$this->userControl();
			$this->output("user/album_create");
		}
	}
	
	public function album_update(){
		$this->check_login();
		$album_id =  $this->spArgs("albumid");
		if(!$album_id){
			$this->ajax_failed_response(T('lost_param'));
		}
		
		$ptx_album = spClass("ptx_album");
		$condition['album_id'] = $album_id;
		
		if($this->album = $ptx_album->find_one($condition)){
			if($this->album['user_id']!=$this->current_user['user_id']){
				$this->error(T('illegal_operation'));
			}
		}else {
			$this->error(T('illegal_operation'));
		}
		
		if($this->spArgs("submit")){
			$data = $this->update_album_common();
			if($ptx_album->update(array('album_id'=>$album_id),$data)){
				$this->ajax_success_response(null, T('save_success'));
			}else{
				$this->ajax_failed_response(T('save_failed'));
			}
		}else {
			$this->userControl();
			$this->output("user/album_update");
		}
	}
	
	public function update_album_common(){
		$album_title =  $this->spArgs("album_title");
		$album_desc =  $this->spArgs("album_desc");
		$category_id =  $this->spArgs("category_id");
	
		if(!$album_title||!$category_id){
			$this->ajax_failed_response(T('lost_param'));
		}
		$data['album_title'] = $album_title;
		$data['album_desc'] = $album_desc;
		$data['category_id'] = $category_id;
		$data['user_id'] = $this->current_user['user_id'];
	
		return $data;
	}
	
	public function create_topic(){
		$this->check_login();
		if($this->spArgs("submit")){
			$data = $this->update_topic_common();
			$ptx_topic = spClass("ptx_topic");
			if($ptx_topic->add_one($data)){
				$this->ajax_success_response(null, T('save_success'));
			}else{
				$this->ajax_failed_response(T('save_failed'));
			}
		}else {
			$this->userControl();
			$this->output("user/create_topic");
		}
	}

	public function update_topic(){
		$this->check_login();
		$topic_id =  $this->spArgs("topicid");
		if(!$topic_id){
			$this->ajax_failed_response(T('lost_param'));
		}
		$ptx_topic = spClass("ptx_topic");
		$condition['topic_id'] = $topic_id;
		if($this->topic = $ptx_topic->find_one($condition)){
			if($this->topic['user_id']!=$this->current_user['user_id']){
				$this->error(T('illegal_operation'));
			}
		}else {
			$this->error(T('illegal_operation'));
		}

		if($this->spArgs("submit")){
			$data = $this->update_topic_common();
			if($ptx_topic->update(array('topic_id'=>$topic_id),$data)){
				$this->ajax_success_response(null, T('save_success'));
			}else{
				$this->ajax_failed_response(T('save_failed'));
			}
		}else {
			$this->userControl();
			$this->output("user/update_topic");
		}
	}
	
	public function save_tbanner(){
		$this->ajax_check_login();
		$topic_id =  $this->spArgs("topicid");
		if(!$topic_id){
			$this->ajax_failed_response(T('lost_param'));
		}
		
		$ptx_topic = spClass("ptx_topic");
		
		$condition['topic_id'] = $topic_id;
		
		if($this->topic = $ptx_topic->find_one($condition)){
			if($this->topic['user_id']!=$this->current_user['user_id']){
				$this->error(T('illegal_operation'));
			}
		}else {
			$this->error(T('illegal_operation'));
		}
		
		$x = $this->spArgs("x");
		$y = $this->spArgs("y");
		$w = $this->spArgs("w");
		$h = $this->spArgs("h");
		$js_w = $this->spArgs("js_w");
		$js_h = $this->spArgs("js_h");
		$type = $this->spArgs("type");
		$filename = $this->spArgs("filename");
		$temp_dir = '/data/attachments/tmp/';
	
		if($filename){
			$imagelib = spClass("ImageLib");
			$imagepath = APP_PATH.$temp_dir.$filename;
			$image_size=getimagesize($imagepath);
			$weight=$image_size[0];
			$height=$image_size[1];
			if($js_w<$weight){
				$scale = $js_w/$weight;
			}elseif ($js_h<$height){
				$scale = $js_h/$height;
			}else{
				$scale = 1;
			}
			$x = $x/$scale;
			$y = $y/$scale;
			$w = $w/$scale;
			$h = $h/$scale;
	
			$imagelib->crop_image($imagepath,$imagepath,$x,$y,$w,$h);
	
			$banner_info = banner_path($topic_id);
			$banner_dir = APP_PATH.'/'.$banner_info['dir'];
			(!is_dir($banner_dir))&&@mkdir($banner_dir,0777,true);
			file_exists($banner_dir.$banner_info['filename']) && unlink($banner_dir.$banner_info['filename']);
			$imagelib->create_thumb($imagepath,NULL,940,250,$banner_dir.$banner_info['filename']);
			unlink($imagepath);
			$data['banner']= $banner_info['dir'].$banner_info['filename'];
			$data['hash'] = random(3);
			$this->ajax_success_response($data, T('operate_succeed'));
			return;
		}
		$this->ajax_failed_response(T('operate_failed'));
		return;
	}
	
	public function update_topic_common(){
		$topic_title =  $this->spArgs("topic_title");
		$topic_desc =  $this->spArgs("topic_desc");
		$category_id =  $this->spArgs("category_id");
		$keyword =  $this->spArgs("keyword");

		if(!$topic_title||!$category_id){
			$this->ajax_failed_response(T('lost_param'));
		}
		$keyword_search = str_replace(',', ' ', $keyword);
		$segment = spClass('Segment');
		$keyword_search = $segment->convert_to_py($keyword_search);
		$data['topic_title'] = $topic_title;
		$data['topic_desc'] = $topic_desc;
		$data['category_id'] = $category_id;
		$data['keyword'] = $keyword;
		$data['keyword_search'] = $keyword_search;
		$data['user_id'] = $this->current_user['user_id'];

		return $data;
	}
	
	public function groups(){
		$this->check_login();
		$this->userControl();
	
		$num_per_page = 10;
		$ptx_group = spClass("ptx_group");
		$category_id =  $this->spArgs("category_id");
		$args = array();
		if($category_id){
			$conditions['category_id'] = $category_id;
			$args['category_id'] = $category_id;
		}
	
		$conditions['user_id'] = $this->current_user['user_id'];
	
		$groups = $ptx_group->search($conditions,$this->page,$num_per_page);
		$this->pages = createTPages($ptx_group->spPager()->getPager(), $this->current_controller, $this->current_action,$args);
		$ptx_share = spClass('ptx_share');
		
		foreach ($groups as $key=>$group){
			$share_conditions['keyword'] = 'group'.$group['group_id'].'g';
			$shares = $ptx_share->count($share_conditions);
			$groups[$key]['total_share'] = $shares;
		}
		
		$this->groups = $groups;
	
		$this->output("user/groups");
	}
	
	public function create_group(){
		$this->check_login();
		if($this->spArgs("submit")){
			$data = $this->update_group_common();
			$ptx_group = spClass("ptx_group");
			if($gid = $ptx_group->add_one($data)){
				$ptx_user_group = spClass("ptx_user_group");
				$ugdata['user_id'] = $this->current_user['user_id'];
				$ugdata['group_id'] = $gid;
				$ugdata['is_admin'] = 1;
				$ptx_user_group->add_one($ugdata);
				$ptx_group->update_total_member($gid);
				$this->ajax_success_response(null, T('save_success'));
			}else{
				$this->ajax_failed_response(T('save_failed'));
			}
		}else {
			$this->userControl();
			$this->output("user/create_group");
		}
	}
	
	public function update_group(){
		$this->check_login();
		$groupid =  $this->spArgs("groupid");
		if(!$groupid){
			$this->ajax_failed_response(T('lost_param'));
		}
		
		$ptx_user_group = spClass("ptx_user_group");
		
		$condition['user_id'] = $this->current_user['user_id'];
		$condition['group_id'] = $groupid;
		
		if($this->group = $ptx_user_group->find_one($condition," pgroup.*,ptx_user_group.is_admin ")){
			if(!$this->group['is_admin']){
				$this->error(T('illegal_operation'));
			}
		}else {
				$this->error(T('illegal_operation'));
		}
	
		if($this->spArgs("submit")){
			$data = $this->update_group_common();
			$ptx_group = spClass("ptx_group");
			if($ptx_group->update(array('group_id'=>$groupid),$data)){
				$this->ajax_success_response(null, T('save_success'));
			}else{
				$this->ajax_failed_response(T('save_failed'));
			}
		}else {
			$this->userControl();
			$this->output("user/update_group");
		}
	}
	
	public function save_gbanner(){
		$this->ajax_check_login();
		$groupid =  $this->spArgs("groupid");
		if(!$groupid){
			$this->ajax_failed_response(T('lost_param'));
		}
		
		$ptx_user_group = spClass("ptx_user_group");
		
		$condition['user_id'] = $this->current_user['user_id'];
		$condition['group_id'] = $groupid;
		
		if($this->group = $ptx_user_group->find_one($condition," pgroup.*,ptx_user_group.is_admin ")){
			if(!$this->group['is_admin']){
				$this->error(T('illegal_operation'));
			}
		}else {
				$this->error(T('illegal_operation'));
		}
	
		$x = $this->spArgs("x");
		$y = $this->spArgs("y");
		$w = $this->spArgs("w");
		$h = $this->spArgs("h");
		$js_w = $this->spArgs("js_w");
		$js_h = $this->spArgs("js_h");
		$type = $this->spArgs("type");
		$filename = $this->spArgs("filename");
		$temp_dir = '/data/attachments/tmp/';
	
		if($filename){
			$imagelib = spClass("ImageLib");
			$imagepath = APP_PATH.$temp_dir.$filename;
			$image_size=getimagesize($imagepath);
			$weight=$image_size[0];
			$height=$image_size[1];
			if($js_w<$weight){
				$scale = $js_w/$weight;
			}elseif ($js_h<$height){
				$scale = $js_h/$height;
			}else{
				$scale = 1;
			}
			$x = $x/$scale;
			$y = $y/$scale;
			$w = $w/$scale;
			$h = $h/$scale;
	
			$imagelib->crop_image($imagepath,$imagepath,$x,$y,$w,$h);
	
			$banner_info = banner_path($groupid,'group');
			$banner_dir = APP_PATH.'/'.$banner_info['dir'];
			(!is_dir($banner_dir))&&@mkdir($banner_dir,0777,true);
			file_exists($banner_dir.$banner_info['filename']) && unlink($banner_dir.$banner_info['filename']);
			$imagelib->create_thumb($imagepath,NULL,180,180,$banner_dir.$banner_info['filename']);
			unlink($imagepath);
			$data['banner']= $banner_info['dir'].$banner_info['filename'];
			$data['hash'] = random(3);
			$this->ajax_success_response($data, T('operate_succeed'));
			return;
		}
		$this->ajax_failed_response(T('operate_failed'));
		return;
	}
	
	private function update_group_common(){
		$group_title =  $this->spArgs("group_title");
		$group_desc =  $this->spArgs("group_desc");
		$category_id =  $this->spArgs("category_id");
		$keyword =  $this->spArgs("keyword");
	
		if(!$group_title||!$category_id){
			$this->ajax_failed_response(T('lost_param'));
		}
		$keyword_search = str_replace(',', ' ', $keyword);
		$segment = spClass('Segment');
		$keyword_search = $segment->convert_to_py($keyword_search);
		$data['group_title'] = $group_title;
		$data['group_desc'] = $group_desc;
		$data['category_id'] = $category_id;
		$data['keyword'] = $keyword;
		$data['keyword_search'] = $keyword_search;
		$data['user_id'] = $this->current_user['user_id'];
		return $data;
	}
	
	public function sendmessage(){
		$this->ajax_check_login();
		$message_user =  $this->spArgs("message_user");
		$message_content =  $this->spArgs("message_content");
		
		$ptx_user = spClass("ptx_user");
		if($user=$ptx_user->getuser_bynick($message_user)){
			
			$data['from_user_id'] = $this->current_user['user_id'];
			$data['to_user_id'] = $user['user_id'];
			$data['message_txt'] = $message_content;
			
			$ptx_message=spClass("ptx_message");
			$ptx_message->add_one($data);
			$this->ajax_success_response(null, T('operate_succeed'));
			return;
		}
		$this->ajax_failed_response(T('user_not_existed'));
		return;
		
	}

}

