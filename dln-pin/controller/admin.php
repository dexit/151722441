<?php
/**
 *      [PinTuXiu] (C)2001-2099 ONightjar.com Pintuxiu.com.
 *      This is NOT a freeware, use is subject to license terms
 */
class admin extends basecontroller {

	public function __construct() {
		parent::__construct();
		$this->themes = '';
		$this->ptx_settings = spClass('ptx_settings');
		$this->setting_nav = $this->render("admin/setting_nav");
		$this->setting_header = $this->render("admin/setting_header");
		$this->ui_nav = $this->render("admin/ui_nav");
		$this->forum_nav = $this->render("admin/forum_nav");
	}


	public function index()
	{
		if($this->check_admin()){
			$this->action = 'index';
			$this->display("/admin/index.php");
		}
	}

	public function login()
	{
		if($this->is_admin()){
			$this->jump(spUrl('admin', 'index'));
			return;
		}

		$this->user_lib->remove_session();
		if($email = $this->spArgs("email")){
			$password = md5($this->spArgs('password'));
			$ptx_user = spClass('ptx_user');
			$user = $ptx_user->find(array('email'=>$email));
			if($user){
				if( $user['passwd'] == $password&&$user['user_type']==3){
					$this->user_lib->set_session($user,false);
					$this->jump(spUrl('admin', 'index'));
					return true;
				}
			}
		}
		$this->display("/admin/login.php");

	}

	public function logout()
	{
		$this->check_admin();
		$this->user_lib->remove_session();
		$this->jump(spUrl('admin', 'login'));
	}

	public function dashboard()
	{
		if($this->check_admin()){
			$this->action = 'dashboard';
			$this->display("/admin/dashboard.php");
		}
	}

	private function url_rewrite($open=FALSE){
		$config = spClass('Options');
		if($config->load('config.php')){
			$lanuch_rewrite = array(
					'router_prefilter' => array(
							array('spUrlRewrite', 'setReWrite'),
					),
					'function_url' => array(
							array("spUrlRewrite", "getReWrite"),
					),
			);
			if ($open) {
				$config->set_item('launch',$lanuch_rewrite);
				$config->save('config.php');
			}else{
				$config->set_item('launch','');
				$config->save('config.php');
			}
		}
	}

	private function open_gzip($open=FALSE,$level=9){
		$config = spClass('Options');
		if($config->load('config.php')){
			$gzip = array (
					'gzip' => $open,
					'gzip_compression_level'=>$level,
			);
			$config->set_item('optimizer',$gzip);
			$config->save('config.php');
		}
	}

	public function setting_basic()
	{
		if($this->check_admin()){
			$action = $this->spArgs("act");
			if($action=='save'){
				$basic_setting = array();
				$basic_setting['site_name'] = $this->spArgs("site_name");
				$basic_setting['site_domain'] = $this->spArgs("site_domain");
				$basic_setting['site_beian'] = $this->spArgs("site_beian");
				$basic_setting['site_tongji'] = stripslashes($this->spArgs("site_tongji",'','POST','false'));
				$basic_setting['site_need_verify'] = $this->spArgs("site_need_verify");
				$basic_setting['forbid_user_post'] = $this->spArgs("forbid_user_post");
				$basic_setting['site_close'] = $this->spArgs("site_close");
				$basic_setting['lang'] = $this->spArgs("lang");
				$this->session->set_data('lang',$basic_setting['lang']);
				$this->ptx_settings->set_value('basic_setting',$basic_setting);
				$this->ptx_settings->updateSettings();
				admin_show_message(T('save_success'),$this,spUrl('admin','setting_basic'));
			}else{
				$locals_dir = APP_PATH.'/lang/';
				$file_list = get_dir_file_info($locals_dir);
				$dir = array();
				foreach ($file_list as $d) {
					$dir[] = $d['name'];
				}
				$this->dirs = $dir;
				$this->site_info = $this->settings['basic_setting'];
				$this->display("/admin/setting_basic.php");
			}
		}
	}

	public function setting_optimizer()
	{
		if($this->check_admin()){
			$action = $this->spArgs("act");
			if($action=='save'){
				$basic_setting = array();
				$basic_setting['cache_time_album'] = $this->spArgs("cache_time_album");
				$basic_setting['cache_time_star'] = $this->spArgs("cache_time_star");
				$basic_setting['cache_time_count'] = $this->spArgs("cache_time_count");
				$basic_setting['gzip_level'] = $this->spArgs("gzip_level");
				$basic_setting['gzip_open'] = $this->spArgs("gzip_open");
				$basic_setting['rewrite_open'] = $this->spArgs("rewrite_open");
				$basic_setting['site_open'] = $this->spArgs("site_open");
				$this->ptx_settings->set_value('optimizer_setting',$basic_setting);
				$this->ptx_settings->updateSettings();
				$this->open_gzip($basic_setting['gzip_open'],$basic_setting['gzip_level']);
				$this->url_rewrite($basic_setting['rewrite_open']);
				admin_show_message(T('save_success'),$this,spUrl('admin','setting_optimizer'));
			}else{
				$this->vsettings = $this->settings['optimizer_setting'];
				$this->display("/admin/setting_optimizer.php");
			}
		}
	}

	public function setting_seo()
	{
		if($this->check_admin()){
			$action = $this->spArgs("act");
			if($action=='save'){
				$basic_setting = array();
				$basic_setting['page_title'] = $this->spArgs("page_title");
				$basic_setting['page_keywords'] = $this->spArgs("page_keywords");
				$basic_setting['page_description'] = $this->spArgs("page_description");
				$this->ptx_settings->set_value('seo_setting',$basic_setting);
				$this->ptx_settings->updateSettings();
				admin_show_message(T('save_success'),$this,spUrl('admin','setting_seo'));
			}else{
				$this->vsettings = $this->settings['seo_setting'];
				$this->display("/admin/setting_seo.php");
			}
		}
	}


	public function setting_vcode(){
		if($this->check_admin()){
			$action = $this->spArgs("act");
			$this->events = array('register','login','post','update_password');
			if($action=='save'){
				$vcode_setting = array();
				foreach ($this->events as $event){
					$vcode_setting[$event] = $this->spArgs($event,0);
				}
				$this->ptx_settings->set_value('vcode_setting',$vcode_setting);
				$this->ptx_settings->updateSettings();
				admin_show_message(T('save_success'),$this,spUrl('admin','setting_vcode'));
			}else{
				$this->vsettings = $this->settings['vcode_setting'];
				$this->display("/admin/setting_vcode.php");
			}
		}
	}


	public function setting_file()
	{
		if($this->check_admin()){
			$action = $this->spArgs("act");
			if($action=='save'){
				$basic_setting = array();
				$basic_setting['upload_file_size'] = $this->spArgs("upload_file_size");
				$basic_setting['upload_file_type'] = $this->spArgs("upload_file_type");
				$basic_setting['upload_image_size_h'] = $this->spArgs("upload_image_size_h");
				$basic_setting['upload_image_size_w'] = $this->spArgs("upload_image_size_w");
				$basic_setting['fetch_image_size_w'] = $this->spArgs("fetch_image_size_w");
				$basic_setting['fetch_image_size_h'] = $this->spArgs("fetch_image_size_h");
				$this->ptx_settings->set_value('file_setting',$basic_setting);
				$this->ptx_settings->updateSettings();
				admin_show_message(T('save_success'),$this,spUrl('admin','setting_file'));
			}else{
				$this->vsettings = $this->settings['file_setting'];
				$this->display("/admin/setting_file.php");
			}
		}
	}
	//12621817
	//deedb91dfa096e1a9defcb688cfb783a
	//31157669
	public function setting_api()
	{
		//$this->vendors = array('Taobao','Sina','Renren','QQ','Facebook','Twitter');
		if($this->check_admin()){
			$action = $this->spArgs("act");
			if($action=='save'){
				$basic_setting = array();
				foreach ($this->vendors as $vendor) {
					$lowerkey = strtolower($vendor);
					$basic_setting[$vendor]=array(
							'OPEN'=>$this->spArgs($lowerkey.'_open'),
							'APPKEY'=>$this->spArgs($lowerkey.'_appkey'),
							'APPSECRET'=>$this->spArgs($lowerkey.'_appsecret'),
							'CALLBACK'=>$this->spArgs($lowerkey.'_callback'),
							'PID'=>$this->spArgs($lowerkey.'_pid')
					);
				}

				$this->ptx_settings->set_value('api_setting',$basic_setting);
				$this->ptx_settings->updateSettings();
				admin_show_message(T('save_success'),$this,spUrl('admin','setting_api'));
			}else{
				$this->api = $this->settings['api_setting'];
				$this->api_callback = base_url().'index.php?c=social&a=callback&vendor=';
				$this->display("/admin/setting_api.php");
			}
		}
	}


	public function setting_update()
	{
		if($this->check_admin()){

			$this->display("/admin/setting_update.php");
		}
	}

	public function ui_layout(){
		if($this->check_admin()){
			$action = $this->spArgs("act");
			if($action=='save'){
				$basic_setting = array();
				$basic_setting['homepage_ad'] = $this->spArgs("homepage_ad");
				$basic_setting['pin_auto'] = $this->spArgs("pin_auto");
				$basic_setting['album_auto'] = $this->spArgs("album_auto");
				$basic_setting['face_auto'] = $this->spArgs("face_auto");
				$basic_setting['user_pin_auto'] = $this->spArgs("user_pin_auto");
				$basic_setting['pin_pagenum'] = $this->spArgs("pin_pagenum");
				$basic_setting['face_pagenum'] = $this->spArgs("face_pagenum");
				$basic_setting['count_or_lastest'] = $this->spArgs("count_or_lastest",'count');
				$basic_setting['orgin_post'] = $this->spArgs("orgin_post",0);
				$basic_setting['login_reminder'] = $this->spArgs("login_reminder",0);
				$this->ptx_settings->set_value('ui_layout',$basic_setting);
				$this->ptx_settings->updateSettings();
				admin_show_message(T('save_success'),$this,spUrl('admin','ui_layout'));
			}else{
				$this->vsettings = $this->settings['ui_layout'];
				$this->display("/admin/ui_layout.php");
			}

		}
	}

	public function ui_pin(){
		if($this->check_admin()){
			$action = $this->spArgs("act");
			if($action=='save'){
				$basic_setting = array();
				$basic_setting['pin_commentnum'] = $this->spArgs("pin_commentnum");
				$basic_setting['pin_imagewidth'] = $this->spArgs("pin_imagewidth");
				$basic_setting['pin_ad'] = $this->spArgs("pin_ad");
				$this->ptx_settings->set_value('ui_pin',$basic_setting);
				$this->ptx_settings->updateSettings();
				if($this->spArgs("recreate")){
					$url = spUrl('admin', 'recreate_pin',array('page'=>1));
					admin_show_message(T('save_success').' '.T('save_recreat_pin'), $this, $url,2000);
				}else{
					admin_show_message(T('save_success'),$this,spUrl('admin','ui_pin'));
				}
			}else{
				$this->vsettings = $this->settings['ui_pin'];
				$this->display("/admin/ui_pin.php");
			}

		}
	}

	public function ui_album(){
		if($this->check_admin()){
			$action = $this->spArgs("act");
			if($action=='save'){
				$album_setting = array('album_covernum'=>1,'album_covertype'=>9,'album_tags'=>'');
				$basic_setting = array();
				foreach ($album_setting as $key=>$value){
					$basic_setting[$key] = $this->spArgs($key,$value);
				}
				$this->ptx_settings->set_value('ui_album',$basic_setting);
				$this->ptx_settings->updateSettings();
				if($this->spArgs("recreate")){
					$url = spUrl('admin', 'recreate_album',array('page'=>1));
					admin_show_message(T('save_success').' '.T('save_recreat_album'), $this, $url,2000);
				}else{
					admin_show_message(T('save_success'),$this,spUrl('admin','ui_album'));
				}
			}else{
				$this->vsettings = $this->settings['ui_album'];
				$this->display("/admin/ui_album.php");
			}

		}
	}

	public function ui_detail(){
		if($this->check_admin()){
			$action = $this->spArgs("act");
			if($action=='save'){
				$basic_setting = array();
				$basic_setting['detail_album'] = $this->spArgs("detail_album");
				$basic_setting['detail_same_from'] = $this->spArgs("detail_same_from");
				$basic_setting['detail_history'] = $this->spArgs("detail_history");
				$basic_setting['detail_may_like'] = $this->spArgs("detail_may_like");
				$basic_setting['detail_ad'] = $this->spArgs("detail_ad");
				$basic_setting['detail_plain'] = $this->spArgs("detail_plain");
				$this->ptx_settings->set_value('ui_detail',$basic_setting);
				$this->ptx_settings->updateSettings();
				admin_show_message(T('save_success'),$this,spUrl('admin','ui_detail'));
			}else{
				$this->vsettings = $this->settings['ui_detail'];
				$this->display("/admin/ui_detail.php");
			}

		}
	}

	private function update_css($style){
		$less_file = APP_PATH.'/themes/'.$style.'/less/bootstrap.less';
		if(file_exists($less_file)){
			import(APP_PATH.'/include/lessc.inc.php');
			$less = new lessc();
			$css_file = APP_PATH.'/themes/'.$style.'/css/pintuxiu.css';
			$less->compileFile($less_file,$css_file);
			$hacker_less_file = APP_PATH.'/themes/'.$style.'/oless/hackerie9.less';
			$hacker_css_file = APP_PATH.'/themes/'.$style.'/css/hackerie9.css';
			$less->compileFile($hacker_less_file,$hacker_css_file);
		}
	}
	
	public function ui_styles(){
		if($this->check_admin()){
			$action = $this->spArgs("act");
			if($action=='save'){
				$basic_setting = array();
				$basic_setting['style'] = $this->spArgs("style");
				$basic_setting['color'] = $this->spArgs("color");
				$this->ptx_settings->set_value('ui_styles',$basic_setting);
				$this->ptx_settings->updateSettings();
				$this->update_css($basic_setting['style']);
				admin_show_message(T('save_success'),$this,spUrl('admin','ui_styles'));
			}else{
				$themes_dir = APP_PATH.'/themes/';
				$file_list = get_dir_file_info($themes_dir);
				$dir = array();
				foreach ($file_list as $d) {
					if($d['name']!='admin'&&$d['name']!='install'){
						$dir[] = $d['name'];
					}
				}
				$this->dirs = $dir;
				$this->vsettings = $this->settings['ui_styles'];
				$this->display("/admin/ui_styles.php");
			}
		}
	}
	
	public function css(){
		import(APP_PATH.'/include/lessc.inc.php');
		$less = new lessc();
		$less_file = APP_PATH.'/themes/puzzing/less/bootstrap.less';
		$css_file = APP_PATH.'/data/template/puzzing.css';
		$less->compileFile($less_file,$css_file);
	}
	
	public function ui_render(){
		$this->ui_themes="puzzing";
		$this->display("/admin/render.php");
	}

	public function ads_manage(){
		if($this->check_admin()){
			$action = $this->spArgs("act");
			$this->positions = array('homepage_ad','pinpage_ad','detailpage_ad');
			if($action=='add'){
				$ad_position = $this->spArgs("ad_position");
				if(in_array($ad_position, $this->positions)){
					$ads = array();
					$ads['key']= time();
					$ads['ad_name'] = $this->spArgs("ad_name");
					$ads['width'] = $this->spArgs("width");
					$ads['height'] = $this->spArgs("height");
					$ads['ad_source'] = stripslashes($this->spArgs("ad_source",'','POST','false'));
					$ads_array = $this->settings[$ad_position];
					$ads_array = !$ads_array?array():$ads_array;
					array_push($ads_array, $ads);
					$this->ptx_settings->set_value($ad_position,$ads_array);
					$this->ptx_settings->updateSettings();
				}
				admin_show_message(T('save_success'),$this,spUrl('admin','ads_manage'));
			}else if($action=='edit'){
				$key = $this->spArgs("key");
				$ad_position = $this->spArgs("ad_position");
				if(in_array($ad_position, $this->positions)){
					$ads_array = $this->settings[$ad_position];
					foreach ($ads_array as $ads){
						if($ads['key'] == $key){
							$ads_edit = $ads;
							break;
						}
					}
					$ads_edit['ad_position']=$ad_position;
					$this->ads_edit = $ads_edit;
					$this->display('/admin/ads_manage_edit.php');
				}
			}else if($action=='edit_submit'){
				$key = $this->spArgs("key");
				$ad_position = $this->spArgs("ad_position");
				if(in_array($ad_position, $this->positions)){
					$ads_array = $this->settings[$ad_position];
					foreach ($ads_array as $i=>$ads){
						if($ads['key'] == $key){
							$index = $i;
							break;
						}
					}
					$ads_array[$index]['key']= time();
					$ads_array[$index]['ad_name'] = $this->spArgs("ad_name");
					$ads_array[$index]['width'] = $this->spArgs("width");
					$ads_array[$index]['height'] = $this->spArgs("height");
					$ads_array[$index]['ad_source'] = stripslashes($this->spArgs("ad_source",'','POST','false'));
					$this->ptx_settings->set_value($ad_position,$ads_array);
					$this->ptx_settings->updateSettings();
				}
				admin_show_message(T('save_success'),$this,spUrl('admin','ads_manage'));
				return;
			}else if($action=='delete'){
				$key = $this->spArgs("key");
				$ad_position = $this->spArgs("ad_position");
				if(in_array($ad_position, $this->positions)){
					$ads_array = $this->settings[$ad_position];
					foreach ($ads_array as $i=>$ads){
						if($ads['key'] == $key){
							$index = $i;
							break;
						}
					}
					array_splice($ads_array, $index,1);
					$this->ptx_settings->set_value($ad_position,$ads_array);
					$this->ptx_settings->updateSettings();
				}
				admin_show_message(T('save_success'),$this,spUrl('admin','ads_manage'));
			}else{
				$this->homepage_ads = $this->settings['homepage_ad'];
				$this->pinpage_ads = $this->settings['pinpage_ad'];
				$this->detailpage_ads = $this->settings['detailpage_ad'];
				$this->display("/admin/ads_manage.php");
			}

		}
	}

	public function sys_usergroup(){
		if($this->check_admin()){
			$act = $this->spArgs("act");
			$group_id = $this->spArgs("group_id");
			$this->group_type = $this->spArgs("group_type",'member');
			$ptx_usergroup = spClass('ptx_usergroup');
			if($group_id){
				$conditions['usergroup_id'] = $group_id;
				$this->usergroup = $ptx_usergroup->find($conditions);
				$this->group_type = $this->usergroup['usergroup_type'];
			}
			$this->usergroup_nav = $this->render("admin/usergroup_nav");
			if($act=='delete'&&$this->usergroup){
				$ptx_usergroup->delete($conditions);
				$ptx_usergroup->updateUsergroups();
				admin_show_message(T('del_succeed'),$this,spUrl('admin','sys_usergroup'));
				return;
			}else if($act=='edit'&&$this->usergroup){
				if($this->spArgs('group_type')){
					$data['credits_higher'] = $this->spArgs('credits_higher');
					$data['credits_lower'] = $this->spArgs('credits_lower');
					$data['stars'] = $this->spArgs('stars');
					$data['color'] = $this->spArgs('color');

					$data['allow_visit'] = $this->spArgs('allow_visit');
					$data['allow_share'] = $this->spArgs('allow_share');
					$data['need_verify'] = $this->spArgs('need_verify');


					$data['other_permission']['allow_sendpm'] = $this->spArgs('allow_sendpm');
					$data['other_permission']['allow_video'] = $this->spArgs('allow_video');
					$data['other_permission']['allow_comment'] = $this->spArgs('allow_comment');
					$data['other_permission']['allow_at_friend'] = $this->spArgs('allow_at_friend');
					$data['other_permission']['allow_smile'] = $this->spArgs('allow_smile');

					$data['other_permission']['allow_subdomain'] = $this->spArgs('allow_subdomain');
					$data['other_permission']['share_maxnum'] = $this->spArgs('share_maxnum');
					$data['other_permission']['fllow_maxnum'] = $this->spArgs('fllow_maxnum');
					$data['other_permission']['album_maxnum'] = $this->spArgs('album_maxnum');

					$data['other_permission']['upload_maxnum'] = $this->spArgs('upload_maxnum');
					$data['other_permission']['upload_maxsize'] = $this->spArgs('upload_maxsize');

					$data['other_permission']['allow_invite'] = $this->spArgs('allow_invite');
					$data['other_permission'] = serialize($data['other_permission']);
					$ptx_usergroup->update($conditions,$data);
					$ptx_usergroup->updateUsergroups();
					admin_show_message(T('edit_succeed'),$this,spUrl('admin', 'sys_usergroup',array('group_type'=>$this->group_type)));
					return;
				}else{
					$this->other_permission = unserialize($this->usergroup['other_permission']);
					$this->display("/admin/usergroup_edit.php");
					return;
				}
			}else if($act=='add'){
				$data['usergroup_title'] = $this->spArgs('usergroup_title');
				$data['credits_higher'] = $this->spArgs('credits_higher');
				$data['credits_lower'] = $this->spArgs('credits_lower');
				$data['stars'] = $this->spArgs('stars');
				$data['color'] = $this->spArgs('color');
				$data['usergroup_type']=$this->group_type;
				$ptx_usergroup->create($data);
				$ptx_usergroup->updateUsergroups();
				admin_show_message(T('save_success'),$this,spUrl('admin', 'sys_usergroup',array('group_type'=>$this->group_type)));
				return;
			}else{
				$conditions_search['usergroup_type'] = $this->group_type;
				$this->usergroups = $ptx_usergroup->search($conditions_search);
				$this->display("/admin/usergroup_list.php");
				return;
			}
		}
	}

	function checkformulasyntax($formula, $operators, $tokens) {
		$var = implode('|', $tokens);
		$operator = implode('', $operators);

		$operator = str_replace(
				array('+', '-', '*', '/', '(', ')', '{', '}', '\''),
				array('\+', '\-', '\*', '\/', '\(', '\)', '\{', '\}', '\\\''),
				$operator
		);
		$str = preg_replace("/($var)/", "\$\\1", $formula);
		if(!empty($formula)) {
			if(!preg_match("/^([$operator\.\d\(\)]|(($var)([$operator\(\)]|$)+))+$/", $formula) || !is_null(eval($str.';'))){
				return false;
			}
		}
		return $str;
	}

	function checkformulacredits($formula) {
		return $this->checkformulasyntax(
				$formula,
				array('+', '-', '*', '/', ' '),
				array('ext_credits_[1-3]', 'total_followers', 'total_shares', 'total_likes')
		);
	}

	public function credit_setting(){
		if($this->check_admin()){
			$this->credit_setting_nav = $this->render("admin/credit_setting_nav");
			$action = $this->spArgs("act");
			if($action=='save'){
				$basic_setting = array();
				$credit_formula = $this->spArgs("credit_formula");
				$basic_setting['credit_formula_exe'] = $this->checkformulacredits($credit_formula);
				$basic_setting['credit_formula'] = $credit_formula;
				$this->ptx_settings->set_value('credit_setting',$basic_setting);
				$this->ptx_settings->updateSettings();
				admin_show_message(T('save_success'),$this,spUrl('admin','credit_setting'));
			}else{
				$this->vsettings = $this->settings['credit_setting'];
				$this->display("/admin/credit_setting.php");
			}
		}
	}

	public function credit_strategy(){
		if($this->check_admin()){
			$this->event_arr = array('login_everyday','post_comment','post_share','post_video','forward_share','been_like','been_like_album','add_like','add_like_album','email_active','create_avatar');
			$this->credit_setting_nav = $this->render("admin/credit_setting_nav");
			$action = $this->spArgs("act");
			if($action=='save'){
				$basic_setting = array();
				foreach ($this->event_arr as $evt) {
					for ($i=1;$i<=3;$i++){
						$key_str = $evt.'_credits_'.$i;
						$basic_setting[$key_str] = $this->spArgs($key_str);
					};
				}

				$this->ptx_settings->set_value('credit_strategy',$basic_setting);
				$this->ptx_settings->updateSettings();
				admin_show_message(T('save_success'),$this,spUrl('admin','credit_strategy'));
			}else{
				$this->vsettings = $this->settings['credit_strategy'];
				$this->display("/admin/credit_strategy.php");
			}
		}
	}

	public function forum_setting(){
		if($this->check_admin()){
			$action = $this->spArgs("act");
			if($action=='save'){
				$basic_setting = array();
				$basic_setting['open_forumline'] = $this->spArgs("open_forumline");
				$basic_setting['bbs_domain'] = $this->spArgs("bbs_domain");
				$basic_setting['bbs_dbhost'] = $this->spArgs("bbs_dbhost");
				$basic_setting['bbs_dbname'] = $this->spArgs("bbs_dbname");
				$basic_setting['bbs_dbuser'] = $this->spArgs("bbs_dbuser");
				$basic_setting['bbs_dbpre'] = $this->spArgs("bbs_dbpre");
				$basic_setting['bbs_dbpassword'] = $this->spArgs("bbs_dbpassword");
				$this->ptx_settings->set_value('forum_setting',$basic_setting);
				$this->ptx_settings->updateSettings();
				$this->forumline($basic_setting);
				admin_show_message(T('save_success'),$this,spUrl('admin','forum_setting'));
			}else{
				$this->vsettings = $this->settings['forum_setting'];
				$this->display("/admin/forum_setting.php");
			}
		}
	}

	private function forumline($settings){
		$config = spClass('Options');
		if($config->load('config.php')){
			$forum_setting = array (
					'open' => $settings['open_forumline'],
					'driver' => 'mysql',
					'host' => $settings['bbs_dbhost'],
					'port' => '3306',
					'login' => $settings['bbs_dbuser'],
					'password' => $settings['bbs_dbpassword'],
					'database' => $settings['bbs_dbname'],
					'prefix' => $settings['bbs_dbpre'],
					'persistent' => false,
			);
			$config->set_item('bbs',$forum_setting);
			$config->save('config.php');
		}
	}

	public function ucenter_setting(){
		if($this->check_admin()){
			$action = $this->spArgs("act");
			if($action=='save'){
				$basic_setting = array();
				$basic_setting['ucenter_open'] = $this->spArgs("ucenter_open");
				$basic_setting['ucenter_domain'] = $this->spArgs("ucenter_domain");
				$basic_setting['ucenter_dbhost'] = $this->spArgs("ucenter_dbhost");
				$basic_setting['ucenter_dbname'] = $this->spArgs("ucenter_dbname");
				$basic_setting['ucenter_dbpre'] = $this->spArgs("ucenter_dbpre");
				$basic_setting['ucenter_dbuser'] = $this->spArgs("ucenter_dbuser");
				$basic_setting['ucenter_dbpassword'] = $this->spArgs("ucenter_dbpassword");
				$basic_setting['ucenter_appid'] = $this->spArgs("ucenter_appid");
				$basic_setting['ucenter_appkey'] = $this->spArgs("ucenter_appkey");
				$this->ptx_settings->set_value('ucenter_setting',$basic_setting);
				$this->ptx_settings->updateSettings();
				$this->ucenter_config($basic_setting);
				admin_show_message(T('save_success'),$this,spUrl('admin','ucenter_setting'));
			}else{
				$this->vsettings = $this->settings['ucenter_setting'];
				$this->display("/admin/ucenter_setting.php");
			}
		}
	}

	private function ucenter_config($settings){
		$config = spClass('Options');
		if($config->load('config.php')){
			$forum_setting = array (
					'UC_OPEN' => $settings['ucenter_open'],
					'UC_DEBUG' => true,
					'UC_CONNECT' => 'mysql',
					'UC_DBHOST' => $settings['ucenter_dbhost'],
					'UC_DBUSER' => $settings['ucenter_dbuser'],
					'UC_DBPW' => $settings['ucenter_dbpassword'],
					'UC_DBNAME' => $settings['ucenter_dbname'],
					'UC_DBCHARSET' => 'utf8',
					'UC_DBTABLEPRE' => $settings['ucenter_dbpre'],
					'UC_DBCONNECT' => 0,
					'UC_CHARSET' => 'utf-8',
					'UC_KEY' => $settings['ucenter_appkey'],
					'UC_API' => $settings['ucenter_domain'],
					'UC_APPID' => $settings['ucenter_appid'],
					'UC_IP' => '127.0.0.1',
					'UC_PPP' => 20,
			);
			$config->set_item('ucenter',$forum_setting);
			$config->save('config.php');
		}
	}

	public function item_list()
	{
		if($this->check_admin()){
			$action = $this->spArgs("act");
			$item_id = $this->spArgs("item_id");
			$this->message = $this->spArgs("message");
			$ptx_item = spClass('ptx_item');
			$ptx_share = spClass('ptx_share');
			if($item_id){
				$conditions['item_id'] = $item_id;
				$this->item = $ptx_item->find($conditions);
				$this->share = $ptx_share->find($conditions);
			}

			if($action=='delete'&&$this->item){
				$ptx_item->update($conditions,array('is_deleted'=>1));
				$this->jump(spUrl('admin', 'item_list'));
				return;
			}else if($action=='push'&&$this->item){
				$ptx_item->update($conditions,array('is_show'=>2));
				$this->jump(spUrl('admin', 'item_list'));
				return;
			}else if($action=='depush'&&$this->item){
				$ptx_item->update($conditions,array('is_show'=>1));
				$this->jump(spUrl('admin', 'item_list'));
				return;
			}else if($action=='verify'&&$this->item){
				$ptx_item->update($conditions,array('is_show'=>1));
				$albums = $ptx_share->find_albums_by_item($item_id);
				$ptx_album = spClass('ptx_album');
				foreach ($albums as $album) {
					$ptx_album->update_album_cover($album['album_id']);
				}
				$this->jump(spUrl('admin', 'item_list'));
				return;
			}else if($action=='deverify'&&$this->item){
				$ptx_item->update($conditions,array('is_show'=>0));
				$this->jump(spUrl('admin', 'item_list'));
				return;
			}else if($action=='edit'&&$this->item){
				$this->display("/admin/item_edit.php");
				return;
			}else if($action=='edit_save'&&$this->item){
				$segment = spClass('Segment');
				$update_data['intro'] = $this->spArgs('intro');
				$segment_str = $segment->segment($update_data['intro']);
				$update_data['intro_search'] = $segment_str['py'];
				$update_data['keywords'] = $segment_str['cn'];

				$update_data['price'] = $this->spArgs("price");
				$update_data['title'] = $this->spArgs("title");
				$update_data['promotion_url'] = $this->spArgs("promotion_url");
				$share_update_data['category_id'] = $this->spArgs("category_id");
				$ptx_share->update($conditions,$share_update_data);
				if($ptx_item->update($conditions,$update_data)){
					$this->jump(spUrl('admin', 'item_list'));
				}else{
					$this->jump(spUrl('admin','item_list', array('act'=>'edit','item_id'=>$item['item_id'],'message'=>'修改失败')));
					return;
				}
				return;
			}else if($action=='search'){
				$conditions['orgin_post']=1;
				$page = $this->spArgs("page",1);
				if(NULL!=$this->spArgs("is_show")){
					$conditions['is_show'] = $this->spArgs("is_show");
				}
				if($category_id = $this->spArgs("category_id")){
					$conditions['category_id'] = $category_id;
				}
				if($keyword = $this->spArgs("keyword")){
					$segment = spClass('Segment');
					$conditions['keyword'] = $segment->convert_to_py($keyword);
				}
				$this->items = $ptx_share->search($conditions,$page,15);
				$conditions['act'] = 'search';
				$this->pages = createPages($ptx_share->spPager()->getPager(), 'admin', 'item_list',$conditions);
				$this->display("/admin/item_list.php");
			}else{

				$conditions['orgin_post']=1;
				//$conditions['is_deleted'] = 0;
				$page = $this->spArgs("page",1);

				$this->items = $ptx_share->search($conditions,$page,15);
				//var_dump($this->shares);
				//$this->items = $ptx_item->spPager($page, 15)->findAll($conditions,' item_id DESC ');
				$this->pages = createPages($ptx_share->spPager()->getPager(), 'admin', 'item_list');
				$this->display("/admin/item_list.php");
			}
		}
	}

	public function gathering(){
		if($this->check_admin()){
			$act = $this->spArgs("act");
			$this->page = $this->spArgs("page",1);
			$channel_name = $this->spArgs("channel",'taobao');
			$channel = spClass("Channel");
			if($act=='search'){
				$this->keyword = $this->spArgs("keyword");
				$this->channel_category_id = $this->spArgs("channel_category_id",0);
				$param['channel_category_id'] = $this->channel_category_id;
				$param['keyword'] = $this->keyword;
				$param['page'] = $this->page;
				$param['num_per_page'] = 20;
				$this->items = $channel->search_gathering($channel_name,$param);
				$args = array();
				$args['channel_category_id'] = $this->channel_category_id;
				if($this->keyword) $args['keyword'] = $this->keyword;
				$args['page'] = $this->page;
				$args['act'] = 'search';
				$this->pages = multi('admin', 'gathering', $args, $this->items['total_results'], 20, $this->page);
			}elseif($act=='publish'){
				$num_iid_str = $this->spArgs("num_iid_str");
				$album_id = $this->spArgs("album_id");
				$category_id = $this->spArgs("category_id");
				$num_iid_arr = explode(',', $num_iid_str);
				foreach ($num_iid_arr as $num_iid){
					$pinfo = $channel->fetch_goodinfo($channel_name,$num_iid);
					if($pinfo){
						$this->save_share_fetch($pinfo);
						sleep(5);
					}
				}

				$ptx_album = spClass('ptx_album');
				$ptx_album->update_album_cover($album_id);
				$this->ajax_success_response('', '');
			}elseif($act=='fetch_category'){
				$channel_categories = $channel->fetch_categories($channel_name,0);
				$this->ajax_success_response($channel_categories, '');
			}
			//$this->channel_categories = $channel->fetch_categories($channel_name,0);
			$this->display("/admin/gathering.php");
		}
	}


	private function save_share_fetch($item){

		$date_dir = '/data/attachments/'.date("Y/m/d/");
		(!is_dir(APP_PATH.$date_dir))&&@mkdir(APP_PATH.$date_dir,0777,true);
		$file_name = $this->current_user['user_id'].'_'.time().'';

		$this->save_fetch_file($item['orgin_image_url'], $date_dir, $file_name, true);
		$img_array = array();
		foreach ($item['item_imgs'] as $key=>$up_image){
			if($up_image&&trim($up_image['url'])!=''){
				if($up_image['url']==$item['orgin_image_url']){
					$img_array[] = array('id'=>$key,'url'=>$date_dir.$file_name,'desc'=>'','cover'=>true);
					continue;
				}
				$this->save_fetch_file($up_image['url'], $date_dir, $file_name.'_'.$key, false);
				$img_array[] = array('id'=>$key,'url'=>$date_dir.$file_name.'_'.$key,'desc'=>'','cover'=>false);
			}
		}
		$this->create_share_item($item,$date_dir.$file_name,array_length($img_array),$img_array);
		return true;
	}

	private function save_fetch_file($url,$date_dir,$file_name,$is_cover=false){
		$content = get_contents($url);
		$file_path = APP_PATH.$date_dir.$file_name.'.jpg';
		if(!empty($content) && @file_put_contents($file_path,$content) > 0)
		{
			$imagelib = spClass('ImageLib');
			$imagelib->create_thumb($file_path, 'large', 600);
			$imagelib->crop_square($file_path, 200,'square_like');
			if($is_cover){
				$pin_width = $this->settings['ui_pin']['pin_imagewidth']?$this->settings['ui_pin']['pin_imagewidth']:200;
				$imagelib->create_thumb($file_path, 'middle', $pin_width);
				$imagelib->create_thumb($file_path, 'small', 150);
				$imagelib->crop_square($file_path, 62);
			}
			file_exists($file_path) && unlink($file_path);
			return true;
		}
	}

	private function create_share_item($item,$image_path,$image_num,$img_array){
		$local_user = $this->current_user;
		$segment = spClass('Segment');
		$img_pro = @getimagesize(APP_PATH.$image_path.'_middle.jpg');
		$img['width']=$img_pro['0'];
		$img['height']=$img_pro['1'];
		$data['img_pro'] = array_to_str($img, ',');
		$data['title'] = $item['name'];
		$data['category_id'] = $this->spArgs('category_id');
		$data['image_path'] = $image_path;
		$data['user_id'] = $local_user['user_id'];
		$data['intro'] = $item['name'];
		$segment_str = $segment->segment($data['intro']);
		$at_array = $this->parse_at($data['intro']);
		$tag_parse = $this->parse_tag($data['intro']);
		$data['intro'] = $at_array['message'];

		$data['intro_search'] .= ' '.$segment->convert_to_py($tag_parse);;
		$data['intro_search'] .= ' '.$at_array['atsearch_str'];
		$data['intro_search'] .= $segment_str['py'];
		$data['keywords'] .= ' '.$tag_parse;
		$data['keywords'] .= ' '.$segment_str['cn'];

		$data['share_type'] = 'channel';
		$data['price'] = is_numeric($item['price'])?$item['price']:0;
		$data['is_show'] = 1;
		$data['reference_url'] = $item['orgin_url'];
		$data['reference_itemid'] = $item['item_id'];
		$data['reference_channel'] = 'taobao';
		$data['promotion_url'] = $item['promotion_url'];
		$data['total_images'] = $image_num;
		$data['images_array'] = serialize($img_array);

		$create_time = time();
		$data['create_time'] = $create_time;
		$share_data['create_time'] = $create_time;

		$share_data['poster_id'] = $local_user['user_id'];
		$share_data['poster_nickname'] = $local_user['nickname'];
		$share_data['original_id'] = 0;
		$share_data['user_id'] = $local_user['user_id'];
		$share_data['user_nickname'] = $local_user['nickname'];
		$share_data['total_comments'] = 0;
		$share_data['total_likes'] = 0;
		$share_data['total_clicks'] = 0;
		$share_data['total_forwarding'] = 0;
		$share_data['album_id'] = $this->spArgs('album_id');
		$share_data['category_id'] = $this->spArgs('category_id');

		$data['share'] = $share_data;
		$ptx_item = spClass('ptx_item');
		$ptx_item->linker['share']['enabled'] = true;
		$ptx_item->spLinker()->create($data);
	}

	public function smile_list()
	{
		if($this->check_admin()){
			$act = $this->spArgs("act");
			$smile_id = $this->spArgs("smile_id");
			$ptx_smile = spClass('ptx_smile');
			if($smile_id){
				$conditions['smile_id'] = $smile_id;
				$this->smile = $ptx_smile->find($conditions);
			}
			if($act=='delete'&&$this->smile){
				$ptx_smile->delete($conditions);
				$ptx_smile->updateSmiliesCache();
				$this->jump(spUrl('admin', 'smile_list'));
				return;
			}else if($act=='edit'&&$this->smile){
				if($data['code'] = $this->spArgs('code')){
					$data['displayorder'] = $this->spArgs('displayorder');
					$data['url'] = $this->spArgs('url');
					$ptx_smile->update($conditions,$data);
					$ptx_smile->updateSmiliesCache();
					$this->jump(spUrl('admin', 'smile_list'));
					return;
				}else{
					$this->display("/admin/smile_edit.php");
					return;
				}
			}else if($act=='add'){
				$data['code'] = $this->spArgs('code');
				$data['displayorder'] = $this->spArgs('displayorder');
				$data['url'] = $this->spArgs('url');
				$data['typeid'] = 1;
				$ptx_smile->create($data);
				$ptx_smile->updateSmiliesCache();
				$this->jump(spUrl('admin', 'smile_list'));
				return;
			}else{
				$this->smiles = $ptx_smile->findAll();
				$this->display("/admin/smile_list.php");
				return;
			}
		}
	}

	public function category_list()
	{
		if($this->check_admin()){
			$act = $this->spArgs("act");
			$category_id = $this->spArgs("catid");
			$category_model = spClass('ptx_category');
			if($category_id){
				$conditions['category_id'] = $category_id;
				$this->category = $category_model->find($conditions);
			}
			if($act=='delete'&&$this->category){
				$category_model->delete_category($conditions);
				$category_model->update_category_top();
				$this->jump(spUrl('admin', 'category_list'));
				return;
			}else if($act=='edit'&&$this->category){
				if($data['category_name_cn'] = $this->spArgs('category_name_cn')){
					$data['category_name_en'] = $this->spArgs('category_name_en');
					$data['category_hot_words'] = $this->spArgs('category_hot_words');
					$data['display_order'] = $this->spArgs('display_order');
					$data['is_open'] = $this->spArgs('is_open');
					$data['is_home'] = $this->spArgs('is_home');
					$category_model->update($conditions,$data);
					$category_model->update_category_top();
					$this->jump(spUrl('admin', 'category_list'));
					return;
				}else{
					$this->display("/admin/category_edit.php");
					return;
				}
			}else if($act=='add'){
				$data['category_name_cn'] = $this->spArgs('category_name_cn');
				$data['category_name_en'] = $this->spArgs('category_name_en');
				$data['category_hot_words'] = $this->spArgs('category_hot_words');
				$data['display_order'] = $this->spArgs('display_order');
				$category_model->create($data);
				$category_model->update_category_top();
				$this->jump(spUrl('admin', 'category_list'));
				return;
			}else{
				$this->categories = $category_model->get_category();
				$this->display("/admin/category_list.php");
				return;
			}
		}
	}

	public function user_list()
	{
		if($this->check_admin()){
			$act = $this->spArgs("act");
			$user_id = $this->spArgs("uid");
			$ptx_user = spClass('ptx_user');
			$ptx_usergroup = spClass('ptx_usergroup');
			$this->usergroups = $ptx_usergroup->getUsergroups();
			if($user_id){
				$conditions['user_id'] = $user_id;
				$this->user = $ptx_user->getuser_byid($user_id);
			}
			if($act=='delete'&&$this->user){
				$this->jump(spUrl('admin', 'user_list'));
				return;
			}else if($act=='search'){
				$page = $this->spArgs("page",1);
				if(NULL!=$this->spArgs("user_type")){
					$conditions['user_type'] = $this->spArgs("user_type");
				}
				if($search_txt = $this->spArgs("keyword")){
					$conditions['keyword'] = $search_txt;
				}
				$this->users = $ptx_user->search($conditions,$page,15,null,' ptx_user.user_id ASC ');
				$conditions['act'] = 'search';
				$this->pages = createTPages($ptx_user->spPager()->getPager(), 'admin', 'user_list',$conditions);
				$this->display("/admin/user_list.php");
			}else if($act=='edit'&&$this->user){
				if($this->spArgs("hash")){
					if($this->spArgs("password")){
						$data['passwd'] = md5($this->spArgs("password"));
					}
					$data['usergroup_id'] = $this->spArgs("usergroup_id");
					$data['user_type'] = $this->spArgs("user_type");
					$data['user_title'] = $this->spArgs("user_title");
					$data['bio'] = $this->spArgs("bio");
					$ptx_user->update($conditions,$data);
					admin_show_message(T('save_success'),$this,spUrl('admin','user_list'));
					return;
				}else{
					$this->display("/admin/user_edit.php");
					return;
				}
			}else{
				$page = $this->spArgs("page",1);
				$this->users = $ptx_user->search($conditions,$page,15,null,' ptx_user.user_id ASC ');
				$this->pages = createTPages($ptx_user->spPager()->getPager(), 'admin', 'user_list',$conditions);
				$this->display("/admin/user_list.php");
			}
		}
	}

	public function staruser_list()
	{
		if($this->check_admin()){
			$act = $this->spArgs("act");
			$starid = $this->spArgs("starid");
			$ptx_staruser = spClass('ptx_staruser');
			$ptx_user = spClass('ptx_user');
			$this->medals = spClass("ptx_medal")->getStaruserMedals();
			if($starid){
				$find_data['star_id'] = $starid;
				$this->star = $ptx_staruser->find_one($find_data);
			}
			if($act=='delete'&&$this->star){
				$ptx_staruser->del_one($find_data);
				$ptx_staruser->update_staruser_cache();
				$ptx_user->update_staruser($this->star['user_id'],0);
				$ptx_staruser->update_staruser_cache();
				admin_show_message(T('save_success'),$this,spUrl('admin','staruser_list'));
				return;
			}else if($act=='search'){
				$page = $this->spArgs("page",1);
				if($search_txt = $this->spArgs("keyword")){
					$conditions['keyword'] = $search_txt;
				}
				$this->starusers = $ptx_staruser->search($conditions,$page,15);
				$conditions['act'] = 'search';
				$this->pages = createTPages($ptx_staruser->spPager()->getPager(), 'admin', 'staruser_list',$conditions);
				$this->display("/admin/staruser_list.php");
			}else if($act=='edit'&&$this->star){
				if($this->spArgs('hash')){
					$data['star_reason'] = $this->spArgs("star_reason");
					$data['medal_id'] = $this->spArgs("medal_id");
					$ptx_staruser->update($find_data,$data);
					$ptx_staruser->update_staruser_cache();
					admin_show_message(T('save_success'),$this,spUrl('admin','staruser_list'));
					return;
				}else{
					$this->display("/admin/staruser_edit.php");
					return;
				}
			}else{
				$page = $this->spArgs("page",1);
				$this->starusers = $ptx_staruser->search($conditions,$page,15);
				$this->pages = createTPages($ptx_staruser->spPager()->getPager(), 'admin', 'staruser_list',$conditions);
				$this->display("/admin/staruser_list.php");
			}
		}
	}

	public function goodshop_list()
	{
		if($this->check_admin()){
			$act = $this->spArgs("act");
			$shopid = $this->spArgs("shopid");
			$ptx_goodshop = spClass('ptx_goodshop');
			$ptx_user = spClass('ptx_user');
			if($shopid){
				$find_data['shop_id'] = $shopid;
				$this->shop = $ptx_goodshop->find_one($find_data);
			}
			if($act=='delete'&&$this->shop){
				$ptx_goodshop->del_one($find_data);
				$ptx_goodshop->update_goodshop_cache();
				$ptx_user->update_shopuser($this->shop['user_id'],0);
				admin_show_message(T('save_success'),$this,spUrl('admin','goodshop_list'));
				return;
			}else if($act=='search'){
				$page = $this->spArgs("page",1);
				if($search_txt = $this->spArgs("keyword")){
					$conditions['keyword'] = $search_txt;
				}
				$this->goodshops = $ptx_goodshop->search($conditions,$page,15);
				$conditions['act'] = 'search';
				$this->pages = createTPages($ptx_goodshop->spPager()->getPager(), 'admin', 'goodshop_list',$conditions);
				$this->display("/admin/goodshop_list.php");
			}else if($act=='edit'&&$this->shop){
				if($this->spArgs('hash')){
					$data['shop_desc'] = $this->spArgs("shop_desc");
					$data['category_id'] = $this->spArgs("category_id");
					$data['display_order'] = $this->spArgs("display_order");
					$ptx_goodshop->update($find_data,$data);
					admin_show_message(T('save_success'),$this,spUrl('admin','goodshop_list'));
					return;
				}else{
					$this->display("/admin/goodshop_edit.php");
					return;
				}
			}else{
				$page = $this->spArgs("page",1);
				$this->goodshops = $ptx_goodshop->search($conditions,$page,15);
				$this->pages = createTPages($ptx_goodshop->spPager()->getPager(), 'admin', 'goodshop_list',$conditions);
				$this->display("/admin/goodshop_list.php");
			}
		}
	}

	public function apply_list()
	{
		if($this->check_admin()){
			$act = $this->spArgs("act");
			$applyid = $this->spArgs("applyid");
			$ptx_apply = spClass("ptx_apply");
			if($applyid){
				$conditions['apply_id'] = $applyid;
				$apply = $ptx_apply->find_one($conditions);
			}
			if($act=='disagree'&&$apply){
				$ptx_apply->disagree($applyid);
				$ptx_message = spClass("ptx_message");
				$ptx_message->dis_apply($this->current_user['user_id'],$apply['user_id'],$apply['apply_type']);
				$this->jump(spUrl('admin', 'apply_list'));
				return;
			}else if($act=='agreen'&&$apply){
				$ptx_apply->agree($applyid);
				$ptx_message = spClass("ptx_message");
				$ptx_message->add_apply($this->current_user['user_id'],$apply['user_id'],$apply['apply_type']);
				$this->jump(spUrl('admin', 'apply_list'));
				return;
			}else{
				$page = $this->spArgs("page",1);
				$this->applys = $ptx_apply->search(null,$page,20);
				$this->display("/admin/apply_list.php");
			}
		}
	}

	public function update_cache()
	{
		if($this->check_admin()){
			$act = $this->spArgs("act");
			if($act=='update'){
				$cat_cache = $this->spArgs("cat_cache");
				$count_cache = $this->spArgs("count_cache");
				$staruser_cache = $this->spArgs("staruser_cache");
				$goodshop_cache = $this->spArgs("goodshop_cache");
				$smile_cache = $this->spArgs("smile_cache");
				$tpl_cache = $this->spArgs("tpl_cache");
				$sys_cache = $this->spArgs("sys_cache");

				if($cat_cache){
					$ptx_category = spClass('ptx_category');
					$ptx_category->update_category_top();
				}
				if($count_cache){
					$this->update_count();
				}
				if($staruser_cache){
					$ptx_staruser = spClass('ptx_staruser');
					$ptx_staruser->update_staruser_cache();
				}
				if($goodshop_cache){
					$ptx_goodshop = spClass('ptx_goodshop');
					$ptx_goodshop->update_goodshop_cache();
				}
				if($sys_cache){
					$ptx_settings = spClass('ptx_settings');
					$ptx_settings->updateSettings();
				}
				if($smile_cache){
					$ptx_smile = spClass('ptx_smile');
					$ptx_smile->updateSmiliesCache();
				}
				if($tpl_cache){
					delete_files(APP_PATH.'/data/template/');
					$this->update_css($this->settings['ui_styles']['style']);
				}
				admin_show_message(T('save_success'),$this,spUrl('admin','update_cache'));
				return;
			}else{
				$this->display("/admin/update_cache.php");
			}
		}
	}



	public function tag_list()
	{
		if($this->check_admin()){
			$act = $this->spArgs("act");
			$tag_id = $this->spArgs("tagid");
			$tag_model = spClass('ptx_tag');
			$category_model = spClass('ptx_category');
			if($tag_id){
				$conditions['tag_id'] = $tag_id;
				$this->tag = $tag_model->find($conditions);
			}
			$this->categories = $category_model->findAll();

			if($act=='delete'&&$this->tag){
				$tag_model->delete($conditions);
				$this->jump(spUrl('admin', 'tag_list'));
				return;
			}else if($act=='edit'&&$this->tag){
				if($data['tag_group_name_cn'] = $this->spArgs('tag_group_name_cn')){
					$data['category_id'] = $this->spArgs('category_id');
					$data['tag_group_name_en'] = $this->spArgs('tag_group_name_en');
					$data['display_order'] = $this->spArgs('display_order');
					$data['tags'] = $this->spArgs('tags');
					$tag_model->update($conditions,$data);
					$this->jump(spUrl('admin', 'tag_list'));
					return;
				}else{
					$this->display("/admin/tag_edit.php");
					return;
				}

			}else if($act=='add'){
				$data['tag_group_name_cn'] = $this->spArgs('tag_group_name_cn');
				$data['category_id'] = $this->spArgs('category_id');
				$data['tag_group_name_en'] = $this->spArgs('tag_group_name_en');
				$data['display_order'] = $this->spArgs('display_order');
				$data['tags'] = $this->spArgs('tags');
				$tag_model->create($data);
				$this->jump(spUrl('admin', 'tag_list'));
				return;
			}else{
				$this->tags = $tag_model->spLinker()->findAll();
				$this->display("/admin/tag_list.php");
				return;
			}
		}
	}


	public function database_management()
	{
		if($this->check_admin()){
			$db = spClass('dbbackup', array(0=>$GLOBALS['G_SP']['db']));

			$this->table =  $db->showAllTable($this->spArgs('chk',0));
			$this->display("/admin/db_manage.php");
		}
	}

	public function database_backup(){
		if($this->check_admin()){
			$db = spClass('dbbackup', array(0=>$GLOBALS['G_SP']['db']));
			$act = $this->spArgs("act");
			$table = $this->spArgs("table");
			if($act=='outall'&&$db){
				$db->outAllData();
			}elseif($act=='optimize'&&$db&&$table){
				$db->optimizeTable($table);
				$this->jump(spUrl('admin', 'database_management'));
			}elseif($act=='repair'&&$db&&$table){
				$db->repairTable($table);
				$this->jump(spUrl('admin', 'database_management'));
			}elseif($act=='outone'&&$db&&$table){
				$db->outTable($table);
			}
		}
	}

	public function database_download(){
		if($this->check_admin()){
			import(APP_PATH.'/include/function_download.php');
			$file_name = $this->spArgs('fname');
			$dbbackup_dir = APP_PATH.'/data/database';
			$data = file_get_contents($dbbackup_dir."/".$file_name); // 读文件内容
			force_download($file_name, $data);
		}
	}

	public function system_update(){
		if($this->check_admin()){
			$this->version = $GLOBALS['G_SP']['product_info']["version"];
			if(!$this->version)
				$this->version='1.1';

			$this->display("/admin/system_update.php");
		}
	}

	public function frindlink_list()
	{
		if($this->check_admin()){
			$act = $this->spArgs("act");
			$friendlinks = $this->settings['frindlink'];
			if($act=='add'){
				if($link_url = $this->spArgs("link_url")){
					$link = array(
							'key'=>time(),
							'link_url'=>$link_url,
							'link_name'=>$this->spArgs("link_name")
					);
					if(!is_array($friendlinks)){
						$friendlinks = array();
					}
					array_push($friendlinks, $link);
					$this->ptx_settings->set_value('frindlink',$friendlinks);
					$this->ptx_settings->updateSettings();
				}
			}elseif($act=='delete'){
				$key = $this->spArgs("key");
				foreach ($friendlinks as $i=>$frindlink){
					if($frindlink['key'] == $key){
						$index = $i;
						break;
					}
				}
				array_splice($friendlinks, $index,1);
				$this->ptx_settings->set_value('frindlink',$friendlinks);
				$this->ptx_settings->updateSettings();
			}
			$this->links = $friendlinks?$friendlinks:array();
			$this->display("/admin/frindlink_list.php");
		}
	}

	function homepage_slide(){
		if($this->check_admin()){
			$act = $this->spArgs("act");
			$homeslide = $this->settings['homeslide'];
			if($act=='add'){
				if($image_url = $this->spArgs("filename")){
					$slide_image = array(
							'key'=>time(),
							'image_url'=>'data/attachments/homeslide/'.$image_url,
							'link_url'=>$this->spArgs("link_url"),
							'order'=>$this->spArgs("order"),
							'title'=>$this->spArgs("title"),
							'desc'=>$this->spArgs("desc")
					);

					if(!is_array($homeslide)){
						$homeslide = array();
					}
					array_push($homeslide, $slide_image);
					$homeslide = sysSortArray($homeslide, 'order', 'SORT_ASC','SORT_NUMERIC');
					$this->ptx_settings->set_value('homeslide',$homeslide);
					$this->ptx_settings->updateSettings();
				}
			}elseif($act=='edit'){
				$key = $this->spArgs("key");
				foreach ($homeslide as $slide){
					if($slide['key'] == $key){
						$slide_edit = $slide;
						break;
					}
				}
				$this->slide = $slide_edit;
				$this->display("/admin/homepage_slide_edit.php");
				return;
			}elseif($act=='edit_submit'){
				$key = $this->spArgs("key");
				foreach ($homeslide as $i=>$slide){
					if($slide['key'] == $key){
						$index = $i;
						break;
					}
				}
				$homeslide[$index]['link_url'] = $this->spArgs("link_url");
				$homeslide[$index]['order'] = $this->spArgs("order");
				$homeslide[$index]['desc'] = $this->spArgs("desc");
				$homeslide[$index]['title'] = $this->spArgs("title");
				$homeslide = sysSortArray($homeslide, 'order', 'SORT_ASC','SORT_NUMERIC');
				$this->ptx_settings->set_value('homeslide',$homeslide);
				$this->ptx_settings->updateSettings();
				$this->jump(spUrl('admin','homepage_slide'));
				return;
			}elseif($act=='upload'){
				import(APP_PATH.'/include/ajaxuploader.php');
				$settings =  $this->settings;
				if($settings['file_setting']){
					$allowedExtensions = explode('|',$settings['file_setting']['upload_file_type']);
					$sizeLimit = $settings['file_setting']['upload_file_size']*1024;
				}else{
					$allowedExtensions = array('jpg','jpeg','gif','png');
					$sizeLimit = 2 * 1024 * 1024;
				}
				$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);

				$temp_dir = '/data/attachments/homeslide/';
				(!is_dir(APP_PATH.$temp_dir))&&@mkdir(APP_PATH.$temp_dir,0777,true);
				$result = $uploader->handleUpload(APP_PATH.$temp_dir);
				$this->ajax_response($result);
				return;
			}elseif($act=='delete'){
				$key = $this->spArgs("key");
				foreach ($homeslide as $i=>$slide){
					if($slide['key'] == $key){
						$index = $i;
						$image_url = $slide['image_url'];
						break;
					}
				}
				array_splice($homeslide, $index,1);
				if($image_url){
					file_exists(APP_PATH.'/'.$image_url) && unlink(APP_PATH.'/'.$image_url);
				}
				$this->ptx_settings->set_value('homeslide',$homeslide);
				$this->ptx_settings->updateSettings();
			}
			$this->slides = $homeslide?$homeslide:array();
			$this->display("/admin/homepage_slide.php");
		}
	}

	function medal(){
		$this->medal_type = array(0=>'normal_medal',1=>'system_medal',2=>'staruser_medal',3=>'goodshop_medal');
		if($this->check_admin()){
			$act = $this->spArgs("act");
			$medalid = $this->spArgs("medalid");
			$ptx_medal = spClass('ptx_medal');
			if($medalid){
				$conditions['medal_id'] = $medalid;
				$this->medal = $ptx_medal->find($conditions);
			}
			if($act=='edit'&&$this->medal){
				if($data['name'] = $this->spArgs('name')){
					$data['available'] = $this->spArgs('available');
					$data['type'] = $this->spArgs('type');
					$data['image'] = $this->spArgs('image');
					$data['description'] = $this->spArgs('description');
					$data['credit'] = $this->spArgs('credit');
					$data['price'] = $this->spArgs('price');
					$ptx_medal->update($conditions,$data);
					$this->jump(spUrl('admin', 'medal'));
					return;
				}else{
					$this->display("/admin/medal_edit.php");
					return;
				}
			}else if($act=='add'){
				$data['name'] = $this->spArgs('name');
				$data['available'] = $this->spArgs('available');
				$data['type'] = $this->spArgs('type');
				$data['image'] = $this->spArgs('image');
				$data['description'] = $this->spArgs('description');
				$data['credit'] = $this->spArgs('credit');
				$data['price'] = $this->spArgs('price');
				if($ptx_medal->add_one($data)){
					if($data['type']==2){
						spClass("ptx_staruser")->update_staruser_cache();
					}
					
				}
				
				$this->jump(spUrl('admin', 'medal'));
				return;
			}else{
				$this->medals = $ptx_medal->search_no_page();
				$this->display("/admin/medal_list.php");
				return;
			}
		}
	}

	public function site_tools(){
			
	}
	
	public function recreate_image(){
		if($this->check_admin()){
			$act = $this->spArgs("recreate");
			if($data['pin_width'] = $this->spArgs('pin_width')){
				$data['pin_width'] = $this->spArgs('pin_width');
				$data['square_width'] = $this->spArgs('square_width');
				$this->ptx_settings->set_value('image_size',$data);
				$this->ptx_settings->updateSettings();
			}
			if($act=='save'){
				admin_show_message(T('save_success'),$this,spUrl('admin','recreate_image'));
				return;
			}else if($act=='recreate_pin'){
				$url = spUrl('admin', 'recreate_pin',array('page'=>1));
				admin_show_message(T('save_success').' '.T('save_recreat_pin'), $this, $url,2000);
				return;
			}else if($act=='recreate_thumb'){
				$url = spUrl('admin', 'recreate_thumb',array('page'=>1));
				admin_show_message(T('save_success').' '.T('save_recreat_pin'), $this, $url,2000);
				return;
			}else{
				$this->vsettings = $this->settings['image_size'];
				$this->display("/admin/recreate_image.php");
				return;
			}
		}
	}

	function recreate_thumb(){
		$album_type = $this->settings['ui_album']['album_covertype']?$this->settings['ui_album']['album_covertype']:9;
		$width = $this->settings['image_size']['square_width']?$this->settings['image_size']['square_width']:100;
		$number = 50;
		$page = $this->spArgs("page",1);
		$ptx_album = spClass('ptx_album');
		$items = $ptx_album->search(null,$page,$number," ptx_album.album_cover ",NULL);
		foreach ($items as $item) {
			$covers = str_to_arr_list($item['album_cover']);
			foreach ($covers as $share) {
				$large_path = APP_PATH.$share['image_path'].'_large.jpg';
				if(!file_exists($large_path)){
					continue;
				}
				$cover_path = APP_PATH.$share['image_path'].'_square_like.jpg';
				file_exists($cover_path)&&unlink($cover_path);
				$imagelib = spClass('ImageLib');
				$imagelib->crop_square($large_path, $width,'square_like',$cover_path);
			}
		}
	
		if(array_length($items)>0){
			$start=($page-1)*$number;
			$end=$start+$number;
			$str = T('processing_data')."{$start}----{$end}";
			$url = spUrl('admin', 'recreate_album',array('page'=>$page+1));
			admin_show_message($str, $this, $url,1500);
			return;
		}else{
			$str = T('processing_data_success');
			$url = spUrl('admin', 'recreate_image');
			admin_show_message($str, $this, $url,1500);
		}
	}
	
	function recreate_pin(){
		$pin_width = $this->settings['image_size']['pin_width']?$this->settings['image_size']['pin_width']:200;
		if(!$pin_width){
			$pin_width = $this->settings['ui_pin']['pin_imagewidth']?$this->settings['ui_pin']['pin_imagewidth']:200;
		}
		$number = 100;
		$page = $this->spArgs("page",1);
		$ptx_item = spClass('ptx_item');
		$items = $ptx_item->search(null,$page,$number," ptx_item.image_path,ptx_item.item_id ",NULL);
		foreach ($items as $item) {
			$large_path = APP_PATH.$item['image_path'].'_large.jpg';
			if(!file_exists($large_path)){
				continue;
			}
			$cover_path = APP_PATH.$item['image_path'].'_middle.jpg';
			file_exists($cover_path)&&unlink($cover_path);
			$imagelib = spClass('ImageLib');
			$imagelib->create_thumb($large_path,'',$pin_width,0,$cover_path);
			$img_pro = @getimagesize($cover_path);
			$img['width']=$img_pro['0'];
			$img['height']=$img_pro['1'];
			$data['img_pro'] = array_to_str($img, ',');
			$ptx_item->update(array('item_id'=>$item['item_id']),$data);
			
			$width = $this->settings['image_size']['square_width']?$this->settings['image_size']['square_width']:100;
			$cover_path = APP_PATH.$item['image_path'].'_square_like.jpg';
			file_exists($cover_path)&&unlink($cover_path);
			$imagelib->crop_square($large_path, $width,'square_like',$cover_path);
		}

		if(array_length($items)>0){
			$start=($page-1)*$number;
			$end=$start+$number;
			$str = T('processing_data')."{$start}----{$end}";
			$url = spUrl('admin', 'recreate_pin',array('page'=>$page+1));
			admin_show_message($str, $this, $url,1500);
			return;
		}else{
			$str = T('processing_data_success');
			$url = spUrl('admin', 'recreate_image');
			admin_show_message($str, $this, $url,1500);
		}
	}

	function recheck_pin_color(){
		$number = 100;
		$page = $this->spArgs("page",1);
		$ptx_item = spClass('ptx_item');
		$items = $ptx_item->search(null,$page,$number," ptx_item.image_path,ptx_item.item_id ",NULL);
		foreach ($items as $item) {
			$cover_path = APP_PATH.$item['image_path'].'_middle.jpg';
			if(!file_exists($cover_path)){
				continue;
			}
			$imagelib = spClass('ImageLib');
			$data['color'] = $imagelib->sample_color($cover_path);
			$ptx_item->update(array('item_id'=>$item['item_id']),$data);
		}

		if(array_length($items)>0){
			$start=($page-1)*$number;
			$end=$start+$number;
			$str = T('processing_data')."{$start}----{$end}";
			$url = spUrl('admin', 'recheck_pin_color',array('page'=>$page+1));
			admin_show_message($str, $this, $url,1500);
			return;
		}else{
			$str = T('processing_data_success');
			$url = spUrl('admin', 'update_cache');
			admin_show_message($str, $this, $url,1500);
		}
	}

	public function check_channel_item(){
		if($this->check_admin()){
			$act = $this->spArgs("act");
			$channel_name = $this->spArgs("channel",'taobao');
			$channel = spClass("Channel");
			$number = 50;
			$page = $this->spArgs("page",1);
			$ptx_item = spClass('ptx_item');
			$condition['reference_channel']='taobao';
			$items = $ptx_item->search(null,$page,$number," ptx_item.reference_itemid,ptx_item.promotion_url,ptx_item.item_id ",NULL);
			$pid = $this->settings['api_setting']['Taobao']['PID'];
			foreach ($items as $item) {
				if(!strpos($item['promotion_url'], $pid)&&$item['reference_itemid']){
					$promotion = $channel->get_promotion_url($channel_name,$item['reference_itemid']);
					sleep(1);
					if($promotion){
						$scon['item_id']=$item['item_id'];
						$ptx_item->updateField($scon,'promotion_url',$promotion['promotion_url']);
					}
				}
			}
			if(array_length($items)>0){
				$start=($page-1)*$number;
				$end=$start+$number;
				$str = T('processing_data')."{$start}----{$end}";
				$url = spUrl('admin', 'check_channel_item',array('page'=>$page+1));
				admin_show_message($str, $this, $url,1500);
				return;
			}else{
				$str = T('processing_data_success');
				$url = spUrl('admin', 'update_cache');
				admin_show_message($str, $this, $url,1500);
			}
		}
	}

}

function admin_show_message($message,$controller,$url,$period=2000) {
	$url = !$url?$_SERVER['HTTP_REFERER']:$url;
	$url = !$url?$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]:$url;
	$controller->message=$message;
	$controller->url=$url;
	$controller->period=$period;
	$controller->display("/admin/notice.php");
}


function multi($controller,$action,$args,$num, $perpage, $curpage, $maxpages = 0, $page = 10) {
	$realpages = 1;
	$page -= strlen($curpage) - 1;
	if($page <= 0) {
		$page = 1;
	}
	if($num > $perpage) {
		$offset = floor($page * 0.5);
		$realpages = @ceil($num / $perpage);
		$curpage = $curpage > $realpages ? $realpages : $curpage;
		$pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;
		$des = T('total').' '.$num.' '.T('items').', '.T('total').' '.$realpages.' '.T('page').' ('.$perpage.'/'.T('page').'):';

		if($page > $pages) {
			$from = 1;
			$to = $pages;
		} else {
			$from = $curpage - $offset;
			$to = $from + $page - 1;
			if($from < 1) {
				$to = $curpage + 1 - $from;
				$from = 1;
				if($to - $from < $page) {
					$to = $page;
				}
			} elseif($to > $pages) {
				$from = $pages - $page + 1;
				$to = $pages;
			}
		}
		if ($curpage != 1){
			$args['page'] = 1;
			$des .= '<a href="'.spUrl($controller,$action,$args).'">'.T('first_page').'</a> | ';
			$args['page'] = $curpage-1;
			$des .= '<a href="'.spUrl($controller,$action,$args).'">'.T('prev_page').'</a> | ';
		}
		for($i = $from; $i <= $to; $i++) {
			if ($i != $curpage) {
				$args['page'] = $i;
				$des .= '<a href="'.spUrl($controller,$action,$args).'">'.$i.'</a> ';;
			}else{
				$des .= '<b>'.$i.'</b> ';
			}
		}

		if ($curpage != $realpages){
			$args['page'] = $curpage + 1;
			$des .= '<a href="'.spUrl($controller,$action,$args).'">'.T('next_page').'</a> | ';
			$args['page'] = $realpages;
			$des .= '<a href="'.spUrl($controller,$action,$args).'">'.T('last_page').'</a>';
		}
	}
	return $des;
}
