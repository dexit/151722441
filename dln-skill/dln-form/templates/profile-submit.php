<?php
/**
 * Profile Submission Form
 */
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<form action="<?php echo $action ?>" method="post" id="submit-profile-form" class="profile-manager-form" enctype="multipart/form-data">
	<?php if ( apply_filters( 'submit_profile_form_show', true ) ) : ?>
		<?php if ( dln_form_user_can_post_profile() ) : ?>
			
			<?php do_action( 'submit_profile_form_profile_fields_start' ) ?>
			
			<?php foreach( $profile_fields as $key => $field ) : ?>
				<fieldset class="fieldset-<?php esc_attr_e( $key ); ?>">
					<label for="<?php esc_attr_e( $key ); ?>"><?php echo $field['label'] . ( $field['required'] ? '' : ' <small>' . __( '(optional)', 'dln-skill' ) . '</small>' ); ?></label>
					<div class="field">
						<?php dln_form_get_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field ) ); ?>
					</div>
				</fieldset>
			<?php endforeach ?>
			
			<?php do_action( 'submit_profile_form_profile_fields_end' ) ?>
			
			<p>
			<?php wp_nonce_field( 'submit_form_posted' ); ?>
				<input type="hidden" name="dln_form" value="<?php echo $form; ?>" />
				<input type="hidden" name="step" value="0" />
				<input type="submit" name="submit_profile" class="button" value="<?php esc_attr_e( $submit_button_text ); ?>" />
			</p>
			
		<?php else : ?>
		
			<?php do_action( 'submit_profile_form_disabled' ); ?>
		
		<?php endif ?>
	<?php endif ?>
</form>