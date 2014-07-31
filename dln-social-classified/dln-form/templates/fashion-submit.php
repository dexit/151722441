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
				<h3 class="panel-title"><?php echo esc_html( $page_title ) ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo esc_attr( $action ) ?>" method="post" id="submit_fashion_form" class="profile-manager-form form-horizontal form-bordered" enctype="multipart/form-data">
					<h4 class="text-primary mt0"><?php echo esc_html( $page_title ) ?></h4>
					<p class="pb10"><?php echo esc_html( $page_description ) ?></p>
					<?php if ( apply_filters( 'submit_profile_form_show', true ) ) : ?>
						<?php if ( DLN_Form_Functions::form_user_can_post_profile() ) : ?>
						
							<?php DLN_Form_Functions::form_profile_fields( $fashion_fields ) // Load common profile fields?>
							
							<div class="panel-footer">
								<div class="form-group no-border">
									<label class="col-sm-3 control-label"></label>
									<div class="col-sm-9">
										<?php wp_nonce_field( 'submit_form_posted' ); ?>
										<input type="hidden" id="fashion_id" name="fashion_id" value="<?php echo esc_attr( $fashion_id ) ?>" />
										<input type="hidden" id="dln_form" name="dln_form" value="<?php echo esc_attr( $form ) ?>" />
										<input type="hidden" id="step" name="step" value="<?php echo esc_attr( $step ) ?>" />
										<input type="hidden" id="submit_fashion" name="submit_fashion" value="<?php echo esc_attr( $form ) ?>" />
										
										<button type="button" id="dln_submit_fashion" class="btn btn-primary"><?php esc_attr_e( $submit_button ) ?></button>
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