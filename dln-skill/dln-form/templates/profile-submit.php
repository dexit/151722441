<?php
/**
 * Profile Submission Form
 */
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">General</h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action ?>" method="post" id="submit-profile-form" class="profile-manager-form form-horizontal form-bordered" enctype="multipart/form-data">
				<h4 class="text-primary mt0">Basic example</h4>
					<p class="pb10">
					Individual form controls automatically receive some global styling. All textual
					<code><input></code>
					,
					<code><textarea></code>
					, and
					<code><select></code>
					elements with
					<code>.form-control</code>
					are set to
					<code>width: 100%;</code>
					by default. Wrap labels and controls in
					<code>.form-group</code>
					for optimum spacing.
					</p>
					<?php if ( apply_filters( 'submit_profile_form_show', true ) ) : ?>
						<?php if ( dln_form_user_can_post_profile() ) : ?>
							
							<?php dln_form_profile_fields( $profile_fields ) // Load common profile fields?>
							
							<div class="panel-footer">
								<div class="form-group no-border">
									<div class="col-sm-12">
										<?php wp_nonce_field( 'submit_form_posted' ); ?>
										<input type="hidden" id="company_id" name="company_id" value="<?php echo esc_attr( $company_id ) ?>" />
										<input type="hidden" id="dln_form" name="dln_form" value="<?php echo esc_attr( $form ) ?>" />
										<input type="hidden" id="step" name="step" value="<?php echo esc_attr( $step ) ?>" />
										<input type="submit" id="submit_profile" name="submit_profile" class="btn btn-primary" value="<?php esc_attr_e( $submit_button_text ) ?>" />
									</div>
								</div>
							</div>
							
						<?php else : ?>
						
							<?php do_action( 'submit_profile_form_disabled' ); ?>
						
						<?php endif ?>
					<?php endif ?>
				</form>
			</div>
		</div>	
	</div>
</div>