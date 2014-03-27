<?php
/**
 * Profile Submission Form
 */
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<form action="<?php echo $action ?>" method="post" id="submit-profile-form" class="profile-manager-form" enctype="multipart/form-data">
	<?php if ( apply_filters( 'submit_profile_form_show', true ) ) : ?>
		<?php if ( dln_form_user_can_post_profile() ) : ?>
			
			<?php dln_form_profile_fields( $profile_fields ) // Load common profile fields?>
			
			<p>
				<?php wp_nonce_field( 'submit_form_posted' ); ?>
				<input type="hidden" id="company_id" name="company_id" value="<?php echo $company_id ?>" />
				<input type="hidden" id="dln_form" name="dln_form" value="<?php echo $form ?>" />
				<input type="hidden" id="step" name="step" value="<?php echo $step ?>" />
				<input type="submit" id="submit_profile" name="submit_profile" class="button" value="<?php esc_attr_e( $submit_button_text ) ?>" />
			</p>
			
		<?php else : ?>
		
			<?php do_action( 'submit_profile_form_disabled' ); ?>
		
		<?php endif ?>
	<?php endif ?>
</form>