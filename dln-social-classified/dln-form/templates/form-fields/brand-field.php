<?php
	$options[] = "<option value=''>" . esc_attr( $field['placeholder'] ) . '</option>';
	// Get tag brands
	$brands = get_terms( 'dln_fs_brand', array( 'hide_empty' => false, 'order_by' => 'name' ) );
if ( is_array( $brands ) ) {
	foreach ( $brands as $i => $brand ) {
		$options[] = "<option value='{$brand->term_id}'>{$brand->name}</option>";
	}
}
?>
<select id="<?php echo esc_attr( $key ); ?>" class="form-control dln-select-multi" name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?>">
	<?php echo esc_html( implode( '\n', $options ) ) ?>
</select>
<?php if ( ! empty( $field['description'] ) ) : ?>
<span class="help-block"><?php echo esc_html( $field['description'] ) ?></span>
<?php endif; ?>
