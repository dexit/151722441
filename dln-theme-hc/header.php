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

	<?php dln_get_notifications_objects() ?>
	<div class="mainpanel">
		<div class="headerbar">
		<?php get_search_form() ?>
	      <div class="header-right">
	        <ul class="headermenu">
	          <li>
	            <div class="btn-group">
	              <button class="btn btn-default dropdown-toggle tp-icon" data-toggle="dropdown">
	                <i class="glyphicon glyphicon-user"></i>
	                <span class="badge">2</span>
	              </button>
	              <div class="dropdown-menu dropdown-menu-head pull-right">
	                <h5 class="title">2 Newly Registered Users</h5>
	                <ul class="dropdown-list user-list">
	                  <li class="new">
	                    <div class="thumb"><a href="#"><img src="images/photos/user1.png" alt="" /></a></div>
	                    <div class="desc">
	                      <h5><a href="#">Draniem Daamul (@draniem)</a> <span class="badge badge-success">new</span></h5>
	                    </div>
	                  </li>
	                  <li class="new">
	                    <div class="thumb"><a href="#"><img src="images/photos/user2.png" alt="" /></a></div>
	                    <div class="desc">
	                      <h5><a href="#">Zaham Sindilmaca (@zaham)</a> <span class="badge badge-success">new</span></h5>
	                    </div>
	                  </li>
	                  <li>
	                    <div class="thumb"><a href="#"><img src="images/photos/user3.png" alt="" /></a></div>
	                    <div class="desc">
	                      <h5><a href="#">Weno Carasbong (@wenocar)</a></h5>
	                    </div>
	                  </li>
	                  <li>
	                    <div class="thumb"><a href="#"><img src="images/photos/user4.png" alt="" /></a></div>
	                    <div class="desc">
	                      <h5><a href="#">Nusja Nawancali (@nusja)</a></h5>
	                    </div>
	                  </li>
	                  <li>
	                    <div class="thumb"><a href="#"><img src="images/photos/user5.png" alt="" /></a></div>
	                    <div class="desc">
	                      <h5><a href="#">Lane Kitmari (@lane_kitmare)</a></h5>
	                    </div>
	                  </li>
	                  <li class="new"><a href="#">See All Users</a></li>
	                </ul>
	              </div>
	            </div>
	          </li>
	          <li>
	            <div class="btn-group">
	              <button class="btn btn-default dropdown-toggle tp-icon" data-toggle="dropdown">
	                <i class="glyphicon glyphicon-envelope"></i>
	                <span class="badge">1</span>
	              </button>
	              <div class="dropdown-menu dropdown-menu-head pull-right">
	                <h5 class="title">You Have 1 New Message</h5>
	                <ul class="dropdown-list gen-list">
	                  <li class="new">
	                    <a href="#">
	                    <span class="thumb"><img src="images/photos/user1.png" alt="" /></span>
	                    <span class="desc">
	                      <span class="name">Draniem Daamul <span class="badge badge-success">new</span></span>
	                      <span class="msg">Lorem ipsum dolor sit amet...</span>
	                    </span>
	                    </a>
	                  </li>
	                  <li>
	                    <a href="#">
	                    <span class="thumb"><img src="images/photos/user2.png" alt="" /></span>
	                    <span class="desc">
	                      <span class="name">Nusja Nawancali</span>
	                      <span class="msg">Lorem ipsum dolor sit amet...</span>
	                    </span>
	                    </a>
	                  </li>
	                  <li>
	                    <a href="#">
	                    <span class="thumb"><img src="images/photos/user3.png" alt="" /></span>
	                    <span class="desc">
	                      <span class="name">Weno Carasbong</span>
	                      <span class="msg">Lorem ipsum dolor sit amet...</span>
	                    </span>
	                    </a>
	                  </li>
	                  <li>
	                    <a href="#">
	                    <span class="thumb"><img src="images/photos/user4.png" alt="" /></span>
	                    <span class="desc">
	                      <span class="name">Zaham Sindilmaca</span>
	                      <span class="msg">Lorem ipsum dolor sit amet...</span>
	                    </span>
	                    </a>
	                  </li>
	                  <li>
	                    <a href="#">
	                    <span class="thumb"><img src="images/photos/user5.png" alt="" /></span>
	                    <span class="desc">
	                      <span class="name">Veno Leongal</span>
	                      <span class="msg">Lorem ipsum dolor sit amet...</span>
	                    </span>
	                    </a>
	                  </li>
	                  <li class="new"><a href="#">Read All Messages</a></li>
	                </ul>
	              </div>
	            </div>
	          </li>
	          <li>
	            <div class="btn-group">
	              <button class="btn btn-default dropdown-toggle tp-icon" data-toggle="dropdown">
	                <i class="glyphicon glyphicon-globe"></i>
	                <span class="badge">5</span>
	              </button>
	              <div class="dropdown-menu dropdown-menu-head pull-right">
	                <h5 class="title">You Have 5 New Notifications</h5>
	                <ul class="dropdown-list gen-list">
	                  <li class="new">
	                    <a href="#">
	                    <span class="thumb"><img src="images/photos/user4.png" alt="" /></span>
	                    <span class="desc">
	                      <span class="name">Zaham Sindilmaca <span class="badge badge-success">new</span></span>
	                      <span class="msg">is now following you</span>
	                    </span>
	                    </a>
	                  </li>
	                  <li class="new">
	                    <a href="#">
	                    <span class="thumb"><img src="images/photos/user5.png" alt="" /></span>
	                    <span class="desc">
	                      <span class="name">Weno Carasbong <span class="badge badge-success">new</span></span>
	                      <span class="msg">is now following you</span>
	                    </span>
	                    </a>
	                  </li>
	                  <li class="new">
	                    <a href="#">
	                    <span class="thumb"><img src="images/photos/user3.png" alt="" /></span>
	                    <span class="desc">
	                      <span class="name">Veno Leongal <span class="badge badge-success">new</span></span>
	                      <span class="msg">likes your recent status</span>
	                    </span>
	                    </a>
	                  </li>
	                  <li class="new">
	                    <a href="#">
	                    <span class="thumb"><img src="images/photos/user3.png" alt="" /></span>
	                    <span class="desc">
	                      <span class="name">Nusja Nawancali <span class="badge badge-success">new</span></span>
	                      <span class="msg">downloaded your work</span>
	                    </span>
	                    </a>
	                  </li>
	                  <li class="new">
	                    <a href="#">
	                    <span class="thumb"><img src="images/photos/user3.png" alt="" /></span>
	                    <span class="desc">
	                      <span class="name">Nusja Nawancali <span class="badge badge-success">new</span></span>
	                      <span class="msg">send you 2 messages</span>
	                    </span>
	                    </a>
	                  </li>
	                  <li class="new"><a href="#">See All Notifications</a></li>
	                </ul>
	              </div>
	            </div>
	          </li>
	          <li>
	            <div class="btn-group">
	              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
	                <img src="images/photos/loggeduser.png" alt="" />
	                John Doe
	                <span class="caret"></span>
	              </button>
	              <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
	                <li><a href="profile.html"><i class="glyphicon glyphicon-user"></i> My Profile</a></li>
	                <li><a href="#"><i class="glyphicon glyphicon-cog"></i> Account Settings</a></li>
	                <li><a href="#"><i class="glyphicon glyphicon-question-sign"></i> Help</a></li>
	                <li><a href="signin.html"><i class="glyphicon glyphicon-log-out"></i> Log Out</a></li>
	              </ul>
	            </div>
	          </li>
	          <li>
	            <button id="chatview" class="btn btn-default tp-icon chat-icon">
	                <i class="glyphicon glyphicon-comment"></i>
	            </button>
	          </li>
	        </ul>
	      </div><!-- header-right -->
		</div>
	</div>
</body>