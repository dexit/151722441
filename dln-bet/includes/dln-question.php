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

class DLN_Question {
	
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
	}
	
	public function init() {
	
	}
	
	public function add_metabox() {
		add_meta_box('dln_metabox_choose', 'Choose', array( $this, 'dln_metabox_choose'), 'dln_cau_hoi', 'normal', 'high');
	}
	
	public function dln_metabox_choose() {
		wp_enqueue_script( 'dln-admin-question', DLN_BET_PLUGIN_URL . 'assets/js/admin-question.js', array( 'jquery' ), DLN_BET_VERSION, true );
		wp_localize_script( 'dln-admin-question', 'Dln_Ajax', DLN_Bet_Helper_Functions::localize_js() );
?>
<div class="submit">
<?php submit_button( __( 'Add Choose', DLN_BET_SLUG ), 'secondary', 'addchoose', false, array( 'id' => 'newchoose-submit' ) ); ?>
</div>
<?php wp_nonce_field( 'dln-add-choose', '_ajax_nonce-dln-add-choose', false ); ?>

<?php
	}
	
}
$_dln_question = DLN_Question::get_instance();