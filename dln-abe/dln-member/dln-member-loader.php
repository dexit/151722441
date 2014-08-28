<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Member_Loader {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		if ( is_admin() ) {
			include( DLN_ABE_PLUGIN_DIR . '/dln-member/includes/admin/member-post-type.php' );
		}
		
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'plugins_loaded', array( $this, 'member_plugin_start_up' ), 999 );
	}
	
	public function admin_init() { }
	
	public function member_plugin_start_up() {
		global $bp;
		
		$using_bp = false;
		if ( is_object( $bp ) && isset( $bp->version ) && version_compare( $bp->version, '2.0', '>=' ) && bp_is_active( 'xprofile' ) )
			$using_bp = true;
		
		// Edit Profile
		if ( ! $using_bp )
			add_action( 'edit_user_profile', array( $this, 'user_nav' ) );
		else
			add_action( 'bp_members_admin_profile_nav', array( $this, 'bp_user_nav' ), 10, 2 );
	}
	
	public function user_nav( $user, $current = NULL ) {
		$current_user_id = get_current_user_id();
		if( $current_user_id == $user->ID ) return;
	
		$classes = 'nav-tab';
		if ( isset( $_GET['ctype'] ) && $_GET['ctype'] == 'dln_member' ) $classes .= ' nav-tab-active';
	
		$tabs[] = array(
				'label'   => __( 'Member', DLN_ABE ),
				'url'     => add_query_arg( array( 'page' => 'dln-member-edit', 'user_id' => $user->ID, 'ctype' => 'dln_member' ), admin_url( 'users.php' ) ),
				'classes' => $classes
		);
	
		$tabs = apply_filters( 'mycred_edit_profile_tabs', $tabs, $user, false );
	
		?>
		<style type="text/css">
		</style>
		<ul id="profile-nav" class="nav-tab-wrapper">
		
			<?php foreach ( $tabs as $tab ) echo '<li class="' . $tab['classes'] . '"><a href="' . $tab['url'] . '">' . $tab['label'] . '</a></li>'; ?>
		
		</ul>
		<?php
	}
		
	public function bp_user_nav( $active, $user ) {
		$current_user_id = get_current_user_id();
		if( $current_user_id == $user->ID ) return;
		
		$classes = 'nav-tab';
		if ( isset( $_GET['ctype'] ) && $_GET['ctype'] == 'dln_member' ) $classes .= ' nav-tab-active';
		
		$tabs[] = array(
			'label'   => __( 'Member', DLN_ABE ),
			'url'     => add_query_arg( array( 'page' => 'dln-member-edit', 'user_id' => $user->ID, 'ctype' => 'dln_member' ), admin_url( 'users.php' ) ),
			'classes' => $classes
		);
	
		$tabs = apply_filters( 'mycred_edit_profile_tabs', $tabs, $user, true );
	
		if ( ! empty( $tabs ) )
		foreach ( $tabs as $tab ) echo '<li class="' . $tab['classes'] . '"><a href="' . $tab['url'] . '">' . $tab['label'] . '</a></li>';
	}
	
}

$GLOBALS['dln_member'] = DLN_Member_Loader::get_instance();