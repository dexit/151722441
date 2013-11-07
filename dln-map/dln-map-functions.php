<?php
if ( ! function_exists( 'dln_job_types' ) ) {
	function dln_job_types() {
		$options = array();
		$terms   = get_job_listing_types();
		foreach ( $terms as $term )
			$options[ $term->slug ] = $term->name;
		return $options;
	}
}
if ( ! function_exists( 'dln_job_categories' ) ) {
	function dln_job_categories() {
		$options = array();
		$terms   = get_job_listing_categories();
		foreach ( $terms as $term )
			$options[ $term->slug ] = $term->name;
		return $options;
	}
}

if ( ! function_exists( 'dln_filter_submit_job_form_fields' ) ) {
	function dln_filter_submit_job_form_fields( $args = null ) {
		$args = array(
			'job' => array(
				'job_title' => array(
					'label'       => __( 'Job title', 'job_manager' ),
					'type'        => 'text',
					'required'    => true,
					'placeholder' => '',
					'priority'    => 1
				),
				'job_tags'	=> array(
					'label'			=> __( 'Job tags', 'job_manager' ),
					'description'	=> __( 'Job tags description', 'job_manager' ),
					'type'			=> 'dln-map',
					'required'    	=> false,
					'priority'    	=> 2
				),
				'job_location' => array(
					'label'       => __( 'Job location', 'job_manager' ),
					'description' => __( 'Leave this blank if the job can be done from anywhere (i.e. telecommuting)', 'job_manager' ),
					'type'        => 'text',
					'required'    => false,
					'placeholder' => __( 'e.g. "London, UK", "New York", "Houston, TX"', 'job_manager' ),
					'priority'    => 3
				),
				'job_type' => array(
					'label'       => __( 'Job type', 'job_manager' ),
					'type'        => 'select',
					'required'    => true,
					'options'     => dln_job_types(),
					'placeholder' => '',
					'priority'    => 3
				),
				'job_category' => array(
					'label'       => __( 'Job category', 'job_manager' ),
					'type'        => 'select',
					'required'    => true,
					'options'     => dln_job_categories(),
					'placeholder' => '',
					'priority'    => 4
				),
				'job_description' => array(
					'label'       => __( 'Description', 'job_manager' ),
					'type'        => 'job-description',
					'required'    => true,
					'placeholder' => '',
					'priority'    => 5
				),
				'application' => array(
					'label'       => __( 'Application email/URL', 'job_manager' ),
					'type'        => 'text',
					'required'    => true,
					'placeholder' => __( 'Enter an email address or website URL', 'job_manager' ),
					'priority'    => 6
				)
			),
			'company' => array(
				'company_name' => array(
					'label'       => __( 'Company name', 'job_manager' ),
					'type'        => 'text',
					'required'    => true,
					'placeholder' => __( 'Enter the name of the company', 'job_manager' ),
					'priority'    => 1
				),
				'company_website' => array(
					'label'       => __( 'Website', 'job_manager' ),
					'type'        => 'text',
					'required'    => false,
					'placeholder' => __( 'http://', 'job_manager' ),
					'priority'    => 2
				),
				'company_tagline' => array(
					'label'       => __( 'Tagline', 'job_manager' ),
					'type'        => 'text',
					'required'    => false,
					'placeholder' => __( 'Briefly describe your company', 'job_manager' ),
					'maxlength'   => 64,
					'priority'    => 3
				),
				'company_twitter' => array(
					'label'       => __( 'Twitter username', 'job_manager' ),
					'type'        => 'text',
					'required'    => false,
					'placeholder' => __( '@yourcompany', 'job_manager' ),
					'priority'    => 4
				),
				'company_logo' => array(
					'label'       => __( 'Logo', 'job_manager' ),
					'type'        => 'file',
					'required'    => false,
					'placeholder' => '',
					'priority'    => 5
				)
			)
		);
		return $args;
	}
}
add_filter( 'submit_job_form_fields', 'dln_filter_submit_job_form_fields' );

if ( ! function_exists( 'dln_filter_job_manager_locate_template' ) ) {
	function dln_filter_job_manager_locate_template( $template = '', $template_name = '', $template_path = '' ) {
		$_default_path = DLN_MAP_PLUGIN_DIR . '/templates/';
		if ( strpos( $template, 'dln-map' ) !== false ) {
			$template = $_default_path . 'form-fields/dln-map-field.php';
		}
		return $template;
	}
}
add_filter( 'job_manager_locate_template', 'dln_filter_job_manager_locate_template' );