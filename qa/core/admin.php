<?php

/**
 * QA_Core_Admin
 *
 * @package QA
 * @copyright Incsub 2007-2012 {@link http://incsub.com}
 * @license GNU General Public License (Version 2 - GPLv2) {@link http://www.gnu.org/licenses/gpl-2.0.html}
 */
class QA_Core_Admin extends QA_Core {
	/** @var array Holds all capability names, along with descriptions. */
	var $capability_map;

	/** @var string Holds the settings' page hook name. */
	var $hook_suffix;

	/**
	 * Constructor.
	 */
	function QA_Core_Admin() {
		// Settings page ID
		$this->page = 'question_page_qa_settings';
	
		$this->capability_map = array(
			'read_questions'             	=> __( 'View questions', QA_TEXTDOMAIN ),
			'publish_questions'          	=> __( 'Ask questions', QA_TEXTDOMAIN ),
			'immediately_publish_questions'	=> __( 'Immediately publish questions and answers (Otherwise they will be saved as pending)', QA_TEXTDOMAIN ),
			'edit_published_questions'   	=> __( 'Edit own questions', QA_TEXTDOMAIN ),
			'delete_published_questions' 	=> __( 'Delete own questions', QA_TEXTDOMAIN ),
			'edit_others_questions'      	=> __( 'Edit others\' questions', QA_TEXTDOMAIN ),
			'delete_others_questions'    	=> __( 'Delete others\' questions', QA_TEXTDOMAIN ),
			'subscribe_to_new_questions' 	=> __( 'Subscribe to new questions', QA_TEXTDOMAIN ),

			'read_answers'               	=> __( 'View answers', QA_TEXTDOMAIN ),
			'publish_answers'            	=> __( 'Add answers', QA_TEXTDOMAIN ),
			'edit_published_answers'     	=> __( 'Edit own answers', QA_TEXTDOMAIN ),
			'delete_published_answers'   	=> __( 'Delete own answers', QA_TEXTDOMAIN ),
			'edit_others_answers'        	=> __( 'Edit others\' answers', QA_TEXTDOMAIN ),
			'delete_others_answers'      	=> __( 'Delete others\' answers', QA_TEXTDOMAIN ),
			
			'flag_questions'				=> __( 'Report questions and answers', QA_TEXTDOMAIN ),
		);
		
		$this->init();
	}
	
	/**
	 * Intiate hooks.
	 *
	 * @return void
	 */
	function init() {
	
		qa_update_14();

		register_activation_hook( QA_PLUGIN_DIR . 'qa.php', array( &$this, 'init_defaults' ) );

		add_action( 'admin_init', array( &$this, 'admin_head' ) );
		add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
		add_action( 'wp_ajax_qa-get-caps', array( &$this, 'ajax_get_caps' ) );
		add_action( 'wp_ajax_qa-save', array( &$this, 'ajax_save' ) );
		add_action( 'wp_ajax_qa-estimate', array( &$this, 'estimate' ) );
		
		add_action( 'wp_ajax_nopriv_ajax-tag-search', array( &$this, 'ajax_tag_search' ) );
		
		add_action( 'show_user_profile', array( &$this, 'show_user_profile' ) ); 
		add_action( 'edit_user_profile', array( &$this, 'show_user_profile' ) );
		add_action( 'profile_update', array( &$this, 'profile_update' ) );
		add_filter( 'plugin_row_meta', array(&$this,'set_plugin_meta'), 10, 2 );// Add settings link on plugin page

		
		add_filter( 'user_has_cap', array(&$this, 'user_has_cap'), 10, 3);
		
		$this->plugin_name = "qa";
		
		add_action( 'admin_notices', array($this, 'notice_settings') );			// Notice admin to make some settings
		add_action( 'right_now_content_table_end', array($this, 'add_question_counts') );
		
		// Since V 1.3.1
		add_action( 'add_meta_boxes', array( &$this, 'add_metabox' ), 1 );
		add_action( 'save_post', array( &$this, 'save_metabox' ) );
		add_filter( 'manage_question_posts_columns', array( &$this, 'add_column') );
		add_filter( 'manage_answer_posts_columns', array( &$this, 'add_column') );
		add_action( 'manage_posts_custom_column', array( &$this, 'show_column') ); 

	}

	/**
	 * Adds metabox for reported q & a
	 * Since v1.3.1
	 */
	function add_metabox() {
		global $wpdb, $post;
		// Display only for reported q & a
		if ( !is_object( $post ) || !$post->ID )
			return;
			
		$result = $wpdb->get_row( "SELECT * FROM " . $wpdb->postmeta . " WHERE post_id=". $post->ID . " AND meta_key='_qa_report' ");
		
		if ( $result != null ) {
			if ( 'question' == $post->post_type )
				add_meta_box( 
				'reported_question',
				__( 'This Question is Reported', QA_TEXTDOMAIN ),
				array( &$this, 'print_metabox' ),
				'question',
				'side',
				'high'
				);
			else if ( 'answer' == $post->post_type )
				add_meta_box( 
				'reported_answer',
				__( 'This Answer is Reported', QA_TEXTDOMAIN ),
				array( &$this, 'print_metabox' ),
				'answer',
				'side',
				'high'
				);
		}
		
	}
	
	/**
	 * Html codes for report metabox
	 * Since v1.3.1
	 */
	function print_metabox() {
		global $post;
		
		if ( !is_object( $post ) || !$post->ID )
			return;
			
		$meta = get_post_meta( $post->ID, '_qa_report', true );
		// Use nonce for verification
		wp_nonce_field( plugin_basename( __FILE__ ), 'qa_nonce' );

		// The actual fields for data entry
		echo '<label>';
		_e( 'Number of reports:', QA_TEXTDOMAIN );
		echo '</label> ';
		echo '<span class="qa_reported">';
		if ( isset( $meta["count"] ) )
			echo $meta["count"];
		echo '</span>';
		echo '<div class="clear"></div>';
		
		echo '<label>';
		_e( 'Last reported by:', QA_TEXTDOMAIN );
		echo '</label> ';
		echo '<span class="qa_reported">';
		if ( isset( $meta["user"] ) )
			echo $meta["user"];
		echo '</span>';
		echo '<div class="clear"></div>';
	
		echo '<label>';
		_e( 'Last report reason:', QA_TEXTDOMAIN );
		echo '</label> ';
		echo '<span class="qa_reported">';
		if ( isset( $meta["reason"] ) )
			echo stripslashes( $meta["reason"] );
		echo '</span>';
		echo '<div class="clear"></div>';
		
		echo '<label>';
		_e( 'Delete report:', QA_TEXTDOMAIN );
		echo '</label> ';
		echo '<span class="qa_reported">';
		echo '<input type="checkbox" name="qa_delete_report" />';
		echo '</span>';
		echo '<div class="clear"></div>';
	}
	
	/**
	 * Deletes a report
	 * Since v1.3.1
	 */
	function save_metabox( $post_id ) {
		global $post;

		if ( !is_object( $post ) || null == $post )
			return;

		if ( 'question' != $post->post_type && 'answer' != $post->post_type )
			return;
		// verify if this is an auto save routine. 
		// If it is our form has not been submitted, so we dont want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return;

		if ( !wp_verify_nonce( $_POST['qa_nonce'], plugin_basename( __FILE__ ) ) )
			return;

		// Check permissions
		if ( 'question' == $post->post_type ) {
			if ( !current_user_can( 'edit_others_questions', $post->ID ) )
				return;
		}
		else {
			if ( !current_user_can( 'edit_others_answers', $post->ID ) )
				return;
		}
		
		if ( isset( $_POST["qa_delete_report"] ) && $_POST["qa_delete_report"] )
			delete_post_meta( $post->ID, '_qa_report' );
	}

	/**
	 * Adds a column for reported q & a
	 * Since v1.3.1
	 */
	function add_column( $columns ){
		$columns["qa-reported"] = __('Reported', QA_TEXTDOMAIN );
		return $columns;
	}

	/**
	 * Print that q or a is reported
	 * Since v1.3.1
	 */
	function show_column( $name ) {
		if ( 'qa-reported' != $name )
			return;
			
		global $post;
		$meta = get_post_meta( $post->ID, '_qa_report', true );
		
		if ( $meta )
			echo '<span style="color:red;font-weight:bold">' . __('Yes', QA_TEXTDOMAIN ) . '</span>';
		else
			echo '<span style="color:green;font-weight:bold">' . __('No', QA_TEXTDOMAIN ) . '</span>';
	}

	/**
	 * Add Question status counts in admin Right Now Dashboard box
	 * http://codex.wordpress.org/Plugin_API/Action_Reference/right_now_content_table_end
	 */	
	function add_question_counts() {
        if ( !post_type_exists( 'question' ) ) {
             return;
        }

        $num_posts = wp_count_posts( 'question' );
        $num = number_format_i18n( $num_posts->publish );
        $text = _n( 'Question Published', 'Questions Published', intval( $num_posts->publish ) );
        if ( current_user_can( 'edit_posts' ) ) {
            $num = "<a href='edit.php?post_type=question'>$num</a>";
            $text = "<a class='approved' href='edit.php?post_type=question'>$text</a>";
        }
        echo '<td class="first b b-question">' . $num . '</td>';
        echo '<td class="t question">' . $text . '</td>';

        echo '</tr>';

        if ( $num_posts->pending > 0 ) {
            $num = number_format_i18n( $num_posts->pending );
            $text = _n( 'Question Pending', 'Questions Pending', intval( $num_posts->pending ) );
            if ( current_user_can( 'edit_posts' ) ) {
                $num = "<a href='edit.php?post_status=pending&post_type=question'>$num</a>";
                $text = "<a class='waiting' href='edit.php?post_status=pending&post_type=question'>$text</a>";
            }
            echo '<td class="first b b-question">' . $num . '</td>';
            echo '<td class="t question">' . $text . '</td>';

            echo '</tr>';
        }
		
		
		$num_posts = wp_count_posts( 'answer' );
        $num = number_format_i18n( $num_posts->publish );
        $text = _n( 'Answer Published', 'Answers Published', intval( $num_posts->publish ) );
        if ( current_user_can( 'edit_posts' ) ) {
            $num = "<a href='edit.php?post_type=answer'>$num</a>";
            $text = "<a class='approved' href='edit.php?post_type=answer'>$text</a>";
        }
        echo '<td class="first b b-answer">' . $num . '</td>';
        echo '<td class="t answer">' . $text . '</td>';

        echo '</tr>';

        if ( $num_posts->pending > 0 ) {
            $num = number_format_i18n( $num_posts->pending );
            $text = _n( 'Answer Pending', 'Answers Pending', intval( $num_posts->pending ) );
            if ( current_user_can( 'edit_posts' ) ) {
                $num = "<a href='edit.php?post_status=pending&post_type=answer'>$num</a>";
                $text = "<a class='waiting' href='edit.php?post_status=pending&post_type=answer'>$text</a>";
            }
            echo '<td class="first b b-answer">' . $num . '</td>';
            echo '<td class="t answer">' . $text . '</td>';

            echo '</tr>';
        }
		
		global $wpdb;
		$count = $wpdb->get_var( " SELECT COUNT(*) FROM $wpdb->postmeta WHERE meta_key='_qa_report' " );
		
		if ( $count > 0 ) {
            $num = number_format_i18n( $count );
            $text = _n( 'Q&A Reported', 'Q&A Reported', intval( $count ) );
            if ( current_user_can( 'edit_posts' ) ) {
                $num = "<a href='javascript:void(0)'>$num</a>";
                $text = "<span class='spam' >$text</span>";
            }
            echo '<td class="first b b-question">' . $num . '</td>';
            echo '<td class="t question">' . $text . '</td>';

            echo '</tr>';
        }

	}
	
	/**
	 * Warn admin to make some settings
	 */	
	function notice_settings () {
		if ( !current_user_can( 'manage_options' ) )
			return;
			
		global $qa_general_settings;
		$screen = get_current_screen();
		// This is admin side, so one additional query can be accepted for the moment.
		// TODO: Move this into general settings array
		$no_visit = get_option( "qa_no_visit" );
		
		if ( !$no_visit && $screen->id != $this->page ) {
			/* translators: %s means settings here */
			echo '<div class="updated fade"><p>' . 
				sprintf(__("<b>[Q&A]</b> It looks like you have just installed or upgraded Q&A. You may want to adjust some %s. <b>If you are upgrading, please note that page layout handling has been changed.</b>.", QA_TEXTDOMAIN),"<a href='".admin_url('edit.php?post_type=question&page=qa_settings')."'>".__("settings",QA_TEXTDOMAIN)."</a>") .
				'</p></div>';
		}
		// If admin visits setting page, remove this annoying message :P
		if ( $screen->id == $this->page && !$no_visit )
			update_option( "qa_no_visit" , "true" );
			
		// Warn admin is visitor registration is required, but registration is closed.	
		if ( 'assign' != @$qa_general_settings["method"] && !get_option( 'users_can_register' ) )
			/* translators: %s means settings here */
			echo '<div class="error fade"><p>' . 
				sprintf(__("<b>[Q&A]</b> <i>After Visitor Submits a Question</i> setting requires registration of the visitor, but your website is closed to registrations. You may consider to fix this using plugin %s or Wordpress settings.", QA_TEXTDOMAIN),"<a href='".admin_url('edit.php?post_type=question&page=qa_settings')."'>".__("settings",QA_TEXTDOMAIN)."</a>") .
				'</p></div>';

		// Warn admin is visitor role cannot be found.	
		if ( !get_role( 'visitor' ) )
			echo '<div class="error fade"><p>' . 
				__("<b>[Q&A]</b> Visitor role cannot be found. Try to deactivate and reactivate the plugin, if you continue to see this message, consult our Help and Support.", QA_TEXTDOMAIN) .
				'</p></div>';
				
		// Warn admin in case of default permalink.	
		if ( !get_option( 'permalink_structure' ) )
			echo '<div class="error fade"><p>' . 
				__("<b>[Q&A]</b> Plugin will not function correctly with default permalink structure. You need to use a pretty permalink structure.", QA_TEXTDOMAIN) .
				'</p></div>';

	}

	/**
	* Add Settings link to the plugin page
	* @ http://wpengineer.com/1295/meta-links-for-wordpress-plugins/
	*/
	function set_plugin_meta($links, $file) {
		// create link
		$plugin = plugin_basename(__FILE__);
		if ($file == $plugin) {
			return array_merge(
				$links,
				array( sprintf( '<a href="admin.php?page=%s">%s</a>', $this->plugin_name, __('Settings') ) )
			);
		}
		return $links;
	}

	
	/**
	 *	Get saved postbox states
	 */
	function postbox_classes( $css_id ) {
		if ( function_exists( 'postbox_classes' ) )
			return postbox_classes( $css_id, $this->page );
		else
			return "";
	}

	
	function ajax_tag_search() {
		global $wpdb;
		
		if ( isset( $_GET['tax'] ) ) {
			$taxonomy = sanitize_key( $_GET['tax'] );
			$tax = get_taxonomy( $taxonomy );
			if ( ! $tax )
				die( '0' );
		} else {
			die('0');
		}
	
		$s = stripslashes( $_GET['q'] );
	
		if ( false !== strpos( $s, ',' ) ) {
			$s = explode( ',', $s );
			$s = $s[count( $s ) - 1];
		}
		$s = trim( $s );
		if ( strlen( $s ) < 2 )
			die; // require 2 chars for matching
	
		$results = $wpdb->get_col( $wpdb->prepare( "SELECT t.name FROM $wpdb->term_taxonomy AS tt INNER JOIN $wpdb->terms AS t ON tt.term_id = t.term_id WHERE tt.taxonomy = %s AND t.name LIKE (%s)", $taxonomy, '%' . like_escape( $s ) . '%' ) );
		echo join( $results, "\n" );
		die;
		break;
	}

	/**
	 * Initiate variables.
	 *
	 * @return void
	 */
	function init_vars() {}

	/**
	 * Initiate admin default settings.
	 *
	 * @return void
	 */
	function init_defaults() {
		global $wp_roles;
		
		$version = get_option('qa_installed_version');
		
		
		// Version is current and no problem with visitor role; do nothing
		$visitor_role = get_role( 'visitor' );
		if ( $version == QA_VERSION && $visitor_role )
			return;

		// Check if we have some options
		if ( !$options = get_option( QA_OPTIONS_NAME ) )
			$options = array();
		
		// Define visitor role if it is not already defined		
		if ( !$visitor_role )
			add_role('visitor', 'QA Visitor', array('read_questions' => true, 'publish_questions' => true,
					 'immediately_publish_questions' => true, 'read_answers' => true, 'publish_answers' => true) );
					 
		// Default roles and caps
		$droles = array( 'author', 'contributor', 'subscriber', 'editor', 'visitor' );
		$dcaps = array( 'read_questions', 'read_answers', 'publish_questions', 'immediately_publish_questions', 'publish_answers' );

		// For initial installation define preset caps
		if ( !$version ) {
			// Give admin full caps
			foreach ( array_keys( $this->capability_map ) as $capability ) {
				$wp_roles->add_cap( 'administrator', $capability );
			}
			// Set default capabilities
			foreach ( $droles as $drole ) {
				foreach ( $dcaps as $dcap ) {
					$wp_roles->add_cap( $drole, $dcap );
				}
			}
		}
		
		// If an upgrade, set immediately_publish_questions for those who can publish questions
		if ( $version != QA_VERSION ) {
			foreach ( $droles as $drole ) {
				$r = get_role( $drole );
				if ( $r && is_object( $r ) && $r->has_cap( 'publish_questions' ) )
					$wp_roles->add_cap( $drole, 'immediately_publish_questions' );
			}
		}
	
		update_option( 'qa_installed_version', QA_VERSION);
	}

	/**
	 * Register all admin menus.
	 *
	 * @return void
	 */
	function admin_menu() {
		$this->hook_suffix = add_submenu_page( 'edit.php?post_type=question', __( 'Settings', QA_TEXTDOMAIN ), __( 'Settings', QA_TEXTDOMAIN ), 'manage_options', 'qa_settings', array( &$this, 'handle_admin_requests' ) );
	}

	/**
	 * Hook styles and scripts.
	 *
	 * @return void
	 */
	function admin_head() {
		add_action( 'admin_print_styles', array( &$this, 'enqueue_styles' ) );
		add_action( 'admin_print_scripts-' . $this->hook_suffix, array( &$this, 'enqueue_scripts' ) );
	}

	/**
	 * Load styles.
	 *
	 * @return void
	 */
	function enqueue_styles() {
		wp_enqueue_style( 'qa-admin-styles',
						   QA_PLUGIN_URL . 'ui-admin/css/styles.css', array(), QA_VERSION);
	}

	/**
	 * Load scripts.
	 *
	 * @return void
	 */
	function enqueue_scripts() {
		wp_enqueue_script( 'qa-admin-scripts',
							QA_PLUGIN_URL . 'ui-admin/js/scripts.js',
							array( 'jquery' ), QA_VERSION );
	}

	/**
	 * Loads admin page templates.
	 *
	 * @return void
	 */
	function handle_admin_requests() {
		if ( isset( $_GET['page'] ) && $_GET['page'] == 'qa_settings' ) {
			if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'general' || !isset( $_GET['tab'] ) ) {
				if ( isset( $_GET['sub'] ) && $_GET['sub'] == 'general' || !isset( $_GET['sub'] ) ) {
					$this->render_admin('settings-general');
				}
			}
		}
		do_action('handle_module_admin_requests');
	}
	
	/**
	 * Display notification settings in user profile
	 */
	function show_user_profile() {
		if (!current_user_can('subscribe_to_new_questions'))
			return;
		
		if ( file_exists( QA_PLUGIN_DIR . "ui-admin/user_profile.php" ) )
			include QA_PLUGIN_DIR . "ui-admin/user_profile.php";
		else
			echo "<p>Rendering of admin template " . QA_PLUGIN_DIR . "ui-admin/user_profile.php failed</p>";
	}
	
	/**
	 * Save notification settings when the user profile is updated
	 */
	function profile_update() {
		if (!current_user_can('subscribe_to_new_questions'))
			return;
		
		global $wpdb;
		$user_id =  $_REQUEST['user_id'];
		
		if (isset($_POST['qa_notification'])) {
			update_usermeta($user_id, 'qa_notification', $_POST['qa_notification']);
		} else {
			update_usermeta($user_id, 'qa_notification', 0);
		}
	}

	/**
	 * Ajax callback which gets the post types associated with each page.
	 *
	 * @return JSON Encoded string
	 */
	function ajax_get_caps() {
		if ( !current_user_can( 'manage_options' ) )
			die(-1);

		global $wp_roles;

		$role = $_POST['role'];

		if ( !$wp_roles->is_role( $role ) )
			die(-1);

		$role_obj = $wp_roles->get_role( $role );

		$response = array_intersect( array_keys( $role_obj->capabilities ), array_keys( $this->capability_map ) );
		$response = array_flip( $response );

		// response output
		header( "Content-Type: application/json" );
		echo json_encode( $response );
		die();
	}

	/**
	 * Save admin options.
	 *
	 * @return void die() if _wpnonce is not verified
	 */
	function ajax_save() {
		check_admin_referer( 'qa-verify' );

		if ( !current_user_can( 'manage_options' ) )
			die(-1);

		// add/remove capabilities
		global $wp_roles;
		
		$qa_capabilities_set = get_option('qa_capabilties_set', array());
		
		$role = $_POST['roles'];

		$all_caps = array_keys( $this->capability_map );
		if (isset($_POST['capabilities'])) {
			$to_add = array_keys( $_POST['capabilities'] );
		} else {
			$to_add = array();
		}
		$to_remove = array_diff( $all_caps, $to_add );
		
		foreach ( $to_remove as $capability ) {
			$wp_roles->remove_cap( $role, $capability );
		}

		foreach ( $to_add as $capability ) {
			$wp_roles->add_cap( $role, $capability );
		}
		
		if ( qa_is_captcha_usable() && isset( $_POST['captcha'] ) )
			$captcha = true;
		else
			$captcha = false;

		$options = array(
			'general_settings' => array(
				'moderation' 		=> isset( $_POST['moderation'] ),
				'bp_comment_hide'	=> isset( $_POST['bp_comment_hide'] ),
				'page_layout'		=> @$_POST['qa_page_layout'],
				'page_width'		=> trim( @$_POST['page_width'] ),
				'content_width'		=> trim( @$_POST['content_width'] ),
				'content_alignment'	=> @$_POST['content_alignment'],
				'sidebar_width'		=> trim( @$_POST['sidebar_width'] ),
				'search_input_width'=> trim( @$_POST['search_input_width'] ),
				'additional_css'	=> esc_attr(@$_POST['additional_css']),
				'full_width'		=> isset( $_POST['full_width'] ),
				'answers_per_page'	=> trim( @$_POST['answers_per_page'] ),
				'questions_per_page'=> trim( @$_POST['questions_per_page'] ),
				'disable_editor'	=> isset( $_POST['disable_editor'] ),
				'selected_role'		=> @$_POST['roles'],
				'default_category'	=> @$_POST['default_category'],
				'thank_you'			=> @$_POST['thank_you'],
				'unauthorized'		=> @$_POST['unauthorized'],
				'assigned_to'		=> @$_POST['assigned_to'],
				'method'			=> @$_POST['method'],
				'captcha'			=> $captcha,
				'report_reasons'	=> trim( @$_POST['report_reasons'] ),
				'report_email'		=> trim( @$_POST['report_email'] )
			)
		);
		
		$qa_capabilities_set[$role] = true;
		
		update_option( 'qa_capabilties_set', array_unique( $qa_capabilities_set ));
		update_option( QA_OPTIONS_NAME, $options );
		
		update_option( 'qa_email_notification_subject', $_POST['qa_email_notification_subject'] );
		update_option( 'qa_email_notification_content', $_POST['qa_email_notification_content'] );

		die(1);
	}
	
	/**
	 * Estimate css rules
	 * @since 1.4
	 * @return json_encoded result
	 */
	function estimate() {
	
		if ( !current_user_can( 'manage_options' ) )
			die(json_encode(array( 'error'=>esc_js(__('You are not authorised to do this', QA_TEXTDOMAIN)))));
			
		$c_theme = get_template(); // Current theme
		
		if ( strpos( qa_supported_themes(), $c_theme ) !== false )
			die(json_encode(array( 'error'=>sprintf( __('Your current theme %s is already supported by Q&A. No additional css rules are necessary.', QA_TEXTDOMAIN), $c_theme ))));

		$css = '';
		$changed = false;
		global $qa_general_settings;
		
		if ( !isset( $_POST['page_layout'] ) || !isset( $_POST['page_width'] ) || !isset( $_POST['content_width'] ) || !isset( $_POST['sidebar_width'] ) || !isset( $_POST['content_alignment'] ) )
			die(json_encode(array( 'error'=>esc_js(__('At least One of the variables is missing', QA_TEXTDOMAIN)))));
		
		$qa_general_settings['page_layout'] 		= $page_layout			= $_POST['page_layout'];
		$qa_general_settings['page_width'] 			= $page_width			= $_POST['page_width'];
		$qa_general_settings['content_width'] 		= $content_width		= $_POST['content_width'];
		$qa_general_settings['sidebar_width'] 		= $sidebar_width		= $_POST['sidebar_width'];
		$qa_general_settings['content_alignment'] 	= $content_alignment	= $_POST['content_alignment'];
		
		// Post variables are right, so save them.
		update_option( QA_OPTIONS_NAME, $qa_general_settings );	

		$right_margin = $left_margin = 0;
			
		switch( $page_layout ) {
			case 'content-sidebar':

				switch ( $content_alignment ) {
					case 'center':	$right_margin	= $left_margin = (int)(($page_width - $content_width - $sidebar_width ) /2); break;
					case 'left':	$right_margin	= $page_width - $content_width - $sidebar_width; break;
					case 'right':	$left_margin 	= $page_width - $content_width - $sidebar_width;  break;
					default: 		$right_margin	= $left_margin = (int)(($page_width - $content_width - $sidebar_width ) /2); break;
				}
				
				$css .= '#qa-page-wrapper{float:left !important; width:100% !important;margin-right:-'.($sidebar_width+1).'px !important;} ';
				$css .= '#qa-content-wrapper{margin:0 '.$right_margin.'px 0 '.$left_margin.'px !important;}';
				
			break;
			
			case 'sidebar-content':
				switch ( $content_alignment ) {
					case 'center':	$left_margin = (int)(($page_width - $sidebar_width - $content_width) /2) + $sidebar_width; break;
					case 'left':	$left_margin = $sidebar_width ; break;
					case 'right':	$left_margin = $page_width - $content_width; break;
					default: 		$left_margin = (int)(($page_width - $sidebar_width - $content_width) /2) + $sidebar_width; break;
				}
				$css .= '#qa-page-wrapper{float:right !important; width:100% !important;margin-left:-'.($sidebar_width+1).'px !important;} ';
				$css .= '#qa-content-wrapper{margin:0 '.$right_margin.'px 0 '.$left_margin.'px !important;}';
			break;
			
			case 'content':
				switch ( $content_alignment ) {
					case 'center':	$right_margin	= $left_margin = (int)(($page_width - $content_width) /2); break;
					case 'left':	$right_margin	= $page_width - $content_width; break;
					case 'right':	$left_margin	= $page_width - $content_width; break;
					default: 		$right_margin	= $left_margin = (int)(($page_width - $content_width) /2); break;
				}
				$css .= '#qa-page-wrapper{width:100% !important;} ';
				$css .= '#qa-content-wrapper{margin:0 '.$right_margin.'px 0 '.$left_margin.'px !important;}';
			break;
		
			default:	die(json_encode(array( 'error'=>esc_js(__('Page layout is not selected', QA_TEXTDOMAIN))))); break;
		}
		
		if ( $css ) {
			$qa_general_settings['additional_css'] = $css;
			if ( update_option( QA_OPTIONS_NAME, $qa_general_settings ) )
				die(json_encode(array( 'css'=>$css)));
			else
				die(json_encode(array( 'error'=>esc_js(__('Nothing has been changed. Please double check your settings.', QA_TEXTDOMAIN)))));
		}
		// Something went wrong
		die(json_encode(array( 'error'=>esc_js(__('Page layout is not selected', QA_TEXTDOMAIN)))));
	}

	
	/**
	 * Renders an admin section of display code.
	 *
	 * @param  string $name Name of the admin file(without extension)
	 * @param  string $vars Array of variable name=>value that is available to the display code(optional)
	 * @return void
	 */
	function render_admin( $name, $vars = array() ) {
		extract( $vars );

		if ( file_exists( QA_PLUGIN_DIR . "ui-admin/{$name}.php" ) )
			include QA_PLUGIN_DIR . "ui-admin/{$name}.php";
		else
			echo "<p>Rendering of admin template " . QA_PLUGIN_DIR . "ui-admin/{$name}.php failed</p>";
	}
	
	function user_has_cap($allcaps, $caps = null, $args = null) {
		global $current_user, $blog_id, $post;
		
		$qa_capabilities_set = get_option('qa_capabilties_set', array());
		
		$capable = false;
		
		$qa_cap_set = false;
		foreach ($current_user->roles as $role) {
			if (isset($qa_capabilities_set[$role])) {
				$qa_cap_set = true;
			}
		}
		
		if (!$qa_cap_set && preg_match('/(_question|_questions|_answer|_answers)/i', join($caps, ',')) > 0) {
			if (in_array('administrator', $current_user->roles)) {
				foreach ($caps as $cap) {
					$allcaps[$cap] = 1;
				}
				return $allcaps;
			}
			
			foreach ($caps as $cap) {
				$capable = false;
				
				switch ($cap) {
					case 'read_questions':
					case 'read_answers':
						$capable = true;
						break;
					default:
						if (isset($args[1]) && isset($args[2])) {
							if (current_user_can(preg_replace('/_question|_answer/i', '_post', $cap), $args[1], $args[2])) {
								$capable = true;
							}
						} else if (isset($args[1])) {
							if (current_user_can(preg_replace('/_question|_answer/i', '_post', $cap), $args[1])) {
								$capable = true;
							}
						} else if (current_user_can(preg_replace('/_question|_answer/i', '_post', $cap))) {
							$capable = true;
						}
						break;
				}
				
				if ($capable) {
					$allcaps[$cap] = 1;
				}
			}
		}
		return $allcaps;
	}
}

$GLOBALS['_qa_core_admin'] = new QA_Core_Admin();
