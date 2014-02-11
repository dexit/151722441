<?php
/**
 * Plugin Name.
 *
 * @package   DLN_Bet
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class DLN_Match {
	
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
	
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		// Load plugin text domain
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
		add_action( 'save_post_dln_match', array( $this, 'save_dln_match' ) );
	}
	
	public function init() {
	
	}
	
	public function add_metabox() {
		add_meta_box('dln_metabox_choose', 'Choose', array( $this, 'dln_metabox_choose'), 'dln_match', 'normal', 'high');
	}
	
	public function save_dln_match( $post_id ) {
		if ( 'dln_match' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_dln_match', $post_id ) ) {
				return;
			}
		}
		
		// Save choose
		$choose_data = ( isset( $_POST['choose_data'] ) ) ? $_POST['choose_data'] : '';
		if ( ! $choose_data )
			return;
		
		foreach ( $choose_data as $id => $data ) {
			if ( isset( $data['title'] ) && ! empty( $data['title'] ) && is_int( $id ) ) {
				$args = array(
					'ID'           => $id,
					'post_title'   => $data['title'],
					'post_content' => $data['title'],
					'post_status'  => 'publish',
					'post_type'    => 'dln_choose',
					'post_parent'  => $_POST['post_ID'],
					'post_author'  => get_current_user_id()
				);
				wp_update_post( $args );
				// Update metadata
				if ( isset( $data['multiple'] ) && $data['multiple'] != '' ) {
					DLN_Choose::update_choose_multiple( $id, $data['multiple'] );
				}
			} else if( empty( $data['title'] ) ) {
				$args = array(
					'ID'           => $id,
					'post_title'   => $data['title'],
					'post_content' => $data['title'],
					'post_status'  => 'dln_draft',
					'post_type'    => 'dln_choose',
					'post_parent'  => $_POST['post_ID'],
					'post_author'  => get_current_user_id()
				);
				wp_update_post( $args );
				// Update metadata
				if ( isset( $data['multiple'] ) && $data['multiple'] != '' ) {
					DLN_Choose::update_choose_multiple( $id, $data['multiple'] );
				}
			}
		}
		return;
	}
	
	public function dln_metabox_choose() {
		wp_enqueue_script( 'dln-admin-match', DLN_BET_PLUGIN_URL . 'assets/js/admin-match.js', array( 'jquery' ), DLN_BET_VERSION, true );
		wp_localize_script( 'dln-admin-match', 'Dln_Ajax', DLN_Bet_Helper_Functions::localize_js() );
		
		self::render_the_match_table();
?>
<p>
	<div>
	<?php submit_button( __( 'Add Choose', DLN_BET_SLUG ), 'secondary', 'addchoose', false, array( 'id' => 'newchoose-submit' ) ); ?>
	</div>
	<?php wp_nonce_field( 'dln-add-choose', '_ajax_nonce-dln-add-choose', false ); ?>
	<?php wp_nonce_field( 'dln-update-choose', '_ajax_nonce-dln-update-choose', false ); ?>
	<?php wp_nonce_field( 'dln-delete-choose', '_ajax_nonce-dln-delete-choose', false ); ?>
</p>

<?php
	}
	
	public static function render_the_match_table() {
		$post_id = get_the_ID();
		
		$html_rows = self::render_rows_choose( $post_id );
		?>
		<div id="postcustomstuff">
		<table id="list-match" style="width:100%">
			<thead>
				<tr>
					<th><?php echo __( 'Choose Title', DLN_BET_SLUG ) ?></th>
					<th><?php echo __( 'Choose Multiple', DLN_BET_SLUG ) ?></th>
					<th><?php echo __( 'Choose Link', DLN_BET_SLUG ) ?></th>
					<th><?php echo __( 'Choose Action', DLN_BET_SLUG ) ?></th>
				</tr>
			</thead>
			<tbody id="list-match-body">
				<?php echo $html_rows ?>
			</tbody>
		</table>
		</div>
		<?php
	}
	
	public static function render_rows_choose( $post_id ) {
		$html_rows = '';
		if ( is_int( $post_id ) ) {
			$args = array(
				'post_parent' => $post_id,
				'post_type'   => DLN_SLUG_CHOOSE,
				'post_status' => 'publish',
				'orderby'     => 'ID',
				'order'       => 'ASC'
			);
			$posts = get_posts( $args );
			foreach( $posts as $i => $item ) {
				$multiple = get_post_meta( $item->ID, 'choose_multiple', true );
				$html_rows .= DLN_Choose::render_row_choose_html( $item->ID, $item->post_title, $multiple );
			}
		}
		
		return $html_rows;
	}
}
$_dln_question = DLN_Match::get_instance();