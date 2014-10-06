<?php

if ( ! defined( 'WPINC' ) ) { die; }

if ( ! class_exists( 'DLN_Photo_Post_Type' ) ) :

class DLN_News_Post_Type {

	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	/**
	 * Constructor for this class
	 * 
	 * @return void
	 */
	function __construct() {
		add_filter( 'manage_edit-source_cat_columns', array( $this, 'custom_edit_source_cat_columns' ) );
		add_action( 'source_cat_add_form_fields',     array( $this, 'add_source_cat_fields' ) );
		add_action( 'source_cat_edit_form_fields',    array( $this, 'edit_source_cat_fields' ), 10, 2);
		add_action( 'created_term',                   array( $this, 'save_source_cat_fields' ), 10, 3 );
		add_action( 'edit_term',                      array( $this, 'save_source_cat_fields' ), 10, 3 );
	}
	
	/**
	 * Function to customize columns source category backend
	 * 
	 * @return array
	 */
	public static function custom_edit_source_cat_columns( $columns ) {
		$arr_columns = array();
		
		// Add Link column beside slug column
		foreach ( $columns as $key => $value ) {
			if ( $key == 'slug' ) {
				$arr_columns[ $key ] = $value;
				$arr_columns['source_link'] = __( 'Link', DLN_NEW );
			} else {
				$arr_columns[ $key ] = $value;
			}
		}
		
		// Remove description column
		unset( $arr_columns['description'] );
		
		return $arr_columns;
	}
	
	/**
	 * Function to customize fields of source category when add
	 * 
	 * @return void
	 */
	public static function add_source_cat_fields() {
		?>
		<div class="form-field">
			<label for="dln_source_link"><?php _e( 'Link', DLN_NEW ) ?></label>
			<input id="dln_source_link" name="dln_source_link" type="text" value="" size="40" />
			<div class="clear"></div>
		</div>
		<div class="form-field">
			<label for="dln_source_type"><?php _e( 'Type', DLN_NEW ) ?></label>
			<input id="dln_source_type" name="dln_source_type" type="text" value="" size="40" />
			<div class="clear"></div>
		</div>
		<?php
	}
	
	/**
	 * Function to customize fields source category when edit
	 * 
	 * @param array $term
	 * @param array $taxonomy
	 */
	public static function edit_source_cat_fields( $term, $taxonomy ) {
		$source = DLN_Helper_Source::select_source( $term->term_id );
		$source_link = ( ! empty( $source->link ) ) ? $source->link : '';
		$source_type = ( ! empty( $source->type ) ) ? $source->type : '';
		
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="dln_source_link"><?php _e( 'Link', DLN_NEW ) ?></label></th>
			<td>
				<input id="dln_source_link" name="dln_source_link" type="text" value="<?php echo esc_attr( $source_link ) ?>" size="40" />	
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="dln_source_type"><?php _e( 'Type', DLN_NEW ) ?></label></th>
			<td>
				<input id="dln_source_type" name="dln_source_type" type="text" value="<?php echo esc_attr( $source_type ) ?>" size="40" />	
			</td>
		</tr>
		<?php
	}
	
	public static function save_source_cat_fields( $term_id, $tt_id, $taxonomy ) {
		$link = isset( $_POST['dln_source_link'] ) ? $_POST['dln_source_link'] : '';
		$type = isset( $_POST['dln_source_type'] ) ? $_POST['dln_source_type'] : '';
		
		$result = DLN_Helper_Source::add_source( $term_id, $link, $type );
		if ( is_wp_error( $result ) ) {
			echo $result->get_error_message();
		}
	}
	
}

DLN_News_Post_Type::get_instance();

endif;