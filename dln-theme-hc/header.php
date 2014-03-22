<?php ?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themepixels.com/demo/webpage/bracket/ by HTTrack Website Copier/3.x [XR&CO'2013], Tue, 18 Feb 2014 13:50:16 GMT -->
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="images/favicon.png" type="image/png">

  <title><?php wp_title( '|', true, 'right' ); ?></title>

  <link href="<?php echo get_template_directory_uri(); ?>/assets/css/style.default.css" rel="stylesheet">
  <link href="<?php echo get_template_directory_uri(); ?>/assets/css/jquery.datatables.css" rel="stylesheet">
  <link href="<?php echo get_template_directory_uri(); ?>/assets/css/dln-news.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
  
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery-1.10.2.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery-migrate-1.2.1.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/bootstrap.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/modernizr.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.sparkline.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/toggles.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.cookies.js"></script>
	
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/flot/flot.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/flot/flot.resize.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/morris.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/raphael-2.1.0.min.js"></script>
	
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.datatables.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/chosen.jquery.min.js"></script>
	
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/custom.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/dashboard.js"></script>
</head>
<body <?php body_class() ?>>
	<!-- Preloader -->

	<?php 
	$notifications = dln_get_notifications_objects();
	?>
	<div class="mainpanel">
		<div class="headerbar">
			<?php get_search_form() ?>
			<div class="header-right">
				<ul class="headermenu">
					<li>
						<div class="btn-group">
							<button class="btn btn-default dropdown-toggle tp-icon"
								data-toggle="dropdown">
								<i class="glyphicon glyphicon-user"></i>
								<?php if ( $notifications['friends']['nof_count'] ): ?>
								<span class="badge"><?php echo $notifications['friends']['nof_count'] ?>
								</span>
								<?php endif; ?>
							</button>
							<div class="dropdown-menu dropdown-menu-head pull-right">
								<h5 class="title">
									<?php __( 'Friend resquest', 'dln-theme-hc' ) ?>
								</h5>
								<ul class="dropdown-list user-list">
									<?php if ( $notifications['friends']['nof_arr'] ): ?>
									<?php 
									foreach ( $notifications['friends']['nof_arr'] as $nof ) {
										if ( $nof ) :
										$user       = get_userdata( $nof->item_id );
										$link       = bp_core_get_user_domain( $nof->item_id );
										$avatar     = get_avatar( $nof->item_id, '36', '', $user->display_name );
										$since_time = bp_core_time_since( $nof->date_notified );
										?>
										<li class="new">
											<div class="thumb">
												<a href="<?php echo $link ?>"><?php echo $avatar ?> </a>
											</div>
											<div class="desc">
												<h5>
													<a href="<?php echo $link ?>"><?php echo $user->display_name ?> ( @<?php echo $user->user_login ?> )</a> <span class="badge badge-success"><?php echo $since_time ?></span>
												</h5>
											</div>
										</li>
										<?php
										endif;
									}
									?>
									
									<?php endif; ?>

									<li class="new"><a href="<?php echo bp_loggedin_user_domain() . bp_get_friends_slug() ?>">See All Users</a></li>
								</ul>
							</div>
						</div>
					</li>
					<li>
						<div class="btn-group">
							<button class="btn btn-default dropdown-toggle tp-icon"
								data-toggle="dropdown">
								<i class="glyphicon glyphicon-envelope"></i> 
								<?php if ( $notifications['messages']['nof_count'] ): ?>
									<span class="badge"><?php echo $notifications['messages']['nof_count'] ?></span>
								<?php endif; ?>
							</button>
							<div class="dropdown-menu dropdown-menu-head pull-right">
								<h5 class="title"><?php __( 'Messages', 'dln-theme-hc' ) ?></h5>
								<ul class="dropdown-list gen-list">
									<?php $count = 0; ?>
									<?php if ( bp_has_message_threads() ) : ?>
									<?php while ( bp_message_threads() ) : bp_message_thread(); ?>
									<?php $count++; ?>
									<?php global $messages_template;?>
									<li class="new">
										<a href="<?php bp_message_thread_view_link(); ?>"> 
											<span class="thumb"> <?php bp_message_thread_avatar() ?> </span> 
											<span class="desc"> <span class="name"><?php echo bp_core_get_user_displayname( $messages_template->thread->last_sender_id ) ?> <span class="badge badge-success"><?php echo bp_message_thread_last_post_date() ?></span></span>
											<span class="msg"><?php bp_message_thread_subject(); ?></span>
										</span>
									</a>
									</li>
									<?php if ( $count == 5 ) break; ?>
									<?php endwhile; ?>
									<?php endif; ?>
									<li class="new"><a href="<?php echo bp_loggedin_user_domain() . bp_get_messages_slug() ?>">Read All Messages</a></li>
								</ul>
							</div>
						</div>
					</li>
					<li>
						<div class="btn-group">
							<button class="btn btn-default dropdown-toggle tp-icon"
								data-toggle="dropdown">
								<i class="glyphicon glyphicon-globe"></i> <span class="badge"><?php echo bp_notifications_get_unread_notification_count() ?></span>
							</button>
							<div class="dropdown-menu dropdown-menu-head pull-right">
								<h5 class="title">You Have <?php echo bp_notifications_get_unread_notification_count() ?> New Notifications</h5>
								<ul class="dropdown-list gen-list">
								
									<?php if ( bp_has_notifications() ) :?>
									<?php while ( bp_the_notifications() ) : bp_the_notification(); ?>
									<?php 
									$item_id    = bp_get_the_notification_item_id();
									$user       = get_userdata( $item_id );
									$link       = bp_core_get_user_domain( $item_id );
									$avatar     = get_avatar( $item_id, '36', '', $user->display_name );
									?>
									<li class="new">
										<a href="<?php bp_the_notification_action_links() ?>"> 
											<span class="thumb">
												
											</span> 
											<span class="desc">
												<span class="name"><?php echo $user->display_name ?> <span class="badge badge-success"><?php bp_the_notification_time_since() ?></span></span> 
												<span class="msg"><?php bp_the_notification_description() ?></span>
											</span>
										</a>
									</li>
									
									<?php endwhile ?>
									<?php endif ?>
									
									<li class="new"><a href="#">See All Notifications</a></li>
								</ul>
							</div>
						</div>
					</li>
					<li>
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle"
								data-toggle="dropdown">
								<img src="images/photos/loggeduser.png" alt="" /> John Doe <span
									class="caret"></span>
							</button>
							<ul class="dropdown-menu dropdown-menu-usermenu pull-right">
								<li><a href="profile.html"><i class="glyphicon glyphicon-user"></i>
										My Profile</a></li>
								<li><a href="#"><i class="glyphicon glyphicon-cog"></i> Account
										Settings</a></li>
								<li><a href="#"><i class="glyphicon glyphicon-question-sign"></i>
										Help</a></li>
								<li><a href="signin.html"><i class="glyphicon glyphicon-log-out"></i>
										Log Out</a></li>
							</ul>
						</div>
					</li>
					<li>
						<button id="chatview" class="btn btn-default tp-icon chat-icon">
							<i class="glyphicon glyphicon-comment"></i>
						</button>
					</li>
				</ul>
			</div>
			<!-- header-right -->
		</div>
	</div>
</body>