<?php
/**
 * Profile Company Submission Form
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $page_title ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action ?>" method="post" id="submit-profile-company-form" class="profile-manager-form form-horizontal form-bordered" enctype="multipart/form-data">
				<h4 class="text-primary mt0"><?php echo $page_title ?></h4>
				<p class="pb10"><?php echo $page_description ?></p>
				<?php if ( apply_filters( 'submit_profile_company_form_show', true ) ) : ?>
					<?php if ( dln_form_user_can_post_profile() ) : ?>
						
						<?php dln_form_profile_fields( $profile_fields ) // Load common profile fields ?>
						
						<?php do_action( 'submit_profile_company_form_profile_fields_start' ) ?>
						
						<?php foreach( $company_fields as $key => $field ) : ?>
							
							<div class="form-group fieldset-<?php esc_attr_e( $key ); ?>">
								<?php if ( $field['label'] ) : ?>
								<label class="col-sm-3 control-label" for="<?php esc_attr_e( $key ); ?>"><?php echo $field['label'] . ( $field['required'] ? '' : ' <small>' . __( '(optional)', 'dln-skill' ) . '</small>' ); ?></label>
								<?php endif ?>
								<div class="col-sm-9">
									<?php dln_form_get_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field ) ) ?>
								</div>
							</div>
							
						<?php endforeach ?>
						
						<?php do_action( 'submit_profile_company_form_profile_fields_end' ) ?>
						
						<div class="panel-footer">
							<div class="form-group no-border">
								<label class="col-sm-3 control-label"></label>
								<div class="col-sm-9">
									<?php wp_nonce_field( 'submit_form_posted' ); ?>
									<input type="hidden" id="company_id" name="company_id" value="<?php echo esc_attr( $company_id ) ?>" />
									<input type="hidden" id="dln_form" name="dln_form" value="<?php echo esc_attr( $form ) ?>" />
									<input type="hidden" id="step" name="step" value="<?php echo esc_attr( $step ) ?>" />
									<input type="hidden" id="submit_profile_company" name="submit_profile_company" value="<?php echo esc_attr( $form ) ?>" />
									<button type="submit" class="btn btn-primary"><?php esc_attr_e( $submit_button_text ) ?></button>
							</div>
						</div>
					</div>
						
					<?php else : ?>
					
						<?php do_action( 'submit_profile_company_form_disabled' ); ?>
					
					<?php endif ?>
				<?php endif ?>
				</form>
			</div>
		</div>
	</div>
</div>

