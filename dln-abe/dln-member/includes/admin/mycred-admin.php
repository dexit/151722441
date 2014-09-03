<?php

if ( ! defined( 'WPINC' ) ) { die; }

if ( ! class_exists( 'DLN_MyCred_Admin' ) ) :

class DLN_MyCred_Admin {
	
	public static $instance;
	
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
		// Check nonce value
		$nonce = isset( $_POST['dln_hire_day']['token'] ) ? $_POST['dln_hire_day']['token'] : '';
		if ( ! wp_verify_nonce( $nonce, 'dln-adjust-hire-day' ) )
			return;
		
		if ( isset( $_POST['dln_add_hire_day'] ) && isset( $_POST['dln_add_hire_day'] ) ) {
			global $wpdb;
			
			extract( $_POST['dln_hire_day'] );
			
			if ( isset( $_GET['dln_action'] ) && $_GET['dln_action'] == 'delete' ) {
				if ( ! empty( $hire_day_id ) ) {
					$wpdb->delete( $wpdb->dln_hire_day, array( 'id' => $hire_day_id ) );
				}
			} else {
				if ( $user_id && $cost && $start_time && $day_limit ) {
					$cost = $cost * 1000;
				
					$args = array(
						'user_id'    => $user_id,
						'start_time' => date( 'Y-m-d H:i:s', strtotime( $start_time ) ),
						'day_limit'  => $day_limit,
						'cost'       => $cost,
						'active'     => 1,
					);
				
					if ( ! empty( $hire_day_id ) ) {
						$wpdb->update( $wpdb->dln_hire_day, $args, array( 'id' => $hire_day_id ) );
					} else {
						$wpdb->insert( $wpdb->dln_hire_day, $args );
					}
				}
			}
		}
	}
	
	public function mycred_edit_profile( $user, $type ) {
		if ( ! $user || $type != 'dln_money' )
			return;
		
		global $wpdb;
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_style('jquery-ui-datepicker');
		
		if ( ! isset( $_GET['ctype'] ) )
			$type = 'dln_money';
		else
			$type = sanitize_key( $_GET['ctype'] );
		
		$mycred = mycred( $type );
		
		$hire_day_id = ( isset( $_GET['hire_day_id'] ) ) ? $_GET['hire_day_id'] : 0;
		if ( $hire_day_id ) {
			$sql  = $wpdb->prepare( "SELECT * FROM {$wpdb->dln_hire_day} as hday WHERE hday.id = %s", esc_sql( $hire_day_id ) );
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
		
		$day_limits = array(
			'7'  => __( '7 days', DLN_ABE ),
			'30' => __( '30 days', DLN_ABE ) 
		);
		
		$next = ( ! empty( $_GET['next'] ) ) ? $_GET['next'] : 0;
		
		// Get hire days for user
		$sql       = $wpdb->prepare( "SELECT * FROM {$wpdb->dln_hire_day} as hday WHERE hday.user_id = %d ORDER BY hday.id DESC LIMIT {$next}, 10", $user->ID );
		$items     = $wpdb->get_results( $sql );
		$admin_url = admin_url();
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
				<input type="text" name="dln_hire_day[start_time]" id="dln-start-time" value="<?php echo $start_time ?>" class="datetime-picker" />
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="dln-cost-field"><?php _e( 'Cost', DLN_ABE ) ?></label></th>
			<td id="dln-cost-field">
				<input type="number" name="dln_hire_day[cost]" id="dln-cost" value="<?php echo $cost ?>" size="5" style="text-align:right" />
				<span>000</span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="dln-day-limit"><?php _e( 'Day Limit', DLN_ABE ); ?></label></th>
			<td>
				<select id="dln-day-limit" name="dln_hire_day[day_limit]">
					<option value="0"><?php _e( '--Select day--', DLN_ABE ) ?></option>
					<?php 
					foreach ( $day_limits as $value => $name ) {
						$selected = ( ! empty( $day_limit ) && $value == $day_limit ) ? 'selected="selected"' : ''; 
						echo '<option ' . $selected . ' value="' . $value . '">' . $name . '</option>';
					}
					?>
				</select>
				<br /><br />
				<?php submit_button( __( 'Add hire', DLN_ABE ), 'primary medium', 'dln_add_hire_day', false ); ?>
				<input type="hidden" name="dln_hire_day[ctype]" value="<?php echo $type; ?>" />
				<input type="hidden" name="dln_hire_day[user_id]" value="<?php echo $user->ID; ?>" />
				<input type="hidden" name="dln_hire_day[token]" value="<?php echo wp_create_nonce( 'dln-adjust-hire-day' ); ?>" />
				<input type="hidden" name="dln_hire_day[hire_day_id]" value="<?php echo $hire_day_id ?>" />
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
					<a href="<?php echo $admin_url?>users.php?page=mycred-edit-balance&user_id=<?php echo $user->ID ?>&ctype=dln_money&hire_day_id=<?php echo $item->id ?>"><?php _e( 'Edit', DLN_ABE ) ?></a>
					|
					<a href="<?php echo $admin_url?>users.php?page=mycred-edit-balance&user_id=<?php echo $user->ID ?>&ctype=dln_money&dln_action=delete&hire_day_id=<?php echo $item->id ?>"><?php _e( 'Delete', DLN_ABE ) ?></a>
				</td>
				<td><?php echo $item->start_time ?></td>
				<td><?php echo $item->day_limit ?></td>
				<td><?php echo $item->end_time ?></td>
				<td><?php echo $item->cost ?></td>
				<td><?php echo $item->cost_paid ?></td>
				<td><?php echo $item->active ?></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
	<?php endif ?>
</form>
<script type="text/javascript">
(function ($) {
	$(document).ready(function () {
		$('.datetime-picker').datepicker({
			'changeMonth' : true,
			'changeYear' : true
		});
	});
})(jQuery);
</script>
	<?php
	}
	
}

DLN_MyCred_Admin::get_instance();

endif;