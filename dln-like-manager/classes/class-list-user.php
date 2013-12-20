<?php
/**
 * @package   DLN_Like_Class
 * @author    DinhLN <lenhatdinh@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.facebook.com/lenhatdinh
 * @copyright 2013 by DinhLN
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Include WP's list table class
if ( ! class_exists( 'WP_List_Table' ) ) require( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

/**
 * Table listing user for backend.
 *
 * @package   DLN_Class_List_User extends WP_List_Table
 * @author    dinhln <lenhatdinh@gmail.com> - i - 3:26:26 PM
 */
class DLN_Class_List_User extends WP_List_Table {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      protected
	 */
	protected static $instance = null;
	
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
		parent::__construct( array(
			'ajax'     => false,
			'plural'   => 'dln_users',
			'singular' => 'dln_user',
			'screen'   => get_current_screen()
		) );
	}
	
	/**
	 * Handle filtering of data, sorting, pagination, and any other data manipulation prior to rendering.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   void
	 */
	public function prepare_items() {
		// Option defaults
		$filter       = array();
		$include_id   = false;
		$search_terms = false;
		$sort         = 'DESC';
		
		// Set current page
		$page = $this->get_pagenum();
		
		// Set per page from the screen options
		$per_page = $this->get_items_per_page( str_replace( '-', '_', "{$this->screen->id}_per_page" ) );
		
		// Sort order
		if ( ! empty( $_REQUEST['order'] ) && $_REQUEST['order'] != 'desc' ) {
			$sort = 'ASC';
		}
		
		// Filter
		//if ( ! empty( $_REQUEST ) )
			
		// Search
		if ( ! empty( $_REQUEST['s'] ) ) {
			$search_terms = $_REQUEST['s'];
		}
		
		$controller_user = DLN_Class_Controller_User::get_instance();
		$users           = $controller_user->get_users( array( 
			'filter'       => $filter,
			'in'           => $include_id,
			'page'         => $page,
			'per_page'     => $per_page,
			'search_terms' => $search_terms,
			'sort'         => $sort
		) );
		
		$new_users = array();
		foreach ( $users['users'] as $user_item ) {
			$new_users[] = (array) $user_item;
		}
		
		// Set raw data to display
		$this->items = $new_users;
		
		// Store information needed for handling table pagination.
		$this->set_pagination_args( array(
			'per_page'     => $per_page,
			'total_items'  => $users['total'],
			'total_pages'  => ceil( $users['total'] / $per_page )
		) );
	}
	
	/**
	 * Get an array of all the columns on the page..
	 * 
	 * @since    1.0.0
	 * 
	 * @return   array
	 */
	public function get_column_info() {
		$this->_column_headers = array(
			$this->get_columns(),
			array(),
			$this->get_sortable_columns(),
		);
		
		return $this->_column_headers;
	}
	
	/**
	 * Display a message on screen when no items are found.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   void
	 */
	public function no_items() {
		__( 'No users found', DLN_LIKE_SLUG );
	}
	
	/**
	 * Output the User data table.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   void
	 */
	public function display() {
		extract( $this->_args );
		
		$this->dislay_tablenav( 'top' ); 
		
		?>
		<table class="<?php echo implode( ' ', $this->get_table_classes() ); ?>" cellspacing="0">
			<thead>
				<tr>
					<?php $this->print_column_headers(); ?>
				</tr>
			</thead>

			<tfoot>
				<tr>
					<?php $this->print_column_headers( false ); ?>
				</tr>
			</tfoot>

			<tbody id="the-comment-list">
				<?php $this->display_rows_or_placeholder(); ?>
			</tbody>
		</table>
		<?php
		
		$this->display_tablenav( 'bottom' );
	}
	
	/**
	 * Generate content for a single row of the table.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   void
	 */
	public function single_row( $item ) {
		static $even = false;
		
		if ( $even ) {
			$row_class = ' class="even"';
		} else {
			$row_class = ' class="alternate odd"';
		}
		
		$root_id = $item['id'];
		
		echo '<tr' . $row_class . ' id="dln_user_' . esc_attr( $item['id'] ) . '" data-parent_id="' . esc_attr( $item['id'] ) . '" data-root_id="' . esc_attr( $root_id ) . '">';
		echo $this->single_row_columns( $item );
		echo '</tr>';
		
		$even = ! $even;
	}
}
