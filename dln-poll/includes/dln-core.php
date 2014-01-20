<?php
/**
 * Plugin Name.
 *
 * @package   DLN_Poll
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class DLN_Core {
	
	function DLN_Core() {
		load_plugin_textdomain( DLN_SLUG, '', plugin_basename( DLN_PLUGIN_DIR . 'languages' ) );
		register_activation_hook( DLN_PLUGIN_DIR . 'loader.php', array( &$this, 'install' ) );
		
		add_action( 'init', array( &$this, 'init' ) );
		//add_action( 'template_redirect', array( &$this, 'load_default_style' ), 11 );
		add_action( 'template_redirect', array( &$this, 'template_redirect' ), 12 );
		add_action( 'option_rewrite_rules', array(&$this, 'check_rewrite_rules') );
	}
	
	public function init() {
		global $wp, $wp_rewrite;
	
		// Ask page
		$wp->add_query_var( 'dln_ask' );
		$this->add_rewrite_rule( DLN_SLUG_ROOT . '/' . DLN_SLUG_ASK . '/?$', array (
				'dln_ask' => 1
		) );
	
		// Ask page
		$wp->add_query_var( 'dln_edit' );
		$this->add_rewrite_rule( DLN_SLUG_ROOT . '/' . DLN_SLUG_EDIT . '/?$', array (
				'dln_ask' => 1
		) );
	
		// Has to come before the 'question' post type definition
		register_taxonomy( 'dln_question_category', 'dln_question', array(
		'hierarchical' => true,
		'rewrite' => array( 'slug' => DLN_SLUG_ROOT . '/' . DLN_SLUG_CATEGORIES, 'with_front' => false ),
	
		'capabilities' => array(
		'manage_terms' => 'edit_others_questions',
		'edit_terms' => 'edit_others_questions',
		'delete_terms' => 'edit_others_questions',
		'assign_terms' => 'edit_published_questions'
				),
				'labels' => array(
				'name' => __( 'Question Categories', DLN_SLUG ),
				'singular_name' => __( 'Question Category', DLN_SLUG ),
				'search_items' => __( 'Search Question Categories', DLN_SLUG ),
				'all_items' => __( 'All Question Categories', DLN_SLUG ),
				'parent_item' => __( 'Parent Question Category', DLN_SLUG ),
				'parent_item_colon' => __( 'Parent Question Category:', DLN_SLUG ),
				'edit_item' => __( 'Edit Question Category', DLN_SLUG ),
				'update_item' => __( 'Update Question Category', DLN_SLUG ),
				'add_new_item' => __( 'Add New Question Category', DLN_SLUG ),
				'new_item_name' => __( 'New Question Category Name', DLN_SLUG ),
				)
		) );
	
		// Has to come before the 'question' post type definition
		register_taxonomy( 'dln_question_tag', 'dln_question', array(
		'rewrite' => array( 'slug' => DLN_SLUG_ROOT . '/' . DLN_SLUG_TAGS, 'with_front' => false ),
	
		'capabilities' => array(
		'manage_terms' => 'edit_others_questions',
		'edit_terms' => 'edit_others_questions',
		'delete_terms' => 'edit_others_questions',
		'assign_terms' => 'edit_published_questions'
				),
	
				'labels' => array(
				'name'			=> __( 'Question Tags', DLN_SLUG ),
				'singular_name'	=> __( 'Question Tag', DLN_SLUG ),
				'search_items'	=> __( 'Search Question Tags', DLN_SLUG ),
				'popular_items'	=> __( 'Popular Question Tags', DLN_SLUG ),
				'all_items'		=> __( 'All Question Tags', DLN_SLUG ),
				'edit_item'		=> __( 'Edit Question Tag', DLN_SLUG ),
				'update_item'	=> __( 'Update Question Tag', DLN_SLUG ),
				'add_new_item'	=> __( 'Add New Question Tag', DLN_SLUG ),
				'new_item_name'	=> __( 'New Question Tag Name', DLN_SLUG ),
				'separate_items_with_commas'	=> __( 'Separate question tags with commas', DLN_SLUG ),
				'add_or_remove_items'			=> __( 'Add or remove question tags', DLN_SLUG ),
				'choose_from_most_used'			=> __( 'Choose from the most used question tags', DLN_SLUG ),
				)
		) );
	
		$args = array(
				'public' => true,
				'rewrite' => array( 'slug' => QA_SLUG_ROOT, 'with_front' => false ),
				'has_archive' => true,
	
				'capability_type' => 'question',
				'capabilities' => array(
						'read' => 'read_questions',
						'edit_posts' => 'edit_published_questions',
						'delete_posts' => 'delete_published_questions',
				),
				'map_meta_cap' => true,
	
				'supports' => array( 'title', 'editor', 'author', 'comments', 'revisions' ),
	
				'labels' => array(
						'name'			=> __('Questions', DLN_SLUG),
						'singular_name'	=> __('Question', DLN_SLUG),
						'add_new'		=> __('Add New', DLN_SLUG),
						'add_new_item'	=> __('Add New Question', DLN_SLUG),
						'edit_item'		=> __('Edit Question', DLN_SLUG),
						'new_item'		=> __('New Question', DLN_SLUG),
						'view_item'		=> __('View Question', DLN_SLUG),
						'search_items'	=> __('Search Questions', DLN_SLUG),
						'not_found'		=> __('No questions found.', DLN_SLUG),
						'not_found_in_trash'	=> __('No questions found in trash.', DLN_SLUG),
				)
		);
	
		register_post_type( 'dln_question', $args );
	}
	
	/**
	 * Simple wrapper for adding straight rewrite rules,
	 * but with the matched rule as an associative array.
	 *
	 * @see http://core.trac.wordpress.org/ticket/16840
	 *
	 * @param string $regex The rewrite regex
	 * @param array $args The mapped args
	 * @param string $position Where to stick this rule in the rules array. Can be 'top' or 'bottom'
	 */
	public function add_rewrite_rule( $regex, $args, $position = 'top' ) {
		global $wp, $wp_rewrite;
	
		$result = add_query_arg( $args, 'index.php' );
		add_rewrite_rule( $regex, $result, $position );
	}
	
	public function install() {
		// Nothing to do
	}
	
	public function check_rewrite_rules($value) {
		//prevent an infinite loop
		if ( !post_type_exists( 'question' ) )
			return $value;
	
		if ( ! is_array( $value ) )
			$value = array();
	
		$array_key = DLN_SLUG_ROOT . '/' . DLN_SLUG_ASK . '/?$';
		if ( ! array_key_exists( $array_key, $value ) ) {
			$this->flush_rules();
		}
		return $value;
	}
	
	/**
	 * Flush rewrite rules when the plugin is activated.
	 */
	public function flush_rules() {
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	}
	
	public function template_redirect() {
		global $wp_query;
		
		if ( ! $this->is_page_allowed() ) {
			$redirect_url = site_url();
			if ( isset( $this->g_settings["unauthorized"] ) )
				$redirect_url = get_permalink( $this->g_settings["unauthorized"] );
				
			wp_redirect( $redirect_url );
			die;
		}
		
		if ( is_qa_page( 'edit' ) ) {
			$post_type = $wp_query->posts[0]->post_type;
			$this->load_template( "edit-{$post_type}.php" );
		}
		
		if ( is_qa_page( 'user' ) ) {
			$wp_query->queried_object_id = (int) $wp_query->get('author');
			$wp_query->queried_object = get_userdata( $wp_query->queried_object_id );
			$wp_query->is_post_type_archive = false;
		
			$this->load_template( 'user-question.php' );
		}
		
		if ( ( is_qa_page( 'archive' ) && is_search() ) || is_qa_page( 'unanswered' ) ) {
			$this->load_template( 'archive-question.php' );
		}
		
		// Redirect template loading to archive-question.php rather than to archive.php
		if ( is_qa_page( 'tag' ) || is_qa_page( 'category' ) ) {
			$wp_query->set( 'post_type', 'question' );
		}
	}
	
	public function is_page_allowed() {
		if ( is_dln_page( 'archive' ) ) {
			$cap = 'read_questions';
		} else if ( is_dln_page( 'ask' ) ) {
			$cap = 'publish_questions';
		} else {
			return true;
		}
		
		if ( ! is_user_logged_in() ) {
			return $this->visitor_has_cap( $cap );
		} else {
			return current_user_can( $cap );
		}
	}
	
	/**
	 * Check visitor's capability for a given cap
	 */
	function visitor_has_cap( $cap ) {
		$v = get_role( 'visitor' );
		if ( !$v || !is_object( $v ) )
			return false;
	
		return $v->has_cap( $cap );
	}
	
}

$_dln_core = new DLN_Core();