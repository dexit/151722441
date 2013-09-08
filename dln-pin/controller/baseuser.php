<?php
/**
 *      [PinTuXiu] (C)2001-2099 ONightjar.com Pintuxiu.com.
 *      This is NOT a freeware, use is subject to license terms
 */
class baseuser extends basecontroller {

	public function __construct() {
		parent::__construct();
	}

	public function set_user_banner($user_id){
		$logged_user_id = $this->current_user?$this->current_user['user_id']:0;
		if($user_id){
			$ptx_user = spClass('ptx_user');
			$user = $ptx_user->getuser_byid($user_id);
			$user['relation'] = $this->relationView($logged_user_id, $user_id);
			$this->user = $user;
		}
		if($logged_user_id>0&&$user_id==$logged_user_id){
			$this->controller = 'my';
		}else{
			$this->controller = 'pub';
		}
		$this->user['credits'] = array('name'=>T('credits'),'value'=>$this->user['credits']);
		$this->user['ext_credits_1'] = array('name'=>T('ext_credits_1'),'value'=>$this->user['ext_credits_1']);
		$this->user['ext_credits_2'] = array('name'=>T('ext_credits_2'),'value'=>$this->user['ext_credits_2']);
		$this->user['ext_credits_3'] = array('name'=>T('ext_credits_3'),'value'=>$this->user['ext_credits_3']);
		$this->user['group_title'] = T($this->usergroups[$this->user['usergroup_id']]['usergroup_title']);
		$this->seo_title($this->user['nickname'].T('s_home_page'));
		$this->tpl_user_banner = $this->render('user/userbanner');
		return $this->tpl_user_banner;
	}

	protected function userControl(){
		$ptx_user = spClass('ptx_user');
		$user = $ptx_user->getuser_byid($this->current_user['user_id']);
		$user['credits'] = array('name'=>T('credits'),'value'=>$user['credits']);
		$user['ext_credits_1'] = array('name'=>T('ext_credits_1'),'value'=>$user['ext_credits_1']);
		$user['ext_credits_2'] = array('name'=>T('ext_credits_2'),'value'=>$user['ext_credits_2']);
		$user['ext_credits_3'] = array('name'=>T('ext_credits_3'),'value'=>$user['ext_credits_3']);
		$user['group_title'] = T($this->usergroups[$user['usergroup_id']]['usergroup_title']);
		$this->user = $user;
		$this->activities = $this->userActivity($this->current_user['user_id']);
		//$this->tpl_usercontrol = $this->render('user/usercontrol');
		//$this->tpl_usernav = $this->render('/user/usernav.php');
		//$this->tpl_sidebar = $this->render('/user/sidebar.php');
	}

	protected function userControlPub($user_id){
		$ptx_user = spClass('ptx_user');
		$user = $ptx_user->getuser_byid($user_id);
		$user['credits'] = array('name'=>T('credits'),'value'=>$user['credits']);
		$user['ext_credits_1'] = array('name'=>T('ext_credits_1'),'value'=>$user['ext_credits_1']);
		$user['ext_credits_2'] = array('name'=>T('ext_credits_2'),'value'=>$user['ext_credits_2']);
		$user['ext_credits_3'] = array('name'=>T('ext_credits_3'),'value'=>$user['ext_credits_3']);
		$user['group_title'] = T($this->usergroups[$user['usergroup_id']]['usergroup_title']);
		$this->user = $user;
		$this->activities = $this->userActivity($user_id);
		$this->relationView = $this->relationView($this->current_user['user_id'], $user_id);
		//$this->tpl_usercontrol = $this->render('user/usercontrol_pub');
	}
	
	protected function userActivity($user_id){
		
		$ptx_event_log = spClass('ptx_event_log');
		$conditions = array();
		$conditions['to_user_id']=$user_id;
		//$conditions['event_type']='reward';
		$conditions['event_code']=array('join_group','post_comment','post_share','post_article','create_album','post_video','forward_share','add_like','add_follow','add_like_album','email_active','create_avatar');
		return $ptx_event_log->search_no_page($conditions,null,null,5);
	}

	public function shares($user_id){
		$num_per_page = 15;
		$args = array("page"=>"2");
		if($this->category_id){
			$conditions['category_id'] = $this->category_id;
			$args['cat']=$this->category_id;
		}
		if($user_id){
			$conditions['user_id'] = $user_id;
			$args['uid']=$user_id;
		}
		if($this->sname){
			$args['sname']=$this->sname;
		}

		$this->nextpage_url = spUrl($this->current_controller,$this->current_action, $args);
		$ptx_share = spClass('ptx_share');
		$shares = $ptx_share->search($conditions,$this->page,$num_per_page);
		$this->waterfallView($shares,'pin');
		$this->output("user/pin");
	}

	protected function at_shares($user_id){
		$num_per_page = 15;
		$args = array("page"=>"2");

		if($user_id){
			$conditions['keyword'] = 'atuser'.$user_id;
			$args['keyword']= 'atuser'.$user_id;
		}

		$this->nextpage_url = spUrl($this->current_controller,$this->current_action, $args);
		$ptx_share = spClass('ptx_share');
		$shares = $ptx_share->search($conditions,$this->page,$num_per_page);
		$this->waterfallView($shares,'pin');
		$this->output("user/pin");
	}

	protected function at_comments($user_id){
		$num_per_page = 10;
		$args = array("page"=>"2");

		if($user_id){
			$conditions['keyword'] = 'atuser'.$user_id;
			$args['keyword']= 'atuser'.$user_id;
		}
		$conditions['need_item']=true;
		$this->nextpage_url = spUrl($this->current_controller,$this->current_action, $args);
		$ptx_comment = spClass('ptx_comment');
		$this->comments = $ptx_comment->search($conditions,$this->page,$num_per_page);
		$this->pages = createTPages($ptx_comment->spPager()->getPager(), $this->current_controller, $this->current_action,$conditions);
		$this->output("user/comment");
	}

	protected function favorite_share($user_id){
		$num_per_page = 15;
		$args = array("page"=>"2");
		if($this->category_id){
			$conditions['category_id'] = $this->category_id;
			$args['cat']=$this->category_id;
		}
		if($this->sname){
			$args['sname']=$this->sname;
		}

		$ptx_favorite_sharing = spClass('ptx_favorite_sharing');
		$conditions['user_id'] = $user_id;

		$this->nextpage_url = spUrl($this->current_controller,$this->current_action, $args);
		$shares = $ptx_favorite_sharing->search($conditions,$this->page,$num_per_page);
		$this->waterfallView($shares,'pin');
		$this->output("user/pin");
	}

	protected function focus($user_id){
		$num_per_page = 15;
		$args = array("page"=>"2");
		if($this->category_id){
			$conditions['category_id'] = $this->category_id;
			$args['cat']=$this->category_id;
		}

		if($user_id){
			$ptx_relationship = spClass("ptx_relationship");
			$followings_conditions['user_id'] = $user_id;
			$args['uid']=$user_id;
			$followings_sql = $ptx_relationship->findAllSql($followings_conditions,null," friend_id ");
			$conditions['id_sub']['user_id'] = array($followings_sql,'\''.$user_id.'\'');
		}
		if($this->sname){
			$args['sname']=$this->sname;
		}

		$ptx_share = spClass('ptx_share');
		$this->nextpage_url = spUrl($this->current_controller,$this->current_action, $args);
		$shares = $ptx_share->search($conditions,$this->page,$num_per_page);
		$this->waterfallView($shares,'pin');
		$this->output("user/pin");
	}
	
	private function fillUserWithShare($users){
		$ptx_share = spClass("ptx_share");
		foreach ($users as $key=>$user) {
			$users[$key]['share']= $ptx_share->find_one(array('user_id'=>$user['user_id']));
		}
		return $users;
	}

	protected function following($user_id,$my_id){
		$num_per_page = 20;
		$ptx_relationship = spClass("ptx_relationship");

		$args = array("page"=>"2");
		if(is_numeric($user_id)){
			$conditions['user_id'] = $user_id;
			$args['uid']=$user_id;
		}else{
			return;
		}
		if($this->sname){
			$args['sname']=$this->sname;
		}
		$followings = $ptx_relationship->search($conditions,$this->page,$num_per_page," friend.* ");
		$followings = $this->fillUserWithShare($followings);
		$this->prepareView($followings,$my_id);
		$this->nextpage_url = spUrl($this->current_controller,$this->current_action, $args);
		$this->output("user/facewall");
	}

	protected function fans($user_id,$my_id){
		$num_per_page = 20;
		$ptx_relationship = spClass("ptx_relationship");

		$args = array("page"=>"2");
		if(is_numeric($user_id)){
			$conditions['friend_id'] = $user_id;
			$args['uid']=$user_id;
		}else{
			return;
		}
		if($this->sname){
			$args['sname']=$this->sname;
		}
		$fans = $ptx_relationship->search($conditions,$this->page,$num_per_page," user.* ");
		$fans = $this->fillUserWithShare($fans);
		$this->prepareView($fans,$my_id);
		$this->nextpage_url = spUrl($this->current_controller,$this->current_action, $args);
		$this->output("user/facewall");
	}


	protected function prepareView($friends,$user_id){
		foreach ($friends as $key=>$friend){
			$friends[$key]['relation_view'] = $this->relationView($user_id,$friend['user_id']);
		}
		$this->waterfallView($friends,'user');
	}

	public function album($user_id){
		$num_per_page = 15;

		$ptx_album = spClass('ptx_album');
		$args = array("page"=>"2");
		if($this->category_id){
			$conditions['category_id'] = $this->category_id;
			$args['cat']=$this->category_id;
		}
		if($user_id){
			$conditions['user_id'] = $user_id;
			$args['uid']=$user_id;
		}
		
		if($this->sname){
			$args['sname']=$this->sname;
		}
		$this->nextpage_url = spUrl($this->current_controller,$this->current_action, $args);
		$albums = $ptx_album->search($conditions,$this->page,$num_per_page);
		$this->waterfallView($albums,'album');
		$this->output("user/album");
	}

	protected function favorite_album($user_id)
	{
		$num_per_page = 15;
		$ptx_favorite_album=spClass("ptx_favorite_album");
		$args = array("page"=>"2");
		if($user_id){
			$conditions['user_id'] = $user_id;
			$args['uid']=$user_id;
		}
		if($this->sname){
			$args['sname']=$this->sname;
		}
		if($this->category_id){
			$conditions['category_id'] = $this->category_id;
			$args['cat']=$this->category_id;
		}
		$this->nextpage_url = spUrl($this->current_controller,$this->current_action, $args);
		$albums = $ptx_favorite_album->search($conditions,$this->page,$num_per_page);
		$this->waterfallView($albums,'album');
		$this->output("user/album");
	}
	
	protected function favorite_topic($user_id)
	{
		$num_per_page = 15;
		$ptx_favorite_topic=spClass("ptx_favorite_topic");
		$args = array("page"=>"2");
		if($user_id){
			$conditions['user_id'] = $user_id;
			$args['uid']=$user_id;
		}
		if($this->sname){
			$args['sname']=$this->sname;
		}
		$topics = $ptx_favorite_topic->search($conditions,$this->page,$num_per_page);
		$this->pages = createTPages($ptx_favorite_topic->spPager()->getPager(), $this->current_controller, $this->current_action,$args);
		$ptx_share = spClass('ptx_share');
		foreach ($topics as $key=>$topic){
			$share_conditions['keyword'] = 'topic'.$topic['topic_id'].'t';
			$shares = $ptx_share->search($share_conditions,1,5);
			$topics[$key]['shares'] = $shares;
		}
		$this->topics = $topics;
		
		$this->output("user/topics");
	}


	public function timeline($user_id){
		$num_per_page = 4;
		$args = array("page"=>2);
		if($this->category_id){
			$conditions['category_id'] = $this->category_id;
			$args['cat']=$this->category_id;
		}
		if($user_id){
			$conditions['user_id'] = $user_id;
			$args['uid']=$user_id;
		}
		if($this->sname){
			$args['sname']=$this->sname;
		}
		$next_time = $this->spArgs("next_time");
		$this->need_static = false;
		if($next_time){
			$now = $next_time;
		}else{
			$now = time();
			$this->need_static = ($this->page==1)?true:false;
		}
		$ptx_share = spClass('ptx_share');
		$conditions['lt_time'] = $now;
		$last_share = $ptx_share->find_one($conditions," ptx_share.create_time DESC "," ptx_share.share_id,ptx_share.create_time ");
		$last_time = $last_share['create_time'];

		$last_post_month = (int)date('m',$last_time);
		$last_post_month_days = (int)date('t',$last_time);
		$last_post_year = (int)date('Y',$last_time);

		$this_month_time_first = time(0,0,0,$last_post_month,1,$last_post_year);
		$this_month_time_last = time(24,59,59,$last_post_month,$last_post_month_days,$last_post_year);
		$conditions['gt_time'] = $this_month_time_first;
		$conditions['lt_time'] = $this_month_time_last;

		$this_month_last_share = $ptx_share->find_one($conditions," ptx_share.create_time DESC "," ptx_share.share_id,ptx_share.create_time ");
		//$this_month_total = $ptx_share->count($conditions);

		$shares = $ptx_share->search($conditions,$this->page,$num_per_page,NULL," ptx_share.create_time DESC ");
		if(array_length($shares)==$num_per_page){
			$next_search_time = $shares[$num_per_page-1]['create_time'];
		}else{
			$next_search_time = $this_month_time_first;
			$this->resetPage = true;
		}
		if($this_month_last_share['share_id']==$shares[0]['share_id']){
			if($this->lang=='zh_cn'){
				$this->timeline_date = $last_post_year.'年'.$last_post_month.'月';
			}else{
				$this->timeline_date = $last_post_year.'-'.$last_post_month;
			}
		}

		$args['next_time'] = $next_search_time;
		$this->nextpage_url = spUrl($this->current_controller,$this->current_action, $args);
		$this->timelineView($shares,'pin');
		//$this->set_user_banner($user_id);
		$this->output("user/timeline");
	}

	public function forumline($user_id){
		if($this->forum_open){
			$num_per_page = 4;
			$args = array("page"=>2);
			$uc_id = $this->spArgs('ucid');
			if($user_id){
				$conditions['user_id'] = $user_id;
				$args['uid']=$user_id;
				if(!$uc_id){
					$ptx_user = spClass("ptx_user");
					$user = $ptx_user->getuser_byid($user_id);
					$uc_id = $user['uc_id'];
				}
			}
			if(!$uc_id||!is_numeric($uc_id)){
				spError(T('no_bbs_account_bind'));
				return ;
			}
			$args['ucid'] = $uc_id;
			$conditions['authorid'] = $uc_id;
			$next_time = $this->spArgs("next_time");
			$this->need_static = false;
			if($next_time){
				$now = $next_time;
			}else{
				$now = time();
				$this->need_static = ($this->page==1)?true:false;
			}
			$forum_post = spClass('forum_post');
			$conditions['lt_time'] = $now;
			$last_post = $forum_post->find_one($conditions," forum_post.dateline DESC "," forum_post.pid,forum_post.dateline ");
			$last_time = $last_post['dateline'];

			$last_post_month = (int)date('m',$last_time);
			$last_post_month_days = (int)date('t',$last_time);
			$last_post_year = (int)date('Y',$last_time);

			$this_month_time_first = time(0,0,0,$last_post_month,1,$last_post_year);
			$this_month_time_last = time(24,59,59,$last_post_month,$last_post_month_days,$last_post_year);
			$conditions['gt_time'] = $this_month_time_first;
			$conditions['lt_time'] = $this_month_time_last;

			$this_month_last_post = $forum_post->find_one($conditions," forum_post.dateline DESC "," forum_post.pid,forum_post.dateline ");
			$posts = $forum_post->search($conditions,$this->page,$num_per_page,NULL," forum_post.dateline DESC ");
			if(array_length($posts)==$num_per_page){
				$next_search_time = $posts[$num_per_page-1]['dateline'];
				//$this->resetPage = true;
			}else{
				$next_search_time = $this_month_time_first;
				$this->resetPage = true;
			}
			if($this_month_last_post['pid']==$posts[0]['pid']){
				$this->timeline_date = $last_post_year.'年'.$last_post_month.'月';
			}
			$forum_attachment = spClass('forum_attachment');
			foreach ($posts as $key=>$post) {
				$posts[$key]['images'] = $forum_attachment->search_attach_images($post['pid']);
				$post['message'] = messageclean($post['message']);
				$post['message'] = tpl_modifier_bbcode2html($post['message']);
				$posts[$key]['message'] = $post['message'];
			}
			$args['next_time'] = $next_search_time;
			$this->nextpage_url = spUrl($this->current_controller,$this->current_action, $args);
			$this->forumlineView($posts,'post');
			//$this->set_user_banner($user_id);
			$this->output("user/forumline");
		}
	}


	public function album_shares(){
		$num_per_page = 15;
		$ptx_album = spClass('ptx_album');
		$data['album_id'] = $this->album_id;
		if(!$this->album_id||!($album = $ptx_album->find($data))){
			$this->error(T('album_not_existed'));
			return ;
		}

		if($this->page == 1){
			if($this->is_login()&&$album['user_id']==$this->current_user['user_id']){
				$this->userControl();
			}else{
				$this->userControlPub($album['user_id']);
			}
		}

		$args = array("page"=>"2");
		if($this->category_id){
			$conditions['category_id'] = $this->category_id;
			$args['cat']=$this->category_id;
		}
		if($this->album_id){
			$conditions['album_id'] = $this->album_id;
			$args['aid']=$this->album_id;
		}
		$this->album = $album;
		$this->action_title = T('album').':'.$album['album_title'];
		$this->nextpage_url = spUrl($this->current_controller,$this->current_action, $args);
		$ptx_share = spClass('ptx_share');
		$shares = $ptx_share->search($conditions,$this->page,$num_per_page);
		$this->waterfallView($shares,'pin');
		$this->output("user/pin");
	}
}

