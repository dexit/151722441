<?php
/**
 * Profile Company Submission Form
 */
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<form action="<?php echo $action ?>" method="post" id="submit-profile-company-form" class="profile-manager-form" enctype="multipart/form-data">
	<?php if ( apply_filters( 'submit_profile_company_form_show', true ) ) : ?>
		<?php if ( dln_form_user_can_post_profile() ) : ?>
			
			<?php dln_form_profile_fields( $profile_fields ) // Load common profile fields ?>
			
			<?php do_action( 'submit_profile_company_form_profile_fields_start' ) ?>
			
			<?php foreach( $company_fields as $key => $field ) : ?>
				<fieldset class="fieldset-<?php esc_attr_e( $key ); ?>">
					<label for="<?php esc_attr_e( $key ); ?>"><?php echo $field['label'] . ( $field['required'] ? '' : ' <small>' . __( '(optional)', 'dln-skill' ) . '</small>' ); ?></label>
					<div class="field">
						<?php dln_form_get_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field ) ) ?>
					</div>
				</fieldset>
			<?php endforeach ?>
			
			<?php do_action( 'submit_profile_company_form_profile_fields_end' ) ?>
			
			<p>
				<?php wp_nonce_field( 'submit_form_posted' ); ?>
				<input type="hidden" id="dln_form" name="dln_form" value="<?php echo $form ?>" />
				<input type="hidden" id="step" name="step" value="<?php echo $step ?>" />
				<input type="submit" id="submit_company_profile" name="submit_company_profile" class="button" value="<?php esc_attr_e( $submit_button_text ) ?>" />
			</p>
			
		<?php else : ?>
		
			<?php do_action( 'submit_profile_company_form_disabled' ); ?>
		
		<?php endif ?>
	<?php endif ?>
</form>
