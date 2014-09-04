<?php

if ( ! defined( 'WPINC' ) ) { die; }

if ( ! class_exists( 'DLN_MyCred_Admin' ) ) :

class DLN_MyCred_Admin {
	
	public static $instance;
	
	private static $ctype = 'dln_money';
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		add_action( 'mycred_edit_profile', array( $this, 'mycred_edit_profile' ), 10, 2 );
		add_action( 'admin_init', array( $this, 'mycred_edit_profile_actions' ) );
	}
	
	public function mycred_edit_profile_actions() {
		global $wpdb;
		
		// Check nonce value
		$nonce = isset( $_POST['dln_hire']['token'] ) ? $_POST['dln_hire']['token'] : '';
		if ( ! wp_verify_nonce( $nonce, 'dln-adjust-hire-day' ) )
			return;
		
		extract( $_POST['dln_hire'] );
		
		$redirect_url = admin_url( 'users.php?page=mycred-edit-balance&user_id=' . $user_id . '&ctype=' . self::$ctype );
		
		if ( isset( $_POST['dln_add_hire_day'] ) && isset( $_POST['dln_add_hire_day'] ) ) {
			if( $user_id && $cost && $start_time && $day_limit ) {
				$cost      = $cost * 1000;
				$day_limit = (int) $day_limit;
				$days      = strtotime( $start_time ) + $day_limit * 24 * 60 * 60;
				$user      = get_current_user();
				$mycred    = mycred( self::$ctype );
				
				$args = array(
					'user_id'    => $user_id,
					'start_time' => date( 'Y-m-d H:i:s', strtotime( $start_time ) ),
					'day_limit'  => $day_limit,
					'end_time'   => date( 'Y-m-d H:i:s', $days ),
					'cost'       => $cost,
					'active'     => 1,
					'type'       => 'silver'
				);
				$data = serialize( $args );
				$log = '';
			
				if ( ! empty( $hire_day_id ) ) {
					$result = $wpdb->update( $wpdb->dln_hire, $args, array( 'id' => $hire_day_id ) );
				} else {
					$result = $wpdb->insert( $wpdb->dln_hire, $args );
					$log    = sprintf( __( 'User %s inserted silver for hire id %d', DLN_ABE ), $user, $result );
				}
				
				if ( ! is_wp_error( $result ) ) {
					if ( $log ) {
						// Run
						$mycred->add_creds(
								'manual',
								$user_id,
								0 - $cost,
								$log,
								get_current_user_id(),
								$data,
								self::$ctype
						);
					}
					
					wp_redirect( $redirect_url );
					exit;
				} else {
					var_dump( $result );
				}
			}
		}
		
		if ( ! current_user_can( 'edit_users' ) ) {
			return false;
		}
		
		if ( isset( $_POST['dln_delete_hire_day'] ) && isset( $_POST['dln_delete_hire_day'] ) ) {
			if ( isset( $_POST['dln_action'] ) && $_POST['dln_action'] == 'delete' ) {
				$hire_day_id = ( isset( $_POST['hire_day_id'] ) ) ? (int) $_POST['hire_day_id'] : '';
				if ( ! empty( $hire_day_id ) ) {
					$result = $wpdb->delete( $wpdb->dln_hire, array( 'id' => $hire_day_id ) );
					if ( ! is_wp_error( $result ) ) {
						wp_redirect( $redirect_url );
						exit;
					} else {
						var_dump( $result );
					}
				}
			}
		}
	}
	
	public function mycred_edit_profile( $user, $type ) {
		if ( ! $user || $type != self::$ctype )
			return;
		
		global $wpdb;
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_style('jquery-ui-datepicker');
		
		if ( ! isset( $_GET['ctype'] ) )
			$type = self::$ctype;
		else
			$type = sanitize_key( $_GET['ctype'] );
		
		$mycred = mycred( $type );
		
		$hire_day_id = ( isset( $_GET['hire_day_id'] ) ) ? $_GET['hire_day_id'] : 0;
		if ( $hire_day_id ) {
			$sql  = $wpdb->prepare( "SELECT * FROM {$wpdb->dln_hire} as hday WHERE hday.id = %s AND hday.type = %s", esc_sql( $hire_day_id ), esc_sql( 'silver' ) );
			$item = $wpdb->get_row( $sql );
			if ( ! is_wp_error( $item ) ) {
				$cost       = $item->cost / 1000;
				$start_time = $item->start_time;
				$day_limit  = $item->day_limit;
			}
		} else {
			$cost       = 0;
			$start_time = 0;
			$day_limit  = 0;
		}
		
		$day_limits = DLN_Helper_Hire::get_hire_days();
		
		$next = ( ! empty( $_GET['next'] ) ) ? $_GET['next'] : 0;
		
		// Get hire days for user
		$sql        = $wpdb->prepare( "SELECT * FROM {$wpdb->dln_hire} as hday WHERE hday.user_id = %d AND hday.type = %s ORDER BY hday.id DESC LIMIT %d, 10", $user->ID, esc_sql( 'silver' ), $next );
		$items      = $wpdb->get_results( $sql );
		$admin_url  = admin_url();
		$edit_url   = $admin_url . 'users.php?page=mycred-edit-balance&user_id=' . $user->ID . '&ctype=' . self::$ctype . '&hire_day_id=';
		
		$total_cost_paid = '';
		$sql  = $wpdb->prepare( "SELECT SUM(hire.cost_paid) as total FROM {$wpdb->dln_hire} as hire WHERE hire.type = %s", esc_sql( 'silver' ) );
		$item = $wpdb->get_row( $sql );
		if ( ! is_wp_error( $item ) ) {
			$total_cost_paid = $item->total;
		}
		?>
<style>
div#edit-balance-page table.table td {
    font-size: 12px;
    line-height: 48px;
    width: 10%;
}		
</style>
<form id="dln-edit-profile" action="" method="post">
	<div class="clear clearfix"></div>
	<h3><?php _e( 'Hire Day', DLN_ABE ) ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="dln-start-time"><?php _e( 'Start Time', DLN_ABE ); ?></label></th>
			<td>
				<input type="text" name="dln_hire[start_time]" id="dln-start-time" value="<?php echo $start_time ?>" class="datetime-picker" />
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="dln-cost-field"><?php _e( 'Cost', DLN_ABE ) ?></label></th>
			<td id="dln-cost-field">
				<input type="number" name="dln_hire[cost]" id="dln-cost" value="<?php echo $cost ?>" size="5" style="text-align:right" />
				<span>000</span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="dln-day-limit"><?php _e( 'Day Limit', DLN_ABE ); ?></label></th>
			<td>
				<input type="number" name="dln_hire[day_limit]" id="dln-day-limit" value="<?php echo $day_limit ?>" size="5" style="text-align:right" />
				<span><?php _e( 'days', DLN_ABE )?></span>
				<br /><br />
				<?php $button_title = ( $hire_day_id ) ? __( 'Update', DLN_ABE ) : __( 'Add hire', DLN_ABE ) ?>
				<?php submit_button( $button_title, 'primary medium', 'dln_add_hire_day', false ); ?>
				<?php if ( $hire_day_id ) : ?>
					<?php submit_button( __( 'Delete', DLN_ABE ), 'medium', 'dln_delete_hire_day', false ); ?>
					<input type="hidden" name="dln_action" value="delete" />
					<input type="hidden" name="hire_day_id" value="<?php echo $hire_day_id ?>" />
				<?php endif ?>
				<input type="hidden" name="dln_hire[ctype]" value="<?php echo $type; ?>" />
				<input type="hidden" name="dln_hire[user_id]" value="<?php echo $user->ID; ?>" />
				<input type="hidden" name="dln_hire[token]" value="<?php echo wp_create_nonce( 'dln-adjust-hire-day' ); ?>" />
				<input type="hidden" name="dln_hire[hire_day_id]" value="<?php echo $hire_day_id ?>" />
			</td>
		</tr>
	</table>
	
	<?php if ( ! is_wp_error( $items ) ) : ?>
	<table class="table">
		<thead>
			<tr>
				<th><?php _e( 'Actions', DLN_ABE ) ?></th>
				<th><?php _e( 'Start Time', DLN_ABE ) ?></th>
				<th><?php _e( 'Day Limit', DLN_ABE ) ?></th>
				<th><?php _e( 'End Time', DLN_ABE ) ?></th>
				<th><?php _e( 'Cost', DLN_ABE ) ?></th>
				<th><?php _e( 'Cost Paid', DLN_ABE ) ?></th>
				<th><?php _e( 'Active', DLN_ABE ) ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $items as $i => $item ) {?>
			<tr>
				<td>
					<a href="<?php echo $edit_url . $item->id ?>"><?php _e( 'Edit', DLN_ABE ) ?></a>
				</td>
				<td><?php echo date( 'd/m/Y', strtotime( $item->start_time ) ) ?></td>
				<td><?php echo $item->day_limit ?></td>
				<td><?php echo date( 'd/m/Y', strtotime( $item->end_time ) ) ?></td>
				<td><?php echo number_format( $item->cost ) ?></td>
				<td><?php echo number_format( $item->cost_paid ) ?></td>
				<td><?php echo $item->active ?></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
	<?php endif ?>
	<span><b><?php _e( 'Total Cost Paid:', DLN_ABE ) ?></b></span>&nbsp;<?php echo( number_format( $total_cost_paid ) )?>
</form>
<script type="text/javascript">
(function ($) {
	$(document).ready(function () {
		$('.datetime-picker').datepicker({
			'changeMonth' : true,
			'changeYear' : true
		});

		$('#dln_delete_hire_day').on('click', function (e) {
			var result = confirm( '<?php _e( 'Are you want to delete this hire?', DLN_ABE ) ?>' );
			
			if ( result != true ) {
				e.preventDefault();
				return false;
			}
		});
	});
})(jQuery);
</script>
	<?php
	}
	
}

DLN_MyCred_Admin::get_instance();

endif;