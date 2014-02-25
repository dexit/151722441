<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Job_UserInfor {
	
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
	}
	
	public function admin_menu() {
		add_users_page( __( 'User CV', DLN_JOB ), __( 'User CV', DLN_JOB ), 'manage_options', 'dln-user-cv', 'listing_user_cv' );
	}
	
	public function listing_user_cv() {
		$wp_list_table = _get_list_table('WP_Users_List_Table');
		$pagenum = $wp_list_table->get_pagenum();
		$title = __( 'Users CV', DLN_JOB );
		
		add_screen_option( 'per_page', array('label' => _x( 'Users', 'users per page (screen options)' )) );
		
		if ( !empty($_GET['_wp_http_referer']) ) {
			wp_redirect( remove_query_arg( array( '_wp_http_referer', '_wpnonce'), wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
			exit;
		}
		
		$wp_list_table->prepare_items();
		$total_pages = $wp_list_table->get_pagination_arg( 'total_pages' );
		if ( $pagenum > $total_pages && $total_pages > 0 ) {
			wp_redirect( add_query_arg( 'paged', $total_pages ) );
			exit;
		}
		
		include( ABSPATH . 'wp-admin/admin-header.php' );
		
		$messages = array();
		if ( isset($_GET['update']) ) :
		switch($_GET['update']) {
			case 'del':
			case 'del_many':
				$delete_count = isset($_GET['delete_count']) ? (int) $_GET['delete_count'] : 0;
				$messages[] = '<div id="message" class="updated"><p>' . sprintf( _n( 'User deleted.', '%s users deleted.', $delete_count ), number_format_i18n( $delete_count ) ) . '</p></div>';
				break;
			case 'add':
				if ( isset( $_GET['id'] ) && ( $user_id = $_GET['id'] ) && current_user_can( 'edit_user', $user_id ) ) {
					$messages[] = '<div id="message" class="updated"><p>' . sprintf( __( 'New user created. <a href="%s">Edit user</a>' ),
							esc_url( add_query_arg( 'wp_http_referer', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ),
									self_admin_url( 'user-edit.php?user_id=' . $user_id ) ) ) ) . '</p></div>';
				} else {
					$messages[] = '<div id="message" class="updated"><p>' . __( 'New user created.' ) . '</p></div>';
				}
				break;
		}
		endif; ?>
		
		<?php if ( isset($errors) && is_wp_error( $errors ) ) : ?>
			<div class="error">
				<ul>
				<?php
					foreach ( $errors->get_error_messages() as $err )
						echo "<li>$err</li>\n";
				?>
				</ul>
			</div>
		<?php endif;
		
		if ( ! empty($messages) ) {
			foreach ( $messages as $msg )
				echo $msg;
		} ?>
		
		<div class="wrap">
		<h2>
		<?php
		echo esc_html( $title );
		if ( current_user_can( 'create_users' ) ) { ?>
			<a href="user-new.php" class="add-new-h2"><?php echo esc_html_x( 'Add New', 'user' ); ?></a>
		<?php } elseif ( is_multisite() && current_user_can( 'promote_users' ) ) { ?>
			<a href="user-new.php" class="add-new-h2"><?php echo esc_html_x( 'Add Existing', 'user' ); ?></a>
		<?php }
		
		if ( $usersearch )
			printf( '<span class="subtitle">' . __('Search results for &#8220;%s&#8221;') . '</span>', esc_html( $usersearch ) ); ?>
		</h2>
		
		<?php $wp_list_table->views(); ?>
		
		<form action="" method="get">
		
		<?php $wp_list_table->search_box( __( 'Search Users' ), 'user' ); ?>
		
		<?php $wp_list_table->display(); ?>
		</form>
		
		<br class="clear" />
		</div>
		
		<?php
	}
	
	public function add_meta_boxes() {
		
	}
	
}
