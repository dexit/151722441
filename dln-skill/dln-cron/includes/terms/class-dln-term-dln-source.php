<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Term_Source {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'dln_source_edit_form_fields', array( $this, 'edit_dln_source' ), 10, 2 );
		add_action( 'edited_dln_source', array( $this, 'save_dln_source' ), 10, 2 );
		add_action( 'dln_source_add_form_fields', array( $this, 'edit_quick_dln_source' ), 10, 1 );
		add_action( 'created_dln_source', array( $this, 'save_quick_dln_source' ), 10, 2 );
		
		add_filter( 'manage_edit-dln_source_columns', array( $this, 'column_header_dln_source' ), 10, 1 );
		add_filter( 'manage_dln_source_custom_column', array( $this, 'column_prepare_folder_display' ), 10, 3 );
	}
	
	public function init() {
		if ( ! is_admin() ) 
			return false;
		// Load assets
		wp_enqueue_script( 'dln-select2-js', DLN_SKILL_PLUGIN_URL . '/assets/3rd-party/select2/select2.min.js', array( 'jquery' ), '3.4.8', true );
		wp_enqueue_script( 'dln-select2-locale-js', DLN_SKILL_PLUGIN_URL . '/assets/3rd-party/select2/select2_locale_vi.js', array( 'jquery', 'dln-select2-js' ), '3.4.8', true );
		wp_enqueue_script( 'dln-term-admin-js', DLN_SKILL_PLUGIN_URL . '/dln-cron/assets/js/term-admin.js', array( 'jquery' ), '1.0.0', true );
		
		wp_enqueue_style( 'dln-select2-css', DLN_SKILL_PLUGIN_URL . '/assets/3rd-party/select2/select2.css', null, '3.4.8' );
		wp_enqueue_style( 'dln-select2-bootstrap-css', DLN_SKILL_PLUGIN_URL . '/assets/3rd-party/select2/select2-bootstrap.css', null, '3.4.8' );
		wp_enqueue_style( 'dln-cron-admin-css', DLN_SKILL_PLUGIN_URL . '/dln-cron/assets/css/dln-cron-admin.css', null, '1.0.0' );
	}
	
	public function column_prepare_folder_display( $empty = '', $custom_column, $term_id ) {
		if ( $custom_column != 'folder_name' && $custom_column != 'priority'
			&& $custom_column != 'enable' ) return '';
		if ( ! $term_id ) return '';
		
		// Get source link 
		$source = self::select_source( $term_id );
		if ( ! $source ) return '';
		
		switch ( $custom_column ) {
			case 'folder_name':
				$folders = DLN_Term_Helper::select_folder_name( $term_id );
				if ( ! $folders ) return '';
				$html = '';
				foreach ( $folders as $i => $folder ) {
					if ( isset( $folder['folder_name'] ) ) {
						$html .= $folder['folder_name'] . ', ';
					}
				}
				break;
			case 'priority':
				$html = isset( $source['priority'] ) ? $source['priority'] : '';
				break;
			case 'enable':
				$html = isset( $source['enable'] ) ? $source['enable'] : '';
				break;
		}
		return esc_html( $html );
	}
	
	public function column_header_dln_source( $columns ) {
		$columns['folder_name'] = __('Folder', DLN_SKILL );
		$columns['priority']    = __('Priority', DLN_SKILL );
		$columns['enable']      = __('Enable', DLN_SKILL);
		return $columns;
	}
	
	public function save_quick_dln_source( $term_id, $tt_id ) {
		$this->save_dln_source( $term_id, $tt_id );
	}
	
	public function save_dln_source( $term_id, $tt_id ) {
		if ( ! $term_id ) return;
	
		$data = array();
		if ( isset( $_POST['dln_source_link'] ) ) {
			$data['link'] = $_POST['dln_source_link'];
			if ( isset( $_POST['dln_source_hash'] ) ) {
				if ( empty( $_POST['dln_source_hash'] ) ) {
					$data['hash'] = DLN_Cron_Helper::generate_hash( $data['link'] );
				} else {
					$data['hash'] = $_POST['dln_source_hash'];
				}
			}
		}
		
		if ( isset( $_POST['dln_source_priority'] ) ) {
			$data['priority'] = $_POST['dln_source_priority'];
		}
		
		if ( isset( $_POST['dln_source_crawl'] ) ) {
			$data['crawl'] = $_POST['dln_source_crawl'];
		}
		
		if ( isset( $_POST['dln_source_enable'] ) ) {
			$data['enable'] = $_POST['dln_source_enable'];
		}
	
		$return = self::insert_source( $term_id, $data );
	
		if ( isset( $_POST['dln_source_folder'] ) ) {
			self::insert_source_folder( $term_id, $_POST['dln_source_folder'] );
		}
	}
	
	public function edit_quick_dln_source( $taxonomy ) {
		$this->edit_form_content();
	}
	
	public function edit_dln_source( $tag, $taxonomy ) {
		$term_id = $tag->term_id;
	
		$this->edit_form_content( $term_id );
		return;
	}

	private static function insert_source_folder( $source_id = '', $folder_id = '' ) {
		global $wpdb;
		if ( empty( $source_id ) || empty( $folder_id ) )
			return '';
		
		$return = false;
		$source = DLN_Term_Helper::select_source_folder( $source_id );
		if ( isset( $source['folder_id'] ) && ! empty( $source['folder_id'] ) ) {
			$return = $wpdb->update( $wpdb->dln_source_folder, $data, array( 'source_id' => $source_id, 'folder_id' => $folder_id ) );
		} else {
			$return = $wpdb->insert( $wpdb->dln_source_folder, array( 'source_id' => $source_id, 'folder_id' => $folder_id ) );
		}
		return $return;
	}
	
	private static function insert_source( $term_id, $data ) {
		global $wpdb;
	
		$return = false;
		if ( ! empty( $data ) && ! empty( $term_id ) ) {
			$source = self::select_source( $term_id );
				
			if( $source ) {
				$return = $wpdb->update( $wpdb->dln_source_link, $data, array( 'term_id' => $term_id ) );
			} else {
				$data['term_id'] = $term_id;
				$return = $wpdb->insert( $wpdb->dln_source_link, $data );
			}
		}
		return $return;
	}
	
	private static function select_source( $term_id ) {
		global $wpdb;
		if ( ! $term_id )
			return false;
	
		$sql    = $wpdb->prepare( "SELECT * FROM {$wpdb->dln_source_link} AS link WHERE link.term_id = %d", (int) esc_sql( $term_id ) );
		$return = $wpdb->get_row( $sql, ARRAY_A );
	
		return $return;
	}
	
	private function edit_form_content( $term_id = '' ) {
		// Update
		$source          = self::select_source( $term_id );
		$hash            = isset( $source['hash'] ) ? $source['hash'] : '';
		$link            = isset( $source['link'] ) ? $source['link'] : '';
		$priority        = isset( $source['priority'] ) ? $source['priority'] : '10';
		$crawl           = isset( $source['crawl'] ) ? $source['crawl'] : '0';
		$enable          = isset( $source['enable'] ) ? $source['enable'] : '1'; 
		$folder_selected = DLN_Term_Helper::get_selected_folder( $term_id );
		$folders         = DLN_Term_Helper::get_term_folder();
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="dln_source_link"><?php echo __( 'Link', DLN_SKILL ) ?></label></th>
			<td>
				<input type="text" name="dln_source_link" id="dln_source_link" size="40" value="<?php echo $link ?>"/><br />
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="dln_source_folder"><?php echo __( 'Folder', DLN_SKILL ) ?></label></th>
			<td>
				<select name="dln_source_folder" id="dln_source_folder" class="select2 input-medium">
					<option value="0"><?php echo __( '(None)', DLN_SKILL )?></option>
					<?php foreach ( $folders as $i => $folder ) : ?>
					<?php if ( ! empty( $folder ) ) :?>
					<?php if ( ! empty( $folder_selected ) && $folder_selected == $folder->term_id ) :?>
					<option value="<?php echo $folder->term_id ?>" selected="selected"><?php echo $folder->name ?> (<?php echo $folder->count_source ?>)</option>
					<?php else : ?>
					<?php $folder->count_source = isset( $folder->count_source ) ? $folder->count_source : 0 ?>
					<option value="<?php echo $folder->term_id ?>"><?php echo $folder->name ?> (<?php echo $folder->count_source ?>)</option>
					<?php endif ?>
					<?php endif ?>
					<?php endforeach ?>
				</select>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="dln_source_hash"><?php echo __( 'Hash Value', DLN_SKILL ) ?></label></th>
			<td>
				<input type="text" name="dln_source_hash" id="dln_source_hash" size="40" value="<?php echo $hash ?>"/><br />
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="dln_source_priority"><?php echo __( 'Priority', DLN_SKILL ) ?></label></th>
			<td>
				<input type="number" name="dln_source_priority" id="dln_source_priority" size="40" value="<?php echo $priority ?>" /><br /> 
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="dln_source_crawl"><?php echo __( 'Crawl Count', DLN_SKILL ) ?></label></th>
			<td>
				<input type="text" name="dln_source_crawl" id="dln_source_crawl" size="40" readonly="readonly" value="<?php echo $crawl ?>"/><br />
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="dln_source_enable"><?php echo __( 'Enable', DLN_SKILL ) ?></label></th>
			<td>
				<input type="text" name="dln_source_enable" id="dln_source_enable" size="40" value="<?php echo $enable ?>"/><br />
			</td>
		</tr>
		<p />
		<?php
		return;
	}
}

DLN_Term_Source::get_instance();