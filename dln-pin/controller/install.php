<?php
/**
 *      [PinTuXiu] (C)2001-2099 ONightjar.com Pintuxiu.com.
 *      This is NOT a freeware, use is subject to license terms
 */
header('Content-Type: text/html; charset=utf-8');
if (file_exists('data/install.lock'))
{
	exit('<div style="width:980px;margin:0 auto;padding:100px;text-align:center;">请先删除data/install.lock再进行安装</div>');
}

class install extends spController
{

	public function __construct() {
		parent::__construct();
	}
	
	public function index(){
		$this->display("install/step1.php");
	}
	
	public function step2(){
	
		$env_check = array(
							'phpversion'=> array("need_version"=> '5.2.0',"curr_version"=>phpversion(),"check"=>true)
						    );

	
		$func_check = array(
							'mysql_connect'=>false, 
						    'iconv'=>false,
							'gd_info'=>false,
						    'json_encode'=>false,
							'curl_init'=>false
						    );
		$dir_check = array(
							"/data" => 					array("check"=>true,"attrib"=> 0),
							"/data/attachments" => 		array("check"=>true,"attrib"=> 0),
						    "/log"=> 					array("check"=>true,"attrib"=> 0),
						    "/tmp"=> 					array("check"=>true,"attrib"=> 0),
						    "/config.php"=> 	array("check"=>true,"attrib"=> 0),
							);
							
		$final_check = true;

		foreach($env_check as $key=>$value) {
			if (strnatcmp($env_check[$key]['curr_version'],$env_check[$key]['need_version']) < 0) { 
				$env_check[$key]['check'] = false;
				$final_check = false;
			}
		}

		foreach($func_check as $key=>$value) {
			$func_check[$key] = function_exists($key);
			if (!$func_check[$key]) $final_check = false;
		}
		
		foreach($dir_check as $key=>$value) {
			$dir_check[$key]['attrib'] = get_file_chmod(APP_PATH.$key);
			if(is_dir(APP_PATH.$key)){
				if($dir_check[$key]['attrib'] != "777"){
					$dir_check[$key]['check'] = false;
					$final_check = false;
				}
			}else{
				if(!is_writable(APP_PATH.$key) ){
					$dir_check[$key]['check'] = false;
					$final_check = false;
				}
			}
		}

		$this->env_check = $env_check;
		$this->func_check = $func_check;
		$this->dir_check = $dir_check;
		$this->final_check = $final_check;
		
		$this->display("install/step2.php");
	}


	public function step3(){
	
		$config = spClass('Options');
		
		if($this->spArgs("db_host")){
			if($config->load('config.php')){
				$db = array(
						'host'=> $this->spArgs("db_host"),
						'port' => $this->spArgs("db_port"),
						'login'=> $this->spArgs("db_login"),
						'password' => $this->spArgs("db_password"),
						'database' => $this->spArgs("db_database"),
						'prefix' => $this->spArgs("db_prefix"),
						);
						
				$admin = array(
						'email'=> $this->spArgs("admin_email"),
						'nickname'=> $this->spArgs("admin_nickname"),
						'password' => $this->spArgs("admin_password"),
						);
						
				$config->set_item('db',$db);
				$config->set_item('default_controller','welcome');
				$config->save('config.php');
				
				$do_install = $this->do_install($db,$admin);
				if($do_install['status'] != 200) {
					$this->install_error = $do_install;
				}else{
					$this->jump(spUrl('install', 'step4'));
				}
			}else{
				$this->install_error = array('status'=>500,'msg'=> 'config.php 文件不存在，请检查文件目录是否完整');
			}
		}
		$this->display("install/step3.php");
	}


	public function step4(){
		
		$this->front_page = host_url(spUrl('welcome', 'index'));
		$this->admin_page = host_url(spUrl('admin', 'login'));
		fopen('data/install.lock', 'w');
	
		$this->display("install/step4.php");
	}
	

	private function do_install($db_config,$admin_userinfo = array()){
		
		//初使化数据库
		$link = mysql_connect($db_config['host'].':'.$db_config['port'], $db_config['login'],  $db_config['password']);
		if (!$link) {
			return array('status'=>500,'msg'=>'数据库链接失败，错误提示：<br />'. mysql_error());
		}
		if(!mysql_select_db($db_config['database'], $link)){
			return array('status'=>500,'msg'=>'数据库不存在，请先建立数据库后再进行安装');
		}
		mysql_query("SET NAMES utf8");
		
		$exist_table = $db_config['prefix'].'ptx_';
		$query = "SHOW TABLES LIKE  '%{$exist_table}%'";
		
		$result = mysql_query($query);
		if ( mysql_num_rows($result) > 0 ) {
		    return array('status'=>500,'msg'=> '数据表已存在，如果需要重新安装请先行删除原有数据表。' );
		}

		
		//导入SQL文件
		$sql = explode(";",file_get_contents(APP_PATH.'/themes/install/install.sql'));
		foreach($sql as $query){
			if(trim($query) == '') continue;
			$query = str_replace('{dbpre}', $db_config['prefix'], $query);
			$result = mysql_query($query);
			if (!$result) {
			    $message  = 'Invalid query: ' . mysql_error() . "\n<br />";
			    $message .= 'Whole query: ' . $query;
			    return array('status'=>500,'msg'=> $message );
			}
		}
		//创建管理员账号
		$admin_email = $admin_userinfo['email'];
		$admin_pass = md5($admin_userinfo['password']);
		$admin_nickname = $admin_userinfo['nickname'];
		$ui_setting['style'] = 'puzzing';
		$ui_setting['color'] = 'pink';
		$basic_setting['lang'] = 'zh_cn';
		$basic_setting = serialize($basic_setting);
		$ui_setting = serialize($ui_setting);
		$prefix = $db_config['prefix'];
		$query = "INSERT INTO `{$prefix}ptx_settings` (`setting_id`, `set_key`, `set_value`) VALUES ('1','ui_styles','{$ui_setting}');";
		mysql_query($query);
		
		$query = "INSERT INTO `{$prefix}ptx_settings` (`setting_id`, `set_key`, `set_value`) VALUES ('2','basic_setting','{$basic_setting}');";
		mysql_query($query);
		
		$create_time = time();
		$query = "INSERT INTO `{$prefix}ptx_user` (`email`, `passwd`, `nickname`, `user_type`,`usergroup_id`, `create_time`) VALUES ('{$admin_email}','{$admin_pass}','{$admin_nickname}',3,1,'{$create_time}') ";
		$result = mysql_query($query);
		if (!$result) {
		    return array('status'=>500,'msg'=> '管理员账号建立失败，请重新安装。<br />如果仍然失败，请与oNightJar.com联系。' );
		}
		
		return array('status'=>200,'msg'=> '数据库导入成功' );
		
	}

	
}