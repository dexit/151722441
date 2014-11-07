<?php
if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

class DLN_Helper_Premium {
	
	private static $instance;
	
	public static function get_instance() {
		if( !self::$instance instanceof self ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	public function __construct() {
		osc_register_script( 'admin-users-premium-js', DLN_CLF_PLUGIN_DIR . 'assets/js/admin-user-premium.js');
	}
	
	public function init_admin_menu() {
		osc_add_admin_submenu_page( 'users', __( 'Users Premium', DLN_CLF ), osc_admin_render_plugin_url(DLN_CLF_PLUGIN_DIR . 'views/admin/premium-user.php'), 'premium_plugin', 'administrator' );
	}
	
	public function admin_users_table( $user_table ) {
		if ( ! $user_table )
			return;
		
		$user_table->addColumn( 'user_premium', __( 'Premium Type', DLN_CLF ) );
		
		return $user_table;
	}
	
	public function users_processing_row( $row, $aRow ) {
		$user_id = isset( $row['pk_i_id'] ) ? $row['pk_i_id'] : '0';
		if ( $user_id ) {
			
		}
		$row['user_premium'] = '0';
		
		return $row;
	}
	
	public function users_html_modal() {
		$page = Params::getParam('page');
		if ( $page == 'users' ) {
			?>
<!-- Form edit city -->
<div id="d_add_user_premium" class="lightbox_country location has-form-actions hide">
    <div style="padding: 14px;">
        <form action="<?php echo osc_admin_base_url(true); ?>" method="post" accept-charset="utf-8" id="d_add_city_form">
            <input type="hidden" name="page" value="settings" />
            <input type="hidden" name="action" value="locations" />
            <input type="hidden" name="type" value="add_city" />
            <input type="hidden" name="country_c_parent" value="" />
            <input type="hidden" name="country_parent" value="" />
            <input type="hidden" name="region_parent" value="" />
            <input type="hidden" name="ci_manual" value="1" />
            <input type="hidden" name="city_id" id="city_id" value="" />
            <table>
                <tr>
                    <td><?php _e('City'); ?>: </td>
                    <td><input type="text" id="city" name="city" value="" /></td>
                </tr>
            </table>
            <div class="form-actions">
                <div class="wrapper">
                    <button class="btn btn-red close-dialog" ><?php _e('Cancel'); ?></button>
                    <button type="submit" class="btn btn-submit" ><?php _e('Add city'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End form add city -->
			<?php 
		}
	}
	
}