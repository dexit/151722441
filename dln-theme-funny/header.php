<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie ie6 lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="ie ie7 lt-ie9 lt-ie8"        lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="ie ie8 lt-ie9"               lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="ie ie9"                      lang="en"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-ie">
<!--<![endif]-->
<!-- Mirrored from geedmo.com/themeforest/wintermin/dashboard-sidebar2.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 15 Oct 2014 13:44:32 GMT -->
<head>
<!-- Meta-->
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png" type="image/png">
<title><?php wp_title( '|', true, 'right' ); ?></title>

<?php wp_head(); ?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/3rd-party/bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/3rd-party/fontawesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/3rd-party/csspinner/csspinner.min.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/app.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/wintermin-theme-a.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/dln-style.css" />

<script type="application/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/3rd-party/modernizr/modernizr.js"></script>
<script type="application/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/3rd-party/fastclick/fastclick.js"></script>

</head>
<body class="aside-collapsed">
	<!-- START Top Navbar-->
	<nav role="navigation" class="navbar navbar-default navbar-top navbar-fixed-top">
		<!-- START Nav wrapper-->
		<div class="nav-wrapper">
			<!-- START Left navbar-->
			<div class="container">
				<ul id="dln_nav_bar" class="nav navbar-nav">
					<li>
						<a href="#" class="navbar-brand dln-navbar-brand">
							<div class="brand-logo">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="App Logo" class="img-responsive">
							</div>
						</a>
					</li>
					<li class="dln-nav-lines">
						<!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
						<a id="dln_collapsed" href="#" data-toggle-state="aside-collapsed"
						data-persists="true" class="hidden-xs"> <em
							class="fa fa-navicon"></em>
					</a> <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
						<a href="#" data-toggle-state="aside-toggled" class="visible-xs">
							<em class="fa fa-navicon"></em>
					</a>
					</li>
					<!-- START Messages menu (dropdown-list)-->
					
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'container_class' => '', 'items_wrap' => '%3$s' ) ) ?>
					
				</ul>
				<!-- END Left navbar-->
				<!-- START Right Navbar-->
				<ul class="nav navbar-nav navbar-right">
					<!-- START User menu-->
					<li class="dropdown"><a href="#" data-toggle="dropdown"
						data-play="fadeIn" class="dropdown-toggle"> <em
							class="fa fa-tencent-weibo"></em>
					</a> <!-- START Dropdown menu-->
						<ul class="dropdown-menu">
							<li>
								<div class="p">
									<p>Overall progress</p>
									<div class="progress progress-striped progress-xs m0">
										<div role="progressbar" aria-valuenow="70" aria-valuemin="0"
											aria-valuemax="100"
											class="progress-bar progress-bar-success progress-70">
											<span class="sr-only">70% Complete</span>
										</div>
									</div>
								</div>
							</li>
							<li class="divider"></li>
							<li><a href="#">Profile</a></li>
							<li><a href="#">Settings</a></li>
							<li><a href="#">Notifications
									<div class="label label-info pull-right">5</div>
							</a></li>
							<li><a href="#">Messages
									<div class="label label-danger pull-right">10</div>
							</a></li>
							<li><a href="#">Logout</a></li>
						</ul> <!-- END Dropdown menu--></li>
					<!-- END User menu-->
				</ul>
				<!-- END Right Navbar-->
			</div>

		</div>
		<!-- END Nav wrapper-->
	</nav>
	<!-- START Main wrapper-->
	<div class="wrapper dln-wrapper container">

		<!-- END Top Navbar-->
		<!-- START aside-->
		<aside class="aside">
			<!-- START Sidebar (left)-->
			<nav class="sidebar">
				<ul class="nav">
					<!-- START Menu-->
					<li class="nav-heading">Main</li>
					<li class="active">
						<a href="#" title="Dashboard" data-toggle="collapse-next" class="has-submenu">
							<em class="fa fa-dot-circle-o"></em>
							<div class="label label-primary pull-right">10</div>
							<span class="item-text">Dashboard</span>
					</a> <!-- START SubMenu item-->
						<ul class="nav collapse in">
							<li><a href="dashboard.html" title="Default" data-toggle=""
								class="no-submenu"> <span class="item-text">Default</span>
							</a></li>
							<li><a href="dashboard-profile.html" title="User Profile"
								data-toggle="" class="no-submenu"> <span class="item-text">User
										Profile</span>
							</a></li>
							<li class="active"><a href="dashboard-sidebar2.html"
								title="Two Sidebar" data-toggle="" class="no-submenu"> <span
									class="item-text">Two Sidebar</span>
							</a></li>
						</ul> <!-- END SubMenu item-->
					</li>
				</ul>
			</nav>
			<!-- END Sidebar (left)-->
		</aside>
		<!-- End aside-->
		<section>
			<div class="main-content">
				<button type="button" class="btn btn-primary pull-right">
					<em class="fa fa-plus-circle fa-fw mr-sm"></em>Add Item
				</button>
				<h3>
					Dashboard <br> <small>Welcome user</small>
				</h3>