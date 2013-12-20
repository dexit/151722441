<?php
/**
 * @package   DLN_Like_Class
 * @author    DinhLN <lenhatdinh@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.facebook.com/lenhatdinh
 * @copyright 2013 by DinhLN
 */

/**
 * Class model for table dln_user.
 *
 * @package   DLN_Class_Model_User
 * @author    dinhln <lenhatdinh@gmail.com> - i - 2:58:01 PM
 */
class DLN_Class_Model_User {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      protected
	 */
	protected static $instance = null;
	
	/**
	 * Table name.
	 *
	 * @since    1.0.0
	 *
	 * @var      public
	 */
	public $table = '';
	
	/**
	 * Return an instance of this class.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   object
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
   /**
	 * Initialize the plugin by setting localization and loading public scripts.
	 * 
	 * @since 	 1.0.0
	 * 
	 * @return   void
	 */
	private function __construct() {
		global $wpdb;
		
		// Setting variable
		$this->table = $wpdb->base_prefix . 'dln_user';
		
		if( @is_file( ABSPATH . '/wp-admin/includes/upgrade.php' ) )
			include_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
		else
			die( __( 'We have problem finding your \'/wp-admin/upgrade-functions.php\' and \'/wp-admin/includes/upgrade.php\'', DLN_LIKE_SLUG ) );
	}
	
	/**
	 * Function create new dln_user table.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   void
	 */
	public function create_table() {
		global $wpdb;
		
		if ( ! empty( $wpdb->charset ) )
			$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$db_charset_collate .= " COLLATE $wpdb->collate";
		
		if ( $this->table ) {
			$sql   = "CREATE TABLE $this->table (
			id bigint(20) unsigned NOT NULL auto_increment,
			user_id bigint(35) NOT NULL default '0',
			fbid varchar(35) NULL,
			access_token text NULL,
			crawl bool DEFAULT 0,
			PRIMARY KEY  (id)
			) ENGINE=MyISAM $db_charset_collate;";
			dbDelta( $sql );
		}
	}
	
	/**
	 * Add new dln user.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   string
	 */
	public function add_user( $userid = '', $fbid = '', $access_token = '', $crawl = '0' ) {
		if ( ! $this->table )
			return null;
		global $wpdb;
		$result = $wpdb->get_row( "INSERT INTO {$this->table} (`userid`, `fbid`, `access_token`, `crawl`) VALUES({$userid}, '{$fbid}', '{$access_token}', {$crawl})" );
		return $result;
	}
	
	/**
	 * Get user by id.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   object
	 */
	public function get_user( $user_id = '' ) {
		if ( ! $this->table )
			return null;
		global $wpdb;
		$result = $wpdb->get_row( "SELECT * FROM {$this->table} WHERE `userid` = {$user_id}" );
		return $result;
	}
	
	/**
	 * get user query.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   object
	 */
	public function get( $args = array() ) {
		global $wpdb;
		
		$defaults = array(
			'max'          => false,
			'page'         => 1,
			'per_page'     => false,
			'sort'         => 'DESC',
			'exclude'      => false,
			'search_terms' => false,
			'in'           => false,
			'filter'       => false,
			'meta_query'   => false
		);
		$r = wp_parse_args( $args, $defaults );
		extract( $r );
		
		// Select conditions
		$select_sql = " SELECT DISTINCT du.*, u.display_name ";
		$from_sql   = " FROM {$this->table} du LEFT JOIN {$wpdb->users} u ON du.user_id = u.user_id ";
		
		$where_conditions  = array();
		// Searching
		if ( $search_terms ) {
			$search_terms = esc_sql( $search_terms );
			$where_conditions['search_sql'] = " u.display_name LIKE '%%" . esc_sql( like_escape( $search_terms ) ) . "%%' ";
		}
		
		// Filtering
		if ( $filter && $filter_sql = $this->get_filter_sql( $filter ) ) {
			$where_conditions['filter_sql'] = $filter_sql;
		}
		
		// Sorting
		if ( $sort != 'ASC' && $sort != 'DESC' ) {
			$sort = 'DESC';
		}
		
		// Exclude specified items
		if ( ! empty( $exclude ) ) {
			$exclude = implode( ',', wp_parse_id_list( $exclude ) );
			$where_conditions['exclude'] = " du.id NOT IN ({$exclude}) ";
		}
		
		// The specific ids to which you want to limit the query
		if ( ! empty( $in ) ) {
			$in = implode( ',', wp_parse_id_list( $in ) );
			$where_conditions['in'] = " du.id IN ({$in}) ";
		}
		
		// Process meta_query into SQL
		$meta_query_sql = self::get_meta_query_sql( $meta_query );
		
		if ( ! empty( $meta_query_sql['join'] ) ) {
			$join_sql .= $meta_query_sql['join'];
		}
		
		if ( ! empty( $meta_query_sql['where'] ) ) {
			$where_conditions[] = $meta_query_sql['where'];
		}
		
		// Filter the where conditions
		$where_conditions = apply_filters( 'dln_user_get_where_conditions', $where_conditions, $r, $select_sql, $from_sql, $join_sql );
		
		// Join the where conditions together
		$where_sql = 'WHERE ' . join( ' AND ', $where_conditions );
		
		// Define the preferred order for indexes
		$indexes = apply_filters( 'dln_user_preferred_index_order', array( 'user_id', 'fbid', 'access_token', 'crawl' ) );
		
		foreach( $indexes as $key => $index ) {
			if ( false !== strpos( $where_sql, $index ) ) {
				$the_index = $index;
				break; // Take the first one we find
			}
		}
		
		if ( !empty( $the_index ) ) {
			$index_hint_sql = "USE INDEX ({$the_index})";
		} else {
			$index_hint_sql = '';
		}
		
		if ( !empty( $per_page ) && !empty( $page ) ) {
			// Make sure page values are absolute integers
			$page     = absint( $page     );
			$per_page = absint( $per_page );
		
			$pag_sql    = $wpdb->prepare( "LIMIT %d, %d", absint( ( $page - 1 ) * $per_page ), $per_page );
			$users      = $wpdb->get_results( apply_filters( 'dln_user_get_user_join_filter', "{$select_sql} {$from_sql} {$join_sql} {$where_sql} ORDER BY du.id {$sort} {$pag_sql}", $select_sql, $from_sql, $where_sql, $sort, $pag_sql ) );
		} else {
			$users      = $wpdb->get_results( apply_filters( 'dln_user_get_user_join_filter', "{$select_sql} {$from_sql} {$join_sql} {$where_sql} ORDER BY du.id {$sort}", $select_sql, $from_sql, $where_sql, $sort ) );
		}
		
		$total_users_sql = apply_filters( 'dln_user_toal_users_sql', "SELECT count(DISTINCT du.id) FROM {$this->table} du {$index_hint_sql} {$join_sql} {$where_sql} ORDER BY a.date_recorded {$sort}", $where_sql, $sort );
		$total_users     = $wpdb->get_var( $total_users_sql );
		
		return array( 'users' => $users, 'total' => (int) $total_users );
	}
	
	/**
	 * Create filter SQL clauses.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   array
	 */
	public function get_filter_sql( $filter_array ) {
		$filter_sql = array();
		
		if ( ! empty( $filter_array( 'id' ) ) ) {
			$id_sql = $this->get_in_operator_sql( 'du.id', $filter_array['id'] );
			if ( ! empty( $id_sql ) ) {
				$filter_sql[] = $id_sql;
			}
		}
		
		if ( ! empty( $filter_array( 'fbid' ) ) ) {
			$fbid_sql = $this->get_in_operator_sql( 'du.fbid', $filter_array['fbid'] );
			if ( ! empty( $fbid_sql ) ) {
				$filter_sql[] = $fbid_sql;
			}
		}
		
		if ( ! empty( $filter_array( 'crawl' ) ) ) {
			$crawl_sql = $this->get_in_operator_sql( 'du.crawl', $filter_array['crawl'] );
			if ( ! empty( $crawl_sql ) ) {
				$filter_sql[] = $crawl_sql;
			}
		}
		
		if ( empty( $filter_sql ) ) {
			return false;
		}
		
		return join( ' AND ', $filter_sql );
	}
	
	/**
	 * Create SQL IN clause for filter queries.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   string
	 */
	public function get_in_operator_sql( $field, $items ) {
		global $wpdb;
		
		// Slit items at the comma
		$items_dirty = explode( ',', $items );
		
		// Array of prepared integers or quoted strings
		$items_prepared = array();
		
		// Clean up and format each item
		foreach ( $items_dirty as $item ) {
			// Clean up the string
			$item = trim( $item );
			// Pass everything through prepare for security and to safely quote strings
			$items_prepared[] = ( is_numeric( $item ) ) ? $wpdb->prepare( '%d', $item ) : $wpdb->prepare( '%s', $item );
		}
		
		// Build IN operator sql syntax
		if ( count( $items_prepared ) ) {
			return sprintf( '%s IN ( %s )', trim( $field ), implode( ',', $items_prepared ) );
		} else {
			return false;
		}
	}
	
}
