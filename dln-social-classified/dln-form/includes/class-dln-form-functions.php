<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Form_Functions {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		
		return self::$instance;
	}
	
	public static function form_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
		if ( $args && is_array( $args ) )
			extract( $args );
		
		include( self::form_locate_template( $template_name, $template_path, $default_path ) );
	}
	
	public static function form_locate_template( $template_name, $template_path = '', $default_path = '' ) {
		if ( ! $template_path )
			$template_path = 'dln_fashion';
		if ( ! $default_path )
			$default_path = DLN_CLF_PLUGIN_DIR . '/dln-form/templates/';
	
		$template = locate_template(
			array(
				trailingslashit( $template_path ) . $template_name,
				$template_name,
			)
		);
		
		// Get default template
		if ( ! $template )
			$template = $default_path . $template_name;
		
		// Return what we found
		return apply_filters( 'dln_form_locate_template', $template, $template_name, $template_path );
	}
	
	public static function load_frontend_assets() {
		wp_enqueue_script( 'dln-bootstrap-js' );
		wp_enqueue_script( 'dln-selectize-js' );
		wp_enqueue_script( 'dln-dropzone-js' );
		wp_enqueue_script( 'dln-form-submit-fashion-js' );
		
		wp_enqueue_style( 'dln-bootstrap-css' );
		wp_enqueue_style( 'dln-ui-element-css' );
		wp_enqueue_style( 'dln-ui-layout-css' );
		wp_enqueue_style( 'dln-selectize-css' );
		wp_enqueue_style( 'dln-dropzone-css' );
		wp_enqueue_style( 'dln-ico-font-css' );
		wp_enqueue_style( 'dln-form-site-css' );
	}
	
	public static function form_user_can_post_profile() {
		$can_post = true;
		
		if ( ! is_user_logged_in() ) {
			//if ( dln_form_user_requires_account() && ! dln_form_enable_registration() ) {
				$can_post = false;
			//}
		}
		
		return apply_filters( 'dln_form_user_can_post_profile', $can_post );
	}
	
	public static function form_profile_fields( $fashion_fields ) {
		do_action( 'submit_profile_form_profile_fields_start' );
		
		foreach ( $fashion_fields as $key => $field ) {
			$parent_key_class   = ( ! empty( $field['parent_key_class'] ) ) ? $field['parent_key_class'] : 'col-sm-3';
			$parent_value_class = ( ! empty( $field['parent_value_class'] ) ) ? $field['parent_value_class'] : 'col-sm-9';
			?>
			<div class="form-group fieldset-<?php esc_attr_e( $key ); ?>">
				<?php if ( $field['label'] ) : ?>
				<label class="<?php echo esc_attr( $parent_key_class ) ?> control-label" for="<?php esc_attr_e( $key ); ?>"><?php echo balanceTags( $field['label'] . ( $field['required'] ? '' : ' <small>' . __( '(optional)', 'dln-skill' ) . '</small>' ) ); ?></label>
				<?php endif ?>
				<div class="<?php echo esc_attr( $parent_value_class ) ?>">
					<?php self::form_get_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field ) ) ?>
				</div>
			</div>
		<?php }
		
		do_action( 'submit_profile_form_profile_fields_end' );
	}
	
}