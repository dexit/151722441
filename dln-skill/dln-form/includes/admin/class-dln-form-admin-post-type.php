<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Form_Admin_PostType {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		add_action( 'restrict_manage_posts', array( $this, 'company_status_filters' ) );
		add_filter( 'parse_query', array( $this, 'company_status_parse_query' ) );
	}
	
	public function company_status_parse_query() {
		global $pagenow;
		$post_type = DLN_COMPANY_SLUG; // change HERE
		
		$q_vars = &$query->query_vars;
		if ( $pagenow == 'edit.php' && isset($q_vars['post_type'] ) && $q_vars['post_type'] == $post_type && isset( $q_vars[ $taxonomy ] ) && is_numeric( $q_vars[ $taxonomy ] ) && $q_vars[ $taxonomy ] != 0 ) {
			$term              = get_term_by( 'id', $q_vars[$taxonomy], $taxonomy );
			$q_vars[$taxonomy] = $term->slug;
		}
	}
	
	public function company_status_filters() {
		global $typenow;
		
		if ( $typenow != DLN_COMPANY_SLUG )
			return;
		
		// Type Select
		?>
		<select name="company_status" id="dropdown_company_status">
			<option value=""><?php _e( 'Show all types', 'dln-skill' ); ?></option>
			<?php
				$types = self::get_company_status();

				foreach ( $types as $name => $type ) {
					echo '<option value="' . esc_attr( $name ) . '"';

					if ( isset( $_GET['company_status'] ) )
						selected( $name, $_GET['company_status'] );

					echo '>' . esc_html__( $type, 'dln-skill' ) . '</option>';
				}
			?>
		</select>
		<?php
		
	}
	
	public static function get_company_status() {
		return (array) apply_filters( 'dln_form_company_status', array(
			'company_pending'      => __( 'Company Pending', 'dln-skill' ),
			'company_publish'      => __( 'Company Published', 'dln-skill' ),
			'company_ban'          => __( 'Company Banned', 'dln-skill' ),
		) );
	}
	
}

DLN_Form_Admin_PostType::get_instance();