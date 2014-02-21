<?php

if ( ! defined( 'WPINC' ) ) { die; }
 
require_once( DLN_NEWS_PATH . '/includes/libraries/simple_html_dom.php' );

class DLN_News_Site {
	
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
	
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		// Load plugin text domain
	}
	
	private function curl_get_content( $url = '' ) {
		if ( ! $url )
			return;
		
		$ch  = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_COOKIEJAR, '/cookie.txt');
		curl_setopt($ch, CURLOPT_COOKIEFILE, '/cookie.txt');
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.13) Gecko/20101206 Ubuntu/10.10 (maverick) Firefox/3.6.13');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		
		$page = curl_exec($ch);
		
		return $page;
	}
	
	public function fetchURL( $url = '' ) {
		if ( empty( $url ) )
			return;
		
		/*$html = file_get_html( $url );
		
		foreach( $html->find('p') as $p ) {
			var_dump($p);
		}*/
		$url = htmlspecialchars( $url );
		$dom = new DOMDocument('1.0', 'utf-8');
		$content = $this->curl_get_content( $url );
		@$dom->loadHTML( $content );
		$xpath = new DOMXPath( $dom );
		$nodes = $xpath->query( "//a[starts-with(@id,'thread_title')]" );
		//foreach ( $nodes as $p ) {
		//	var_dump( $p->nodeValue );
		//}
	}
	
	public static function dln_site_metabox_edit( $tag, $taxonomy ) {
		var_dump($tag, $taxonomy);
		?>
		<h3><?php __( 'Site Meta Data', DLN_NEWS_SLUG ) ?></h3>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="parent"><?php __('Parent', DLN_News_SLUG); ?></label></th>
			<td>
				<?php wp_dropdown_categories(array('hide_empty' => 0, 'hide_if_empty' => false, 'name' => 'parent', 'orderby' => 'name', 'taxonomy' => $taxonomy, 'selected' => $tag->parent, 'exclude_tree' => $tag->term_id, 'hierarchical' => true, 'show_option_none' => __('None'))); ?>
				<?php if ( 'category' == $taxonomy ) : ?>
				<p class="description"><?php _e('Categories, unlike tags, can have a hierarchy. You might have a Jazz category, and under that have children categories for Bebop and Big Band. Totally optional.'); ?></p>
				<?php endif; ?>
			</td>
		</tr>
		<?php
	}
	
}