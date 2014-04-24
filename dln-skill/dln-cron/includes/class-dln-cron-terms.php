<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Cron_Terms {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		//add_action( 'init', array( $this, 'init' ) );
		add_action( 'dln_source_edit_form_fields', array( $this, 'edit_dln_source' ), 10, 2 );
		add_action( 'edited_dln_source', array( $this, 'save_dln_source' ), 10, 2 );
	}
	
	public function edit_dln_source( $tag, $taxonomy ) {
		$term_id = $tag->term_id;
		
		if ( $term_id ) {
			// Update
			$source = self::select_source( $term_id );
			$hash   = isset( $soure['hash'] ) ? $soure['hash'] : '';
			$link   = isset( $source['link'] ) ? $source['link'] : '';
			$crawl  = isset( $source['crawl'] ) ? $source['crawl'] : '';
		}
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="dln_source_hash"><?php echo __( 'Hash Value', DLN_SKILL ) ?></label></th>
			<td>
				<input type="text" name="dln_source_hash" id="dln_source_hash" value="<?php echo $hash; ?>"/><br />
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="dln_source_link"><?php echo __( 'Link', DLN_SKILL ) ?></label></th>
			<td>
				<input type="text" name="dln_source_link" id="dln_source_link" value="<?php echo $hash; ?>"/><br />
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="dln_source_crawl"><?php echo __( 'Crawl Count', DLN_SKILL ) ?></label></th>
			<td>
				<input type="text" name="dln_source_crawl" id="dln_source_crawl" value="<?php echo $hash; ?>"/><br />
			</td>
		</tr>
		<?php
	}
	
	public function save_dln_source( $term_id, $tt_id ) {
		if ( ! $term_id ) return;
		
		if ( isset( $_POST['dln_source_hash'] ) ) {
			$data['hash'] = $_POST['dln_source_hash'];
		}
		if ( isset( $_POST['dln_source_link'] ) ) {
			$data['link'] = $_POST['dln_source_link'];
		}
		if ( isset( $_POST['dln_source_crawl'] ) ) {
			$data['crawl'] = $_POST['dln_source_crawl'];
		}
		
		self::insert_source( $term_id, $data );
	}
	
	public static function insert_source( $term_id, $data ) {
		global $wpdb;
		
		
	}
	
	public static function select_source( $term_id ) {
		global $wpdb;
		if ( ! $term_id )
			return false;
		
		$sql = $wpdb->prepare( "SELECT * FROM {$wpdb->dln_source_link} AS link WHERE link.term_id = %d", $term_id );
		$return = $wpdb->get_results( $sql, ARRAY_A );
		return $return;
	}
	
}

DLN_Cron_Terms::get_instance();