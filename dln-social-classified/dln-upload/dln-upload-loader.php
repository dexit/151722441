<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Upload_Loader {
	
	public static $instance;
	public $option  = 'dln_upload_options';
	public static $options = null;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	public static function activate() {
		$default_options = array(
			'max_upload_size' => '100',
			'max_upload_no'   => '2',
			'allow_ext'       => 'jpg,gif,png',
		);
		update_option( 'dln_upload_options', $default_options );
	}
	
	function __construct() {
		add_action( 'admin_init', array( $this, 'register' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue') );
		add_action( 'wp_ajax_dln_upload', array( $this, 'upload' ) );
		add_action( 'wp_ajax_dln_delete', array( $this, 'delete_file' ) );
		/* For non logged-in user */
		add_action( 'wp_ajax_nopriv_dln_upload', array( $this, 'upload') );
		add_action( 'wp_ajax_nopriv_dln_delete', array( $this, 'delete_file' ) );
		add_shortcode( 'dln_upload', array( $this, 'display' ) );
	}
	
	public static function enqueue( $theme ) {
		if ( $theme ) {
			self::add_scripts();
		} else if ( self::has_shortcode( 'dln_upload' ) ) {
			self::add_scripts();
		}
	}
	
	public static function add_scripts() {
		self::$options = get_option( 'dln_upload_options' );
		
		$max_file_size = intval( self::$options['max_upload_size'] ) * 1000 * 1000;
		$max_upload_no = intval( self::$options['max_upload_no'] );
		$allow_ext     = self::$options['allow_ext'];
		
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'plupload-handlers' );
		wp_enqueue_script( 'dln-upload-js', DLN_CLF_PLUGIN_URL . '/dln-upload/js/dln_upload.js', array( 'jquery' ) );
		wp_localize_script(
			'dln-upload-js', 
			'dln_upload', 
			array(
				'ajaxurl'          => admin_url( 'admin-ajax.php' ),
				'nonce'            => wp_create_nonce( 'dln_upload' ),
				'remove'           => wp_create_nonce( 'dln_upload_remove' ),
				'number'           => $max_upload_no,
				'upload_enabled'   => true,
				'confirm_msg'      => __( 'Are you sure you want to delete this?', DLN_CLF ),
				'plupload'         => array(
					'runtimes'         => 'html5,flash,html4',
					'browse_button'    => 'dln_uploader',
					'container'        => 'dln-upload-container',
					'file_data_name'   => 'dln_upload_file',
					'max_file_size'    => $max_file_size . 'b',
					'url'              => admin_url( 'admin-ajax.php' ) . '?action=dln_upload&nonce=' . wp_create_nonce( 'dln_upload_allow' ),
					'flash_swf_url'    => includes_url( 'js/plupload/plupload.flash.swf' ),
					'filters'          => array( array( 'title' => __( 'Allowed Files' ), 'extensions' => $allow_ext ) ),
					'multipart'        => true,
					'urlstream_upload' => true,
				)
			)
		);
	}
	
	public static function display( $atts = null ) {
		if ( isset( $atts ) ) {
			if ( $atts['theme'] == true ) {
				self::enqueue( true );
			}
			
			wp_enqueue_style( 'dln-bootstrap-css' );
			wp_enqueue_style( 'dln-ui-element-css' );
			wp_enqueue_style( 'dln-ui-layout-css' );
			
			include_once ( DLN_CLF_PLUGIN_DIR . '/dln-upload/html.php' );
		}
	}
	
	public static function upload() {
		check_ajax_referer( 'dln_upload_allow', 'nonce' );
		
		$file = array(
			'name'     => $_FILES['dln_upload_file']['name'],
			'type'     => $_FILES['dln_upload_file']['type'],
			'tmp_name' => $_FILES['dln_upload_file']['tmp_name'],
			'error'    => $_FILES['dln_upload_file']['error'],
			'size'     => $_FILES['dln_upload_file']['size'],
		);
		$file = self::file_upload_process( $file );
	}
	
	public static function file_upload_process( $file ) {
		$attachment = self::handle_file( $file );
		
		if ( is_array( $attachment ) ) {
			$html = self::get_html( $attachment );
			
			$response = array(
				'success' => true,
				'html'    => $html,
			);
			
			echo json_encode( $response );
			exit();
		}
		
		$response = array( 'success' => false );
		echo json_encode( $response );
		exit();
	}
	
	public static function handle_file( $upload_data ) {
		$return        = false;
		$uploaded_file = wp_handle_upload( $upload_data, array( 'test_form' => false ) );
		
		if ( isset( $uploaded_file['file'] ) ) {
			$file_loc  = $uploaded_file['file'];
			$file_name = basename( $upload_data['name'] );
			$file_type = wp_check_filetype( $file_name );
			
			$attachment = array(
				'post_mime_type' => $file_type['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
				'post_content'   => '',
				'post_status'    => 'inherit',
			);
			
			$attach_id   = wp_insert_attachment( $attachment, $file_loc );
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file_loc );
			wp_update_attachment_metadata( $attach_id, $attach_data );
			
			$return = array( 'data' => $attach_data, 'id' => $attach_id );
			return $return;
		}
		
		return $return;
	}
	
	public static function get_html( $attachment ) {
		$attach_id = $attachment['id'];
		$file      = explode( '/', $attachment['data']['file'] );
		$file      = array_slice( $file, 0, count( $file ) - 1 );
		$path      = implode( '/', $file );
		$image     = $attachment['data']['sizes']['thumbnail']['file'];
		$post      = get_post( $attach_id );
		$dir       = wp_upload_dir();
		$path      = $dir['baseurl'] . '/' . $path;
		
		$html = '<div class="item thumbnail dln-uploaded-files">
                 	<div class="media">
						<span class="meta bottom darken">
							<h5 class="nm semibold">' . $post->post_title . '</h5>
						</span>
						<img alt="' . $post->post_title . '" width="100%" src="' . $path . '/' . $image . '" style="display: inline;">
						<a href="#" class="btn btn-primary btn-sm action-delete" data-upload_id="' . $attach_id . '"><i class="ico-close2"></i></a></span>
						<input type="hidden" class="dln-image-id" name="dln_image_id[]" value="' . $attach_id . '" />
					</div>
				</div>';
		
		return $html;
	}
	
	public static function has_shortcode( $shortcode = '', $post_id = false ) {
		global $post;
		
		if ( ! $post ) {
			return false;
		}
		
		$post_to_check = ( $post_id == false ) ? get_post( get_the_ID() ) : get_post( $post_id );
		
		if ( ! $post_to_check ) {
			return false;
		}
		$return = false;
		
		if ( ! $shortcode ) {
			return $return;
		}
		
		if ( stripos( $post_to_check->post_content, '[' . $shortcode ) !== false ) {
			$return = true;
		}
		
		return $return;
	}
	
	public static function delete_file() {
		$attach_id = $_POST['attach_id'];
		wp_delete_attachment( $attach_id, true );
		exit();
	}
	
	public static function register() {
		register_setting( 'dln_plugin_upload_option', 'dln_upload_options', array( 'DLN_Upload_Loader', 'validate_options' ) );
	}
	
	public static function validate_options( $input ) {
		return $input;
	}
	
}


add_action( 'admin_menu', 'register_dln_upload_menu_page' );

function register_dln_upload_menu_page() {
	$menu_slug = 'dln_ajax_upload.php';
	//add_menu_page( 'DLN Upload', 'DLN Upload Settings', 'manage_options', $menu_slug, 'dln_upload_settings' );
}

function dln_upload_settings() {
	?>
	<div class="wrap">
	    <h2>DLN Upload Settings</h2>
	
	    <form method="post" name="dln-upload-form" action="<?php echo 'options.php'; ?>">
	        <?php settings_fields( 'dln_plugin_upload_option' ); ?>
	        <?php $options = get_option( 'dln_upload_options' );?>
	        <?php 
	if ( empty ( $options ) ) {
		$options = array(
			'max_upload_size' => '100',
			'max_upload_no'   => '2',
			'allow_ext'       => 'jpg,gif,png',
		);	
	}
	?>
	        <table class="form-table">
	            <tbody>
	            <tr valign="top">
	                <th scope="row"><label for="max_upload_size">Max Upload Size</label></th>
	                <td><input type="text" value="<?php echo esc_attr( $options['max_upload_size'] ) ?>"
	                           name="dln_upload_options[max_upload_size]" size="10">
	
	                    <p class="description">Size in MB.</p>
	                </td>
	            </tr>
	            <tr valign="top">
	                <th scope="row"><label for="max_upload_no">Max Number of Image</label></th>
	                <td><input type="text" value="<?php echo esc_attr( $options['max_upload_no'] ) ?>"
	                           name="dln_upload_options[max_upload_no]" size="10">
	
	                    <p class="description">Maximun number of Images user can upload.</p>
	                </td>
	            </tr>
	            <tr valign="top">
	                <th scope="row"><label for="allow_ext">Allowed Extension</label></th>
	                <td><input type="text" value="<?php echo esc_attr( $options['allow_ext'] ) ?>"
	                           name="dln_upload_options[allow_ext]" size="20">
	
	                    <p class="description">Eg: jpge,gif,png</p>
	                </td>
	            </tr>
	
	            <tr valign="top">
	                <td colspan="2"><?php submit_button(); ?></td>
	            </tr>
	
	            </tbody>
	        </table>
	    </form>
	</div>
	<?php
	}

$GLOBALS['dln_upload'] = DLN_Upload_Loader::get_instance();