<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Form_Admin_Taxonomies {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		// Update form
		add_action( 'product_cat_add_form_fields', array( $this, 'add_category_fields' ) );
		add_action( 'product_cat_edit_form_fields', array( $this, 'edit_category_fields' ), 10, 2 );
		add_action( 'fashion_size_tag_add_form_fields', array( $this, 'add_fashion_size_tag_fields' ) );
		add_action( 'fashion_size_tag_edit_form_fields', array( $this, 'edit_fashion_size_tag_fields' ), 10, 2 );
		add_action( 'dln_fs_color_add_form_fields', array( $this, 'add_dln_fs_color_fields' ) );
		add_action( 'dln_fs_color_edit_form_fields', array( $this, 'edit_dln_fs_color_fields' ) );
		add_action( 'created_term', array( $this, 'save_category_fields' ), 10, 3 );
		add_action( 'edit_term', array( $this, 'save_category_fields' ), 10, 3 );
	}
	
	public static function add_dln_fs_color_fields() {
		?>
		<div class="form-field">
			<label for="icon_class"><?php _e( 'Color', DLN_CLF ) ?></label>
			<input id="dln_fs_color_value" name="dln_fs_color_value" class="dln-color-picker" type="text" value=""/>
			<div class="clear"></div>
		</div>
		<?php
	}
	
	public static function edit_dln_fs_color_fields() {
		$dln_fs_color_value = get_woocommerce_term_meta( $term->term_id, 'dln_fs_color_value', true );
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php _e( 'Color', DLN_CLF ) ?></label></th>
			<td>
				<input id="dln_fs_color_value" name="dln_fs_color_value" class="dln-color-picker" type="text" value="<?php echo esc_attr( $dln_fs_color_value ) ?>" size="40" />	
			</td>
		</tr>
		<?php
	}
	
	public static function add_fashion_size_tag_fields() {
		?>
		<div class="form-field">
			<label for="icon_class"><?php _e( 'Icon Class', DLN_CLF ) ?></label>
			<input id="dln_icon_class" name="dln_icon_class" type="text" value="" size="40" />
			<div class="clear"></div>
		</div>
		<?php
	}
	
	public static function edit_fashion_size_tag_fields( $term, $taxonomy ) {
		$dln_icon_class = get_woocommerce_term_meta( $term->term_id, 'dln_icon_class', true );
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php _e( 'Icon Class', DLN_CLF ) ?></label></th>
			<td>
				<input id="dln_icon_class" name="dln_icon_class" type="text" value="<?php echo esc_attr( $dln_icon_class ) ?>" size="40" />
			</td>
		</tr>
		<?php
	}
	
	public static function add_category_fields() {
		$options = self::get_size_tags();
		?>
		<div class="form-field">
			<label for="dln_icon_class"><?php _e( 'Icon Class', DLN_CLF ) ?></label>
			<input id="dln_icon_class" name="dln_icon_class" type="text" value="" size="40" />
			<div class="clear"></div>
		</div>
		<div class="form-field">
			<label for="dln_toggle_color"><?php _e( 'Toggle Color', DLN_CLF ) ?></label>
			<input id="dln_toggle_color" class="dln-color-picker" name="dln_toggle_color" type="text" value="" size="40" />
			<div class="clear"></div>
		</div>
		<div class="form-field">
			<label for="dln_size_tags"><?php _e( 'Size Tags', DLN_CLF ) ?></label>
			<select id="dln_size_tags" name="dln_size_tags[]" class="dln-select2 postform" style="width: 250px;" multiple>
				<?php echo balanceTags( $options ) ?>
			</select>
			<div class="clear"></div>
		</div>
		<?php
	}
	
	public static function edit_category_fields( $term, $taxonomy ) {
		$dln_icon_class   = get_woocommerce_term_meta( $term->term_id, 'dln_icon_class', true );
		$dln_toggle_color = get_woocommerce_term_meta( $term->term_id, 'dln_toggle_color', true );
		$dln_size_tags    = get_woocommerce_term_meta( $term->term_id, 'dln_size_tags', true );
		$dln_size_tags    = unserialize( $dln_size_tags );
		$options          = self::get_size_tags( $dln_size_tags );
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><labell for="dln_icon_class"><?php _e( 'Icon Class', DLN_CLF ) ?></label></th>
			<td>
				<input id="dln_icon_class" name="dln_icon_class" type="text" value="<?php echo esc_attr( $dln_icon_class ) ?>" size="40" />	
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="dln_toggle_color"><?php _e( 'Toggle Color', DLN_CLF ) ?></label></th>
			<td>
				<input id="dln_toggle_color" class="dln-color-picker" name="dln_toggle_color" type="text" value="<?php echo esc_attr( $dln_toggle_color ) ?>" size="40" />
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><labell for="dln_size_tags"><?php _e( 'Size Tags', DLN_CLF ) ?></label></th>
			<td>
				<select id="dln_size_tags" name="dln_size_tags[]" class="dln-select2 postform" style="width: 95%;" multiple>
					<?php echo balanceTags( $options ) ?>
				</select>
			</td>
		</tr>
		<?php
	}
	
	public static function save_category_fields( $term_id, $tt_id, $taxonomy ) {
		if ( isset( $_POST['dln_fs_color_value'] ) ) {
			update_woocommerce_term_meta( $term_id, 'dln_fs_color_value', $_POST['dln_fs_color_value'] );
		}
		if ( isset( $_POST['dln_icon_class'] ) ) {
			update_woocommerce_term_meta( $term_id, 'dln_icon_class', $_POST['dln_icon_class'] );
		}
		if ( isset( $_POST['dln_toggle_color'] ) ) {
			update_woocommerce_term_meta( $term_id, 'dln_toggle_color', $_POST['dln_toggle_color'] );
		}
		if ( isset( $_POST['dln_size_tags'] ) ) {
			$dln_size_tags = $_POST['dln_size_tags'];
			asort( $dln_size_tags );
			update_woocommerce_term_meta( $term_id, 'dln_size_tags', serialize( $dln_size_tags ) );
		}
		
		delete_transient( 'wc_term_counts' );
	}

	private static function get_size_tags( $select_ids = '' ) {
		$html  = '';
		if ( $select_ids && ! is_array( $select_ids ) ) {
			$select_ids = explode( ',', $select_ids );
		}
		$terms = get_terms( 'fashion_size_tag', array( 'hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC' ) );
		
		if ( ! is_wp_error( $terms ) ) {
			foreach ( $terms as $i => $term ) {
				if ( is_array( $select_ids ) && in_array( $term->term_id, $select_ids ) ) {
					$html .= "<option value='{$term->term_id}' selected >{$term->name} ({$term->description})</option>";
				} else {
					$html .= "<option value='{$term->term_id}'>{$term->name} ({$term->description})</option>";
				}
			}
		} else {
			var_dump( $terms->get_error_message() );
		}
		
		return $html;
	}
}

DLN_Form_Admin_Taxonomies::get_instance();