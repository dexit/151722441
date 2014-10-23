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
				<ul class="nav navbar-nav">
					<li><a href="dashboard.html"
						class="navbar-brand dln-navbar-brand">
							<div class="brand-logo">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="App Logo" class="img-responsive">
							</div>
					</a>
					</li>
					<li>
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
					<li class="dropdown dropdown-list"><a href="#"
						data-toggle="dropdown" data-play="fadeIn" class="dropdown-toggle">
							<em class="fa fa-envelope-o"></em>
							<div class="label label-danger">21</div>
					</a> <!-- START Dropdown menu-->
						<ul class="dropdown-menu">
							<li class="dropdown-menu-header">You have 5 new messages</li>
							<li>
								<div class="scroll-viewport">
									<!-- START list group-->
									<div class="list-group scroll-content">
										<!-- START list group item-->
										<a href="#" class="list-group-item">
											<div class="media">
												<div class="pull-left">
													<img src="<?php echo get_template_directory_uri(); ?>/assets/img/user/01.jpg" alt="Image"
														class="media-object img-circle thumb48">
												</div>
												<div class="media-body clearfix">
													<small class="pull-right">2h</small> <strong
														class="media-heading text-primary"> <span
														class="point point-success point-md"></span>Rina Carter
													</strong>
													<p class="mb-sm">
														<small>Curabitur sodales nisl eu enim suscipit eu
															faucibus dui mattis.</small>
													</p>
												</div>
											</div>
										</a>
										<!-- END list group item-->
										<!-- START list group item-->
										<a href="#" class="list-group-item">
											<div class="media">
												<div class="pull-left">
													<img src="<?php echo get_template_directory_uri(); ?>/assets/img/user/04.jpg" alt="Image"
														class="media-object img-circle thumb48">
												</div>
												<div class="media-body clearfix">
													<small class="pull-right">3h</small> <strong
														class="media-heading text-primary"> <span
														class="point point-success point-md"></span>Michael
														Reynolds
													</strong>
													<p class="mb-sm">
														<small>Curabitur sodales nisl eu enim suscipit eu
															faucibus dui mattis.</small>
													</p>
												</div>
											</div>
										</a>
										<!-- END list group item-->
										<!-- START list group item-->
										<a href="#" class="list-group-item">
											<div class="media">
												<div class="pull-left">
													<img src="<?php echo get_template_directory_uri(); ?>/assets/img/user/03.jpg" alt="Image"
														class="media-object img-circle thumb48">
												</div>
												<div class="media-body clearfix">
													<small class="pull-right">4h</small> <strong
														class="media-heading text-primary"> <span
														class="point point-danger point-md"></span>Britanny Pierce
													</strong>
													<p class="mb-sm">
														<small>Curabitur sodales nisl eu enim suscipit eu
															faucibus dui mattis.</small>
													</p>
												</div>
											</div>
										</a>
										<!-- END list group item-->
										<!-- START list group item-->
										<a href="#" class="list-group-item">
											<div class="media">
												<div class="pull-left">
													<img src="<?php echo get_template_directory_uri(); ?>/assets/img/user/05.jpg" alt="Image"
														class="media-object img-circle thumb48">
												</div>
												<div class="media-body clearfix">
													<small class="pull-right">4h</small> <strong
														class="media-heading text-primary"> <span
														class="point point-danger point-md"></span>Laura Cole
													</strong>
													<p class="mb-sm">
														<small>Curabitur sodales nisl eu enim suscipit eu
															faucibus dui mattis.</small>
													</p>
												</div>
											</div>
										</a>
										<!-- END list group item-->
										<!-- START list group item-->
										<a href="#" class="list-group-item">
											<div class="media">
												<div class="pull-left">
													<img src="<?php echo get_template_directory_uri(); ?>/assets/img/user/06.jpg" alt="Image"
														class="media-object img-circle thumb48">
												</div>
												<div class="media-body clearfix">
													<small class="pull-right">4h</small> <strong
														class="media-heading text-primary"> <span
														class="point point-danger point-md"></span>Carolyn Pretty
													</strong>
													<p class="mb-sm">
														<small>Curabitur sodales nisl eu enim suscipit eu
															faucibus dui mattis.</small>
													</p>
												</div>
											</div>
										</a>
										<!-- END list group item-->
									</div>
									<!-- END list group-->
								</div>
							</li>
							<!-- START dropdown footer-->
							<li class="p"><a href="#" class="text-center"> <small
									class="text-primary">READ ALL</small>
							</a></li>
							<!-- END dropdown footer-->
						</ul> <!-- END Dropdown menu--></li>
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
					<!-- START Contacts button-->
					<li class="visible-xs"><a href="#"
						data-toggle-state="offsidebar-open"> <em
							class="fa fa-comment-o"></em>
					</a></li>
					<!-- END Contacts menu-->
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
					<li class="active"><a href="#" title="Dashboard"
						data-toggle="collapse-next" class="has-submenu"> <em
							class="fa fa-dot-circle-o"></em>
							<div class="label label-primary pull-right">10</div> <span
							class="item-text">Dashboard</span>
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
						</ul> <!-- END SubMenu item--></li>
					<li><a href="#" title="Elements" data-toggle="collapse-next"
						class="has-submenu"> <em class="fa fa-flask"></em> <span
							class="item-text">Elements</span>
					</a> <!-- START SubMenu item-->
						<ul class="nav collapse ">
							<li><a href="panels.html" title="Panels" data-toggle=""
								class="no-submenu"> <span class="item-text">Panels</span>
							</a></li>
							<li><a href="portlets.html" title="Portlets" data-toggle=""
								class="no-submenu"> <span class="item-text">Portlets</span>
							</a></li>
							<li><a href="button.html" title="Buttons" data-toggle=""
								class="no-submenu"> <span class="item-text">Buttons</span>
							</a></li>
							<li><a href="icons.html" title="Icons" data-toggle=""
								class="no-submenu">
									<div class="label label-primary pull-right">+400</div> <span
									class="item-text">Icons</span>
							</a></li>
							<li><a href="notifications.html" title="Notifications"
								data-toggle="" class="no-submenu"> <span class="item-text">Notifications</span>
							</a></li>
							<li><a href="typo.html" title="Typography" data-toggle=""
								class="no-submenu"> <span class="item-text">Typography</span>
							</a></li>
							<li><a href="grid.html" title="Grid" data-toggle=""
								class="no-submenu"> <span class="item-text">Grid</span>
							</a></li>
							<li><a href="grid-masonry.html" title="Grid Masonry"
								data-toggle="" class="no-submenu"> <span class="item-text">Grid
										Masonry</span>
							</a></li>
							<li><a href="animations.html" title="Animations"
								data-toggle="" class="no-submenu"> <span class="item-text">Animations</span>
							</a></li>
							<li><a href="dropdown-animations.html" title="Dropdown"
								data-toggle="" class="no-submenu"> <span class="item-text">Dropdown</span>
							</a></li>
							<li><a href="widgets.html" title="Widgets" data-toggle=""
								class="no-submenu"> <span class="item-text">Widgets</span>
							</a></li>
							<li><a href="spinners.html" title="Spinners" data-toggle=""
								class="no-submenu"> <span class="item-text">Spinners</span>
							</a></li>
						</ul> <!-- END SubMenu item--></li>
					<li><a href="#" title="Pages" data-toggle="collapse-next"
						class="has-submenu"> <em class="fa fa-file-text-o"></em> <span
							class="item-text">Pages</span>
					</a> <!-- START SubMenu item-->
						<ul class="nav collapse ">
							<li><a href="pages/landing.html" title="Landing"
								data-toggle="" class="no-submenu"> <span class="item-text">Landing</span>
							</a></li>
							<li><a href="pages/login.html" title="Login" data-toggle=""
								class="no-submenu"> <span class="item-text">Login</span>
							</a></li>
							<li><a href="pages/login-multi.html" title="Login Multi"
								data-toggle="" class="no-submenu"> <span class="item-text">Login
										Multi</span>
							</a></li>
							<li><a href="pages/signup.html" title="Sign up"
								data-toggle="" class="no-submenu"> <span class="item-text">Sign
										up</span>
							</a></li>
							<li><a href="pages/lock.html" title="Lock" data-toggle=""
								class="no-submenu"> <span class="item-text">Lock</span>
							</a></li>
							<li><a href="pages/recover.html" title="Recover Password"
								data-toggle="" class="no-submenu"> <span class="item-text">Recover
										Password</span>
							</a></li>
							<li><a href="template.html" title="Empty Template"
								data-toggle="" class="no-submenu"> <span class="item-text">Empty
										Template</span>
							</a></li>
						</ul> <!-- END SubMenu item--></li>
					<li class="nav-heading">More</li>
					<li><a href="#" title="Maps" data-toggle="collapse-next"
						class="has-submenu"> <em class="fa fa-globe"></em>
							<div class="label label-primary pull-right">new</div> <span
							class="item-text">Maps</span>
					</a> <!-- START SubMenu item-->
						<ul class="nav collapse ">
							<li><a href="maps-google.html" title="Google Maps"
								data-toggle="" class="no-submenu"> <span class="item-text">Google
										Maps</span>
							</a></li>
							<li><a href="maps-vector.html" title="Vector Maps"
								data-toggle="" class="no-submenu">
									<div class="label label-primary pull-right">new</div> <span
									class="item-text">Vector Maps</span>
							</a></li>
						</ul> <!-- END SubMenu item--></li>
					<li><a href="#" title="Charts" data-toggle="collapse-next"
						class="has-submenu"> <em class="fa fa-area-chart"></em>
							<div class="label label-primary pull-right">new</div> <span
							class="item-text">Charts</span>
					</a> <!-- START SubMenu item-->
						<ul class="nav collapse ">
							<li><a href="chart-flot.html" title="Flot" data-toggle=""
								class="no-submenu"> <span class="item-text">Flot</span>
							</a></li>
							<li><a href="chart-radial.html" title="Radial"
								data-toggle="" class="no-submenu">
									<div class="label label-primary pull-right">new</div> <span
									class="item-text">Radial</span>
							</a></li>
						</ul> <!-- END SubMenu item--></li>
					<li><a href="#" title="Tables" data-toggle="collapse-next"
						class="has-submenu"> <em class="fa fa-table"></em> <span
							class="item-text">Tables</span>
					</a> <!-- START SubMenu item-->
						<ul class="nav collapse ">
							<li><a href="table-datatable.html" title="Data Table"
								data-toggle="" class="no-submenu"> <span class="item-text">Data
										Table</span>
							</a></li>
							<li><a href="table-standard.html" title="Standard"
								data-toggle="" class="no-submenu"> <span class="item-text">Standard</span>
							</a></li>
							<li><a href="table-extended.html" title="Extended"
								data-toggle="" class="no-submenu"> <span class="item-text">Extended</span>
							</a></li>
						</ul> <!-- END SubMenu item--></li>
					<li><a href="#" title="Forms" data-toggle="collapse-next"
						class="has-submenu"> <em class="fa fa-edit"></em> <span
							class="item-text">Forms</span>
					</a> <!-- START SubMenu item-->
						<ul class="nav collapse ">
							<li><a href="form-standard.html" title="Standard"
								data-toggle="" class="no-submenu"> <span class="item-text">Standard</span>
							</a></li>
							<li><a href="form-wizard.html" title="Wizard" data-toggle=""
								class="no-submenu"> <span class="item-text">Wizard</span>
							</a></li>
							<li><a href="form-validation.html" title="Validation"
								data-toggle="" class="no-submenu"> <span class="item-text">Validation</span>
							</a></li>
							<li><a href="form-extended.html" title="Extended"
								data-toggle="" class="no-submenu"> <span class="item-text">Extended</span>
							</a></li>
						</ul> <!-- END SubMenu item--></li>
					<li><a href="#" title="Extras" data-toggle="collapse-next"
						class="has-submenu"> <em class="fa fa-plus"></em>
							<div class="label label-primary pull-right">new</div> <span
							class="item-text">Extras</span>
					</a> <!-- START SubMenu item-->
						<ul class="nav collapse ">
							<li><a href="calendar.html" title="Calendar" data-toggle=""
								class="no-submenu"> <span class="item-text">Calendar</span>
							</a></li>
							<li><a href="timeline.html" title="Timeline" data-toggle=""
								class="no-submenu"> <span class="item-text">Timeline</span>
							</a></li>
							<li><a href="search.html" title="Search" data-toggle=""
								class="no-submenu"> <span class="item-text">Search</span>
							</a></li>
							<li><a href="invoice.html" title="Invoice" data-toggle=""
								class="no-submenu"> <span class="item-text">Invoice</span>
							</a></li>
							<li><a href="mailbox.html" title="Mailbox" data-toggle=""
								class="no-submenu"> <span class="item-text">Mailbox</span>
							</a></li>
							<li><a href="filebox.html" title="Filebox" data-toggle=""
								class="no-submenu">
									<div class="label label-primary pull-right">new</div> <span
									class="item-text">Filebox</span>
							</a></li>
						</ul> <!-- END SubMenu item--></li>
					<!-- START Theme color options-->
					<li><a href="#" title="Color options"
						data-toggle="collapse-next" class="has-submenu"> <em
							class="fa fa-tint"></em> <span class="item-text">Themes</span>
					</a> <!-- START SubMenu item-->
						<ul class="nav collapse">
							<li><a href="#" title="Option 1" data-toggle="load-css"
								data-uri="app/css/wintermin-theme-a.css" class="no-submenu">
									<span class="item-text">Color option 1</span>
							</a></li>
							<li><a href="#" title="Option 2" data-toggle="load-css"
								data-uri="app/css/wintermin-theme-b.css" class="no-submenu">
									<span class="item-text">Color option 2</span>
							</a></li>
							<li><a href="#" title="Option 3" data-toggle="load-css"
								data-uri="app/css/wintermin-theme-c.css" class="no-submenu">
									<span class="item-text">Color option 3</span>
							</a></li>
							<li><a href="#" title="Option 4" data-toggle="load-css"
								data-uri="app/css/wintermin-theme-d.css" class="no-submenu">
									<span class="item-text">Color option 4</span>
							</a></li>
							<li><a href="#" title="Default" data-toggle="load-css"
								data-uri="#" class="no-submenu"> <span class="item-text">Default</span>
							</a></li>
						</ul> <!-- END SubMenu item--></li>
					<!-- END Theme color options-->
					<li>
						<ul class="nav-labels">
							<li class="nav-heading">Labels</li>
							<li class="nav-labels-item"><span
								class="point point-lg point-success point-outline"></span><a
								href="#">Label A</a></li>
							<li class="nav-labels-item"><span
								class="point point-lg point-danger point-outline"></span><a
								href="#">Label B</a></li>
							<li class="nav-labels-item"><span
								class="point point-lg point-info point-outline"></span><a
								href="#">Label C</a></li>
							<li class="nav-labels-item"><span
								class="point point-lg point-warning point-outline"></span><a
								href="#">Label D</a></li>
						</ul>
					</li>
					<!-- END Menu-->
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