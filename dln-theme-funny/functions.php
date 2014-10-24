<?php
// This theme uses wp_nav_menu() in one location.
register_nav_menu( 'primary', __( 'Navigation Menu', 'twentythirteen' ) );

add_filter( 'wp_nav_menu_objects', 'dln_add_class_nav_menu', 10 , 2);
function dln_add_class_nav_menu( $sorted_menu_items, $args ) {
	if ( ! empty( $sorted_menu_items ) && is_array( $sorted_menu_items ) ) {
		foreach ( $sorted_menu_items as $item ) {
			if ( ! empty( $item->classes ) && ( in_array( 'current-menu-item', $item->classes ) || in_array( 'current_page_item', $item->classes ) ) ) {
				$item->classes[] = 'open';
				break;
			}
		}
	}
	
	return $sorted_menu_items;
}

add_shortcode( 'dln_list_source', 'shortcode_dln_list_source' );
function shortcode_dln_list_source() {
	global $wpdb;
	
	$sql     = "SELECT post_id, url, title, image, share FROM {$wpdb->dln_news_link} WHERE 1 = 1 ORDER BY share DESC LIMIT 0, 20 ";
	$results = $wpdb->get_results( $sql );
	
	// Get comments
	$ids = array();
	foreach ( $results as $i => $item ) {
		if ( $item->post_id ) {
			$ids[] = $item->post_id;
		}
	}
	$where    = implode( "','", $ids );
	$sql      = "SELECT * FROM {$wpdb->dln_news_top_comments} WHERE post_id IN ('{$where}') ORDER BY likes DESC";
	$comments = $wpdb->get_results( $sql );

	$pattern = array( '\r\n','\n\r','\n','\r' );
	
	foreach ( $results as $i => $item ) {
		?>
		<div class="post post-loop">
		<h2 class="post-title">
			<a title="<?php echo esc_html( $item->title ) ?>" href="javascript:void(0)"><?php echo esc_html( $item->title ) ?></a>
		</h2>
		<hr />
		<div class="post-entry">
			<div class="post-media">
				<img class="wp-post-image" title="<?php echo esc_attr( $item->title ) ?>" src="<?php echo esc_attr( $item->image ) ?>" />
			</div>
		</div>
		<div class="post-categories"></div>
		<div class="post-meta">
			<div class="post-author">
				<a class="thumb pull-left" href="javascript:void(0)"> <img
					class="avatar" width="22" height="22" src="#" />
				</a> <a title="DinhLN" href="javascript:void(0)"></a> <br /> <span
					class="description hidden-xs">DinhLN</span>
				<div class="clear"></div>
			</div>
			<hr class="dln-hr" />
			<div class="post-date pull-left">
				<div class="post-date-day pull-left">20</div>
				th 3 <br /> <span class="post-date-year">2014</span>
			</div>
			<hr />
			<div class="post-feedback pull-left">
				<i class="fa fa-eye icon-big"></i><?php echo esc_html( $item->share ) ?>
			</div>
			<hr />
			<a class="post-feedback pull-left" href="javascript:void(0)"> <i
				class="fa fa-comment icon-big"></i>1
			</a>
			<hr class="dln-hr" />

			<?php foreach ( $comments as $j => $comment ) : ?>
			<?php if ( $comment->post_id == $item->post_id ) : ?>
			<a class="list-item hidden-xs" href="<?php echo esc_attr( $item->url )?>" target="_blank">
				<div class="media">
					<div class="pull-left">
						<img class="media-object img-circle thumb32" alt="<?php echo esc_attr( $comment->user_name )?>" src="https://graph.facebook.com/<?php echo esc_attr( $comment->user_id ) ?>/picture">
					</div>
					<div class="media-body clearfix">
						<small class="pull-right"><em class="fa fa-thumbs-o-up"></em> <?php echo esc_html( $comment->likes )?></small>
						<strong class="media-heading text-primary"><?php echo esc_html( $comment->user_name )?></strong>
						<p class="mb-sm">
							<small><?php echo str_replace( $pattern, '<br />', $comment->message ) ?></small>
						</p>
					</div>
				</div>
			</a>
			<?php endif ?>
			<?php endforeach ?>

			<hr class="dln-hr" />

			<div class="post-share slide-top">
				<button class="mb-sm btn btn-primary" type="button">
					<em class="fa fa-facebook"></em>
				</button>
				<button class="mb-sm btn btn-danger" type="button">
					<em class="fa fa-google-plus"></em>
				</button>
				<button class="mb-sm btn btn-info" type="button">
					<em class="fa fa fa-twitter"></em>
				</button>
			</div>
		</div>
	</div>
		<?php
	}
}