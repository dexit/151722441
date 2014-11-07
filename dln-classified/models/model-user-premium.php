<?php

class DLN_Model_User_Premium extends DAO {
	
	private static $instance;
	
	public static function get_instance() {
		if( !self::$instance instanceof self ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	public function __construct() {
		parent::__construct();
		$this->setTableName( 'dln_user_premium' );
		$this->setPrimaryKey( 'id' );
		$this->setFields( array( 'id', 'user_id', 'premium_type', 'create_time', 'expire_time', 'money', 'notes' ) );
	}
	
	public function import( $file ) {
		$path = osc_plugin_resource( $file ) ;
		$sql  = file_get_contents( $path );

		if(! $this->dao->importSQL($sql) ){
			throw new Exception( "Error importSQL::ModelVoting<br>".$file ) ;
		}
	}
	
}