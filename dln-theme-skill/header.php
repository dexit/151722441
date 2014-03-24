<?php ?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themepixels.com/demo/webpage/bracket/ by HTTrack Website Copier/3.x [XR&CO'2013], Tue, 18 Feb 2014 13:50:16 GMT -->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png" type="image/png">
		
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/assets/images/touch/apple-touch-icon-144x144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/assets/images/touch/apple-touch-icon-114x114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/assets/images/touch/apple-touch-icon-72x72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="<?php echo get_template_directory_uri(); ?>/assets/images/touch/apple-touch-icon-57x57-precomposed.png">
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/touch/apple-touch-icon.png">
		
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/plugins/magnific/css/magnific-popup.min.css">
		
		<!-- Library stylesheet : mandatory -->
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/library/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/library/jquery/css/jquery-ui.min.css">
		<!--/ Library stylesheet -->
		
		<!-- Application stylesheet : mandatory -->
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/stylesheet/layout.min.css">
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/stylesheet/uielement.min.css">
		<!--/ Application stylesheet -->
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/stylesheet/dln-style.css">
		<!-- START JAVASCRIPT SECTION - Load only modernizr script here -->
		<script src="<?php echo get_template_directory_uri(); ?>/assets/library/modernizr/js/modernizr.min.js"></script>
	<!--/ END JAVASCRIPT SECTION -->
	</head>

	<body data-page="page-profile">
        <!-- START Template Header -->
        <header id="header" class="navbar navbar-fixed-top">
            <!-- START Toolbar -->
            <div class="container navbar-toolbar clearfix">
                <!-- START Left nav -->
                <ul class="nav navbar-nav navbar-left">
                    <!-- Offcanvas left: This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->
                    <li class="navbar-main hidden-lg hidden-md">
                        <a href="javascript:void(0);" data-toggle="offcanvas" data-direction="ltr" rel="tooltip" title="Menu sidebar">
                            <span class="meta">
                                <span class="icon"><i class="ico-paragraph-left3"></i></span>
                            </span>
                        </a>
                    </li>
                    <!--/ Offcanvas left -->

                    <!-- Message dropdown -->
                    <li class="dropdown custom">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="meta">
                                <span class="icon"><i class="ico-bubbles2"></i></span>
                            </span>
                        </a>
                        <!-- Dropdown menu -->
                        <div class="dropdown-menu" role="menu">
                            <div class="dropdown-header">
                                <span class="title">Messages</span>
                                <span class="option text-right"><a href="javascript:void(0);">New message</a></span>
                            </div>
                            <div class="dropdown-body slimscroll">
                                <!-- Search form -->
                                <form class="form-horizontal" action="#">
                                    <div class="has-icon">
                                        <input type="text" class="form-control" placeholder="Search message...">
                                        <i class="ico-search form-control-icon"></i>
                                    </div>
                                </form>
                                <!--/ Search form -->

                                <!-- Message list -->
                                <div class="media-list">
								    <a href="page-message-rich.html" class="media border-dotted">
								        <span class="pull-left">
								            <img src="image/avatar/avatar6.jpg" class="media-object img-circle" alt="">
								        </span>
								        <span class="media-body">
								            <span class="media-heading">Arthur Abbott</span>
								            <span class="media-text ellipsis nm">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.</span>
								            <!-- meta icon -->
								            <span class="media-meta"><i class="ico-star6"></i></span>
								            <span class="media-meta"><i class="ico-attachment"></i></span>
								            <span class="media-meta pull-right">2m</span>
								            <!--/ meta icon -->
								        </span>
								    </a>
								
								    <a href="page-message-rich.html" class="media border-dotted read">
								        <span class="pull-left">
								            <img src="image/avatar/avatar1.jpg" class="media-object img-circle" alt="">
								        </span>
								        <span class="media-body">
								            <span class="media-heading">Martina Poole</span>
								            <span class="media-text ellipsis nm">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.</span>
								            <!-- meta icon -->
								            <span class="media-meta"><i class="ico-reply"></i></span>
								            <span class="media-meta"><i class="ico-attachment"></i></span>
								            <span class="media-meta pull-right">20m</span>
								            <!--/ meta icon -->
								        </span>
								    </a>
								
								    <a href="page-message-rich.html" class="media border-dotted">
								        <span class="pull-left">
								            <img src="image/avatar/avatar2.jpg" class="media-object img-circle" alt="">
								        </span>
								        <span class="media-body">
								            <span class="media-heading">Elvis Christensen</span>
								            <span class="media-text ellipsis nm">Duis aute irure dolor in reprehenderit in voluptate velit esse.</span>
								            <!-- meta icon -->
								            <span class="media-meta"><i class="ico-attachment"></i></span>
								            <span class="media-meta pull-right">5h</span>
								            <!--/ meta icon -->
								        </span>
								    </a>
								
								    <a href="page-message-rich.html" class="media border-dotted read">
								        <span class="pull-left">
								            <img src="image/avatar/avatar3.jpg" class="media-object img-circle" alt="">
								        </span>
								        <span class="media-body">
								            <span class="media-heading">Walter Foster</span>
								            <span class="media-text ellipsis nm">Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</span>
								            <!-- meta icon -->
								            <span class="media-meta"><i class="ico-attachment"></i></span>
								            <span class="media-meta pull-right">21h</span>
								            <!--/ meta icon -->
								        </span>
								    </a>
								
								    <a href="page-message-rich.html" class="media border-dotted read">
								        <span class="pull-left">
								            <img src="image/avatar/avatar4.jpg" class="media-object img-circle" alt="">
								        </span>
								        <span class="media-body">
								            <span class="media-heading">Callum Santosr</span>
								            <span class="media-text ellipsis nm">Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</span>
								            <!-- meta icon -->
								            <span class="media-meta pull-right">1d</span>
								            <!--/ meta icon -->
								        </span>
								    </a>
								
								    <a href="page-message-rich.html" class="media border-dotted read">
								        <span class="pull-left">
								            <img src="image/avatar/avatar5.jpg" class="media-object img-circle" alt="">
								        </span>
								        <span class="media-body">
								            <span class="media-heading">Noelani Blevins</span>
								            <span class="media-text ellipsis nm">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis.</span>
								            <!-- meta icon -->
								            <span class="media-meta pull-right">2d</span>
								            <!--/ meta icon -->
								        </span>
								    </a>
								
								    <a href="page-message-rich.html" class="media border-dotted read">
								        <span class="pull-left">
								            <img src="image/avatar/avatar8.jpg" class="media-object img-circle" alt="">
								        </span>
								        <span class="media-body">
								            <span class="media-heading">Carl Johnson</span>
								            <span class="media-text ellipsis nm">Curabitur consequat, lectus sit amet luctus vulputate, nisi sem</span>
								            <!-- meta icon -->
								            <span class="media-meta"><i class="ico-attachment"></i></span>
								            <span class="media-meta pull-right">2w</span>
								            <!--/ meta icon -->
								        </span>
								    </a>
								
								    <a href="page-message-rich.html" class="media border-dotted read">
								        <span class="pull-left">
								            <img src="image/avatar/avatar9.jpg" class="media-object img-circle" alt="">
								        </span>
								        <span class="media-body">
								            <span class="media-heading">Tamara Moon</span>
								            <span class="media-text ellipsis nm">Aliquam ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus.</span>
								            <!-- meta icon -->
								            <span class="media-meta"><i class="ico-attachment"></i></span>
								            <span class="media-meta pull-right">2w</span>
								            <!--/ meta icon -->
								        </span>
								    </a>
								</div>
                                <!--/ Message list -->
                            </div>
                        </div>
                        <!--/ Dropdown menu -->
                    </li>
                    <!--/ Message dropdown -->

                    <!-- Notification dropdown -->
                    <li class="dropdown custom">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="meta">
                                <span class="icon"><i class="ico-bell"></i></span>
                                <span class="hasnotification hasnotification-danger"></span>
                            </span>
                        </a>
                        <!-- Dropdown menu -->
                        <div class="dropdown-menu" role="menu">
                            <div class="dropdown-header">
                                <span class="title">Notification (5)</span>
                                <span class="option text-right"><a href="javascript:void(0);">Clear all</a></span>
                            </div>
                            <div class="dropdown-body slimscroll">
                                <!-- Message list -->
                                <div class="media-list">
    <a href="javascript:void(0);" class="media border-dotted">
        <span class="media-object pull-left">
            <i class="ico-instagram2 bgcolor-teal"></i>
        </span>
        <span class="media-body">
            <span class="media-text">Lorem ipsum <span class="text-primary semibold">dolor sit</span> amet, consectetur adipisicing elit.</span>
            <!-- meta icon -->
            <span class="media-meta pull-right">2m</span>
            <!--/ meta icon -->
        </span>
    </a>

    <a href="javascript:void(0);" class="media border-dotted">
        <span class="media-object pull-left">
            <i class="ico-queen"></i>
        </span>
        <span class="media-body">
            <span class="media-text">Ut <span class="text-primary semibold">enim</span> ad minim veniam, aliquip ex ea commodo.</span>
            <!-- meta icon -->
            <span class="media-meta pull-right">10m</span>
            <!--/ meta icon -->
        </span>
    </a>

    <a href="javascript:void(0);" class="media read border-dotted">
        <span class="media-object pull-left">
            <i class="ico-file-check bgcolor-success"></i>
        </span>
        <span class="media-body">
            <span class="media-text">Excepteur sint <span class="text-primary semibold">occaecat cupidatat</span> non laborum.</span>
            <!-- meta icon -->
            <span class="media-meta pull-right">1d</span>
            <!--/ meta icon -->
        </span>
    </a>

    <a href="javascript:void(0);" class="media read border-dotted">
        <span class="media-object pull-left">
            <i class="ico-basket2 bgcolor-info"></i>
        </span>
        <span class="media-body">
            <span class="media-text">Duis aute irure dolor in <span class="text-primary semibold">reprehenderit</span> in voluptate.</span>
            <!-- meta icon -->
            <span class="media-meta pull-right">2d</span>
            <!--/ meta icon -->
        </span>
    </a>

    <a href="javascript:void(0);" class="media read border-dotted">
        <span class="media-object pull-left">
            <i class="ico-call-incoming"></i>
        </span>
        <span class="media-body">
            <span class="media-text">Aliquip ex ea commodo consequat.</span>
            <!-- meta icon -->
            <span class="media-meta pull-right">1w</span>
            <!--/ meta icon -->
        </span>
    </a>

    <a href="javascript:void(0);" class="media read border-dotted">
        <span class="media-object pull-left">
            <i class="ico-alarm2"></i>
        </span>
        <span class="media-body">
            <span class="media-text">Excepteur sint <span class="text-primary semibold">occaecat</span> cupidatat non.</span>
            <!-- meta icon -->
            <span class="media-meta pull-right">12w</span>
            <!--/ meta icon -->
        </span>
    </a>

    <a href="javascript:void(0);" class="media read border-dotted">
        <span class="media-object pull-left">
            <i class="ico-checkmark3 bgcolor-success"></i>
        </span>
        <span class="media-body">
            <span class="media-text">Lorem ipsum dolor sit amet, <span class="text-primary semibold">consectetur</span> adipisicing elit.</span>
            <!-- meta icon -->
            <span class="media-meta pull-right">14w</span>
            <!--/ meta icon -->
        </span>
    </a>
</div>
                                <!--/ Message list -->
                            </div>
                        </div>
                        <!--/ Dropdown menu -->
                    </li>
                    <!--/ Notification dropdown -->

                    <!-- Search form toggler  -->
                    <li>
                        <a href="javascript:void(0);" data-toggle="dropdown" data-target="#dropdown-form">
                            <span class="meta">
                                <span class="icon"><i class="ico-search"></i></span>
                            </span>
                        </a>
                    </li>
                    <!--/ Search form toggler -->
                </ul>
                <!--/ END Left nav -->

                <!-- START navbar form -->
                <div class="navbar-form navbar-left dropdown" id="dropdown-form">
                    <form action="#" role="search">
                        <div class="has-icon">
                            <input type="text" class="form-control" placeholder="Search application...">
                            <i class="ico-search form-control-icon"></i>
                        </div>
                    </form>
                </div>
                <!-- START navbar form -->

                <!-- START Right nav -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Profile dropdown -->
                    <li class="dropdown profile">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="meta">
                                <span class="avatar"><img src="image/avatar/avatar7.jpg" class="img-circle" alt="" /></span>
                                <span class="text hidden-xs hidden-sm">Erich Reyes</span>
                                <span class="arrow"></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="pa15">
                                <h5 class="semibold hidden-xs hidden-sm">
                                    60% <br/>
                                    <small class="text-muted">Profile complete</small>
                                </h5>
                                <h5 class="semibold hidden-md hidden-lg">
                                    Erich Reyes<br/>
                                    <small class="text-muted">60% Profile complete</small>
                                </h5>
                                <div class="progress progress-xs nm mt10">
                                    <div class="progress-bar progress-bar-warning" style="width: 60%">
                                        <span class="sr-only">60% Complete</span>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li><a href="javascript:void(0);"><span class="icon"><i class="ico-user-plus2"></i></span> My Accounts</a></li>
                            <li><a href="javascript:void(0);"><span class="icon"><i class="ico-cog4"></i></span> Profile Setting</a></li>
                            <li><a href="javascript:void(0);"><span class="icon"><i class="ico-question"></i></span> Help</a></li>
                            <li class="divider"></li>
                            <li><a href="javascript:void(0);"><span class="icon"><i class="ico-exit"></i></span> Sign Out</a></li>
                        </ul>
                    </li>
                    <!--/ Profile dropdown -->
                    
                    <!-- Offcanvas right This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->
                    <li class="navbar-main">
                        <a href="javascript:void(0);" data-toggle="offcanvas" data-direction="rtl" rel="tooltip" title="Feed / contact sidebar">
                            <span class="meta">
                                <span class="icon"><i class="ico-users3"></i></span>
                                <span class="hasnotification hasnotification-danger"></span>
                            </span>
                        </a>
                    </li>
                    <!--/ Offcanvas right -->
                </ul>
                <!--/ END Right nav -->
            </div>
            <!--/ END Toolbar / link -->
        </header>
        <!--/ END Template Header -->

        <!-- START Template Main -->
        <section id="main" role="main">
            <!-- START Jumbotron -->
			<div class="jumbotron">
			    <!-- loading indicator -->
			    <div class="indicator"><span class="spinner"></span></div>
			    <!--/ loading indicator -->
			    <!-- info -->
			    <div class="info bottom">
			        <ul class="list-table">
			            <li class="text-left" style="width:80px;">
			                <img class="img-circle" src="image/avatar/avatar9.jpg" alt="" width="70px" height="70px">
			            </li>
			            <li class="text-left">
			                <h4 class="semibold ellipsis nm">Tamara Moon</h4>
			                <p class="ellipsis nm"><i class="ico-location"></i> Hong Kong</p>
			            </li>
			            <li class="text-right">
			                <button class="btn btn-success"><span class="ico-envelop2"></span> Message</button>
			            </li>
			        </ul>
			    </div>
			    <!--/ info -->
			    <!-- media : make sure that media image is 1280px width -->
			    <div class="media">
			        <img data-toggle="unveil" src="image/background/placeholder.jpg" data-src="image/background/background16.jpg" alt="Cover photo">
			    </div>
			    <!--/ media -->
			</div>
			<!--/ END Jumbotron -->

			<!-- START Template Container -->
			<section class="container-fluid">
			    <!-- START Table Layout -->
			    <div class="row">
			        <!-- Left Side / Top side -->
			        <div class="col-md-9">
			            <div class="row">
			                <!-- 1/2 Grid -->
			                <div class="col-lg-6">
			                    <!-- Post form -->
			                    <form class="panel" action="#">
			                        <textarea class="form-control form-control-minimal" rows="3" placeholder="What on your mind?"></textarea>
			                        <div class="panel-footer">
			                            <div class="panel-toolbar-wrapper">
			                                <div class="panel-toolbar">
			                                    <div class="btn-group">
			                                        <button type="button" class="btn btn-default"><i class="ico-user-plus2"></i></button>
			                                        <button type="button" class="btn btn-default"><i class="ico-camera3"></i></button>
			                                        <button type="button" class="btn btn-default"><i class="ico-location"></i></button>
			                                    </div>
			                                </div>
			                                <div class="panel-toolbar text-right">
			                                    <button type="submit" class="btn btn-primary">Post</button>
			                                </div>
			                            </div>
			                        </div>
			                    </form>
			                    <!--/ Post form -->
			
			                    <!-- Image post -->
			                    <div class="panel">
			                        <!-- User info -->
			                        <ul class="list-table pa15">
			                            <li class="text-left" style="width:60px;">
			                                <img class="img-circle" src="image/avatar/avatar9.jpg" alt="" width="50px" height="50px">
			                            </li>
			                            <li class="text-left">
			                                <p class="ellipsis nm"><span class="semibold">Tamara Moon</span></p>
			                                <p class="text-muted nm">2 Minutes ago</p>
			                            </li>
			                            <li class="text-right" style="width:60px;">
			                                <div class="btn-group">
			                                <button type="button" class="btn btn-link dropdown-toggle text-default" data-toggle="dropdown"><i class="ico-menu2"></i></button>
			                                    <ul class="dropdown-menu dropdown-menu-right">
			                                        <li><a href="javascript:void(0);">Report</a></li>
			                                        <li><a href="javascript:void(0);">Setting</a></li>
			                                        <li class="divider"></li>
			                                        <li><a href="javascript:void(0);" class="text-danger">Delete post</a></li>
			                                    </ul>
			                                </div>
			                            </li>
			                        </ul>
			                        <!--/ User info -->
			                        <!-- Thumbnail -->
			                        <div class="thumbnail thumbnail-album">
			                            <!-- media -->
			                            <div class="media">
			                                <!-- indicator -->
			                                <div class="indicator"><span class="spinner"></span></div>
			                                <!--/ indicator -->
			                                <img data-toggle="unveil" src="image/background/400x250/placeholder.jpg" data-src="image/background/400x250/background11.jpg" alt="Cover" width="100%">
			                            </div>
			                            <!--/ media -->
			                        </div>
			                        <!--/ Thumbnail -->
			                        <!-- Toolbar -->
			                        <div class="panel-toolbar-wrapper">
			                            <div class="panel-toolbar">
			                                <a href="javascript:void(0);" class="semibold text-default">Comment</a>
			                                <span class="text-muted mr5 ml5">&#8226;</span>
			                                <a href="javascript:void(0);" class="semibold text-default">Love this</a>
			                                <span class="text-muted mr5 ml5">&#8226;</span>
			                                <a href="javascript:void(0);" class="semibold text-default">Share</a>
			                            </div>
			                        </div>
			                        <!--/ Toolbar -->
			                        <!-- Comment box -->
			                        <textarea class="form-control form-control-minimal" rows="3" placeholder="Write your comment"></textarea>
			                        <!--/ Comment box -->
			                    </div>
			                    <!--/ Image post -->
			
			                    <!-- Photo list post -->
			                    <div class="panel">
			                        <!-- User info -->
			                        <ul class="list-table pa15">
			                            <li class="text-left" style="width:60px;">
			                                <img class="img-circle" src="image/avatar/avatar9.jpg" alt="" width="50px" height="50px">
			                            </li>
			                            <li class="text-left">
			                                <p class="ellipsis nm"><span class="semibold">Tamara Moon</span> upload <span class="semibold">3</span> new photo.</p>
			                                <p class="text-muted nm">50 Minutes ago</p>
			                            </li>
			                            <li class="text-right" style="width:60px;">
			                                <div class="btn-group">
			                                <button type="button" class="btn btn-link dropdown-toggle text-default" data-toggle="dropdown"><i class="ico-menu2"></i></button>
			                                    <ul class="dropdown-menu dropdown-menu-right">
			                                        <li><a href="javascript:void(0);">Report</a></li>
			                                        <li><a href="javascript:void(0);">Setting</a></li>
			                                        <li class="divider"></li>
			                                        <li><a href="javascript:void(0);" class="text-danger">Delete post</a></li>
			                                    </ul>
			                                </div>
			                            </li>
			                        </ul>
			                        <!--/ User info -->
			                        <hr class="nm"><!-- horizontal line -->
			                        <!-- Panel body -->
			                        <div class="panel-body">
			                            <h5 class="semibold mb5 mt0"><a href="javascript:void(0);">Untitle album</a></h5>
			                            <p class="nm ellipsis">
			                                <a href="javascript:void(0);" class="text-default"><i class="ico-camera4"></i> 562 Photo</a>&nbsp;
			                            </p>
			                        </div>
			                        <!--/ Panel body -->
			                        <hr class="nm"><!-- horizontal line -->
			                        <!-- Photo list -->
			                        <div class="row panel-body" id="photo-list">
			                            <div class="col-xs-4">
			                                <!-- thumbnail -->
			                                <div class="thumbnail nm">
			                                    <!-- media -->
			                                    <div class="media">
			                                        <!-- indicator -->
			                                        <div class="indicator"><span class="spinner"></span></div>
			                                        <!--/ indicator -->
			                                        <!-- toolbar overlay -->
			                                        <div class="overlay">
			                                            <div class="toolbar">
			                                                <a href="image/background/background12.jpg" class="btn btn-default magnific" title="view picture"><i class="ico-search"></i></a>
			                                            </div>
			                                        </div>
			                                        <!--/ toolbar overlay -->
			                                        <img data-toggle="unveil" src="image/background/400x400/placeholder.jpg" data-src="image/background/400x400/background12.jpg" alt="Photo" width="100%" />
			                                    </div>
			                                    <!--/ media -->
			                                </div>
			                                <!--/ thumbnail -->
			                            </div>
			                            <div class="col-xs-4">
			                                <!-- thumbnail -->
			                                <div class="thumbnail nm">
			                                    <!-- media -->
			                                    <div class="media">
			                                        <!-- indicator -->
			                                        <div class="indicator"><span class="spinner"></span></div>
			                                        <!--/ indicator -->
			                                        <!-- toolbar overlay -->
			                                        <div class="overlay">
			                                            <div class="toolbar">
			                                                <a href="image/background/background13.jpg" class="btn btn-default magnific" title="view picture"><i class="ico-search"></i></a>
			                                            </div>
			                                        </div>
			                                        <!--/ toolbar overlay -->
			                                        <img data-toggle="unveil" src="image/background/400x400/placeholder.jpg" data-src="image/background/400x400/background13.jpg" alt="Photo" width="100%" />
			                                    </div>
			                                    <!--/ media -->
			                                </div>
			                                <!--/ thumbnail -->
			                            </div>
			                            <div class="col-xs-4">
			                                <!-- thumbnail -->
			                                <div class="thumbnail nm">
			                                    <!-- media -->
			                                    <div class="media">
			                                        <!-- indicator -->
			                                        <div class="indicator"><span class="spinner"></span></div>
			                                        <!--/ indicator -->
			                                        <!-- toolbar overlay -->
			                                        <div class="overlay">
			                                            <div class="toolbar">
			                                                <a href="image/background/background14.jpg" class="btn btn-default magnific" title="view picture"><i class="ico-search"></i></a>
			                                            </div>
			                                        </div>
			                                        <!--/ toolbar overlay -->
			                                        <img data-toggle="unveil" src="image/background/400x400/placeholder.jpg" data-src="image/background/400x400/background14.jpg" alt="Photo" width="100%" />
			                                    </div>
			                                    <!--/ media -->
			                                </div>
			                                <!--/ thumbnail -->
			                            </div>
			                        </div>
			                        <!--/ Photo list -->
			                        <hr class="nm"><!-- horizontal line -->
			                        <!-- Toolbar -->
			                        <div class="panel-toolbar-wrapper">
			                            <div class="panel-toolbar">
			                                <a href="javascript:void(0);" class="semibold text-default">Comment</a>
			                                <span class="text-muted mr5 ml5">&#8226;</span>
			                                <a href="javascript:void(0);" class="semibold text-default">Love this</a>
			                                <span class="text-muted mr5 ml5">&#8226;</span>
			                                <a href="javascript:void(0);" class="semibold text-default">Share</a>
			                            </div>
			                        </div>
			                        <!--/ Toolbar -->
			                        <!-- Comment box -->
			                        <textarea class="form-control form-control-minimal" rows="3" placeholder="Write your comment"></textarea>
			                        <!--/ Comment box -->
			                    </div>
			                    <!--/ Photo list post -->
			                </div>
			                <!--/ 1/2 Grid -->
			
			                <!-- 1/2 Grid -->
			                <div class="col-lg-6">
			                    <!-- Image post -->
			                    <div class="panel">
			                        <!-- User info -->
			                        <ul class="list-table pa15">
			                            <li class="text-left" style="width:60px;">
			                                <img class="img-circle" src="image/avatar/avatar9.jpg" alt="" width="50px" height="50px">
			                            </li>
			                            <li class="text-left">
			                                <p class="ellipsis nm"><span class="semibold">Tamara Moon</span> created an event</p>
			                                <p class="text-muted nm">3 Hour ago</p>
			                            </li>
			                            <li class="text-right" style="width:60px;">
			                                <div class="btn-group">
			                                <button type="button" class="btn btn-link dropdown-toggle text-default" data-toggle="dropdown"><i class="ico-menu2"></i></button>
			                                    <ul class="dropdown-menu dropdown-menu-right">
			                                        <li><a href="javascript:void(0);">Report</a></li>
			                                        <li><a href="javascript:void(0);">Setting</a></li>
			                                        <li class="divider"></li>
			                                        <li><a href="javascript:void(0);" class="text-danger">Delete post</a></li>
			                                    </ul>
			                                </div>
			                            </li>
			                        </ul>
			                        <!--/ User info -->
			                        <hr class="nm"><!-- horizontal line -->
			                        <!-- Panel body -->
			                        <div class="panel-body">
			                            <h5 class="semibold mb5 mt0 text-success">Birthday party at my house</h5>
			                            <p class="nm ellipsis">
			                                <a href="javascript:void(0);" class="text-default"><i class="ico-calendar3"></i> March 19th, 2013</a>&nbsp;
			                                <a href="javascript:void(0);" class="text-default"><i class="ico-location"></i> New York</a>
			                            </p>
			                        </div>
			                        <!--/ Panel body -->
			                        <hr class="nm"><!-- horizontal line -->
			                        <!-- Thumbnail -->
			                        <div class="thumbnail thumbnail-album">
			                            <!-- media -->
			                            <div class="media">
			                                <!-- indicator -->
			                                <div class="indicator"><span class="spinner"></span></div>
			                                <!--/ indicator -->
			                                <img data-toggle="unveil" src="image/background/400x250/placeholder.jpg" data-src="http://maps.googleapis.com/maps/api/staticmap?center=Brooklyn+Bridge,New+York,NY&zoom=13&size=400x200&maptype=roadmap&markers=color:blue%7Clabel:S%7C40.702147,-74.015794&markers=color:green%7Clabel:G%7C40.711614,-74.012318&markers=color:red%7Clabel:C%7C40.718217,-73.998284&sensor=false" alt="Cover" width="100%">
			                            </div>
			                            <!--/ media -->
			                            <!-- meta -->
			                            <ul class="meta">
			                                <li>
			                                    <div class="img-group img-group-stack">
			                                        <img src="image/avatar/avatar7.jpg" class="img-circle" alt="">
			                                        <img src="image/avatar/avatar2.jpg" class="img-circle" alt="">
			                                        <span class="more img-circle">2+</span>
			                                    </div>
			                                </li>
			                                <li>
			                                    <p class="nm"><a href="javascript:void(0);" class="semibold">4 people</a> is going</p>
			                                </li>
			                            </ul>
			                            <!--/ meta -->
			                        </div>
			                        <!--/ Thumbnail -->
			                        <hr class="nm"><!-- horizontal line -->
			                        <!-- Toolbar -->
			                        <div class="panel-toolbar-wrapper">
			                            <div class="panel-toolbar">
			                                <a href="javascript:void(0);" class="semibold text-default">Going</a>
			                                <span class="text-muted mr5 ml5">&#8226;</span>
			                                <a href="javascript:void(0);" class="semibold text-default">Maybe</a>
			                                <span class="text-muted mr5 ml5">&#8226;</span>
			                                <a href="javascript:void(0);" class="semibold text-default">Share</a>
			                            </div>
			                        </div>
			                        <!--/ Toolbar -->
			                        <!-- Comment box -->
			                        <textarea class="form-control form-control-minimal" rows="3" placeholder="Write your comment"></textarea>
			                        <!--/ Comment box -->
			                    </div>
			                    <!--/ Image post -->
			
			                    <!-- Text/status post -->
			                    <div class="panel">
			                        <!-- User info -->
			                        <ul class="list-table pa15">
			                            <li class="text-left" style="width:60px;">
			                                <img class="img-circle" src="image/avatar/avatar9.jpg" alt="" width="50px" height="50px">
			                            </li>
			                            <li class="text-left">
			                                <p class="ellipsis nm"><span class="semibold">Tamara Moon</span> wrote</p>
			                                <p class="text-muted nm">4 Hour ago</p>
			                            </li>
			                            <li class="text-right" style="width:60px;">
			                                <div class="btn-group">
			                                <button type="button" class="btn btn-link dropdown-toggle text-default" data-toggle="dropdown"><i class="ico-menu2"></i></button>
			                                    <ul class="dropdown-menu dropdown-menu-right">
			                                        <li><a href="javascript:void(0);">Report</a></li>
			                                        <li><a href="javascript:void(0);">Setting</a></li>
			                                        <li class="divider"></li>
			                                        <li><a href="javascript:void(0);" class="text-danger">Delete post</a></li>
			                                    </ul>
			                                </div>
			                            </li>
			                        </ul>
			                        <!--/ User info -->
			                        <hr class="nm"><!-- horizontal line -->
			                        <div class="panel-body">
			                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			                            consequat.
			                        </div>
			                        <hr class="nm"><!-- horizontal line -->
			                        <!-- Toolbar -->
			                        <div class="panel-toolbar-wrapper">
			                            <div class="panel-toolbar">
			                                <a href="javascript:void(0);" class="semibold text-default">Comment</a>
			                                <span class="text-muted mr5 ml5">&#8226;</span>
			                                <a href="javascript:void(0);" class="semibold text-default">Love this</a>
			                                <span class="text-muted mr5 ml5">&#8226;</span>
			                                <a href="javascript:void(0);" class="semibold text-default">Share</a>
			                            </div>
			                        </div>
			                        <!--/ Toolbar -->
			                        <!-- Comment list -->
			                        <ul class="media-list">
			                            <li class="media border-dotted">
			                                <a href="javascript:void(0);" class="pull-left">
			                                    <img src="image/avatar/avatar6.jpg" class="media-object img-circle" alt="">
			                                </a>
			                                <div class="media-body">
			                                    <p class="media-heading">Arthur Abbott</p>
			                                    <p class="media-text">Lorem ipsum dolor sit amet, consectetur.</p>
			                                    <!-- meta icon -->
			                                    <p class="media-meta">2m</p>
			                                    <!--/ meta icon -->
			                                </div>
			                            </li>
			                            <li class="media border-dotted">
			                                <a href="javascript:void(0);" class="pull-left">
			                                    <img src="image/avatar/avatar1.jpg" class="media-object img-circle" alt="">
			                                </a>
			                                <div class="media-body">
			                                    <p class="media-heading">Martina Poole</span>
			                                    <p class="media-text">Lorem ipsum dolor sit amet, consectetur.</p>
			                                    <!-- meta icon -->
			                                    <p class="media-meta">20m</p>
			                                    <!--/ meta icon -->
			                                </div>
			                            </li>
			                            <li class="media border-dotted">
			                                <a href="javascript:void(0);" class="pull-left">
			                                    <img src="image/avatar/avatar2.jpg" class="media-object img-circle" alt="">
			                                </a>
			                                <div class="media-body">
			                                    <p class="media-heading">Elvis Christensen</p>
			                                    <p class="media-text">Duis aute irure dolor in reprehenderit.</p>
			                                    <!-- meta icon -->
			                                    <p class="media-meta">5h</p>
			                                    <!--/ meta icon -->
			                                </div>
			                            </li>
			                            <li class="media border-dotted">
			                                <a href="javascript:void(0);" class="pull-left">
			                                    <img src="image/avatar/avatar3.jpg" class="media-object img-circle" alt="">
			                                </a>
			                                <div class="media-body">
			                                    <p class="media-heading">Walter Foster</p>
			                                    <p class="media-text">Cum sociis natoque penatibus et.</p>
			                                    <!-- meta icon -->
			                                    <p class="media-meta">21h</p>
			                                    <!--/ meta icon -->
			                                </div>
			                            </li>
			                            <li class="media border-dotted">
			                                <a href="javascript:void(0);" class="pull-left">
			                                    <img src="image/avatar/avatar4.jpg" class="media-object img-circle" alt="">
			                                </a>
			                                <div class="media-body">
			                                    <p class="media-heading">Callum Santosr</p>
			                                    <p class="media-text">Cum sociis natoque penatibus.</p>
			                                    <!-- meta icon -->
			                                    <p class="media-meta">1d</p>
			                                    <!--/ meta icon -->
			                                </div>
			                            </li>
			                        </ul>
			                        <!--/ Comment list -->
			                        <hr class="nm"><!-- horizontal line -->
			                        <!-- Comment box -->
			                        <textarea class="form-control form-control-minimal" rows="3" placeholder="Write your comment"></textarea>
			                        <!--/ Comment box -->
			                    </div>
			                    <!--/ Text/status post -->
			                </div>
			                <!--/ 1/2 Grid -->
			            </div>
			        </div>
			        <!--/ Left Side / Top side -->
			
			        <!-- Right Side / Bottom side -->
			        <div class="col-md-3">
			            <div class="panel panel-minimal nm">
			                <!-- START Twitter Widget -->
			                <div class="panel-toolbar-wrapper">
			                    <div class="panel-toolbar">
			                        <h5 class="semibold nm text-info"><i class="ico-twitter mr5"></i>Twitter</h5>
			                    </div>
			                    <div class="panel-toolbar text-right">
			                        <button class="btn btn-sm btn-default">Follow</button>
			                    </div>
			                </div>
			                <div class="panel-body pt0 pb0">
			                    <ul class="list-table">
			                        <li style="width:55px;">
			                            <img class="img-circle" src="image/avatar/avatar9.jpg" alt="" width="45px" height="45px">
			                        </li>
			                        <li class="text-left">
			                            <h5 class="semibold ellipsis">
			                                Tamara Moon<br>
			                                <small class="text-muted">@tmoon</small>
			                            </h5>
			                        </li>
			                    </ul>
			                </div>
			                <ul class="nav nav-justified mt15">
			                    <li class="text-center">
			                        <h4 class="nm">12.5k</h4>
			                        <p class="nm text-muted">Followers</p>
			                    </li>
			                    <li class="text-center">
			                        <h4 class="nm">1853</h4>
			                        <p class="nm text-muted">Following</p>
			                    </li>
			                    <li class="text-center">
			                        <h4 class="nm">3451</h4>
			                        <p class="nm text-muted">Tweets</p>
			                    </li>
			                </ul>
			                <!--/ END Twitter Widget -->
			
			                <hr><!--horizontal line -->
			
			                <!-- START Bio -->
			                <div class="panel-toolbar-wrapper">
			                    <div class="panel-toolbar">
			                        <h5 class="semibold nm text-info"><i class="ico-info2 mr5"></i>About</h5>
			                    </div>
			                    <div class="panel-toolbar text-right">
			                        <button class="btn btn-sm btn-default"><i class="ico-pencil7"></i></button>
			                    </div>
			                </div>
			                <div class="panel-body pt0">
			                    <p class="semibold mb5">Bio</p>
			                    <ul class="list-unstyled mb10">
			                        <li><i class="ico-briefcase text-muted mr5"></i> UI/UX Designer</li>
			                        <li><i class="ico-graduation text-muted mr5"></i> Studied interface design</li>
			                        <li><i class="ico-location text-muted mr5"></i> Lives in Sierra Leone</li>
			                        <li><i class="ico-home4 text-muted mr5"></i> From Perth, Australia</li>
			                    </ul>
			                    <address class="nm">
			                        <p class="semibold nm">Address</p>
			                        795 Folsom Ave, Suite 600<br>
			                        San Francisco, CA 94107<br>
			                        <abbr title="Phone">P:</abbr> (123) 456-7890
			                    </address>
			                </div>
			                <!--/ END Bio -->
			
			                <hr><!--horizontal line -->
			
			                <!-- START Friend lists -->
			                <div class="panel-toolbar-wrapper">
			                    <div class="panel-toolbar">
			                        <h5 class="semibold nm text-info"><i class="ico-users3 mr5"></i>Friend lists</h5>
			                    </div>
			                    <div class="panel-toolbar text-right">
			                        <button class="btn btn-sm btn-default"><i class="ico-plus"></i></button>
			                    </div>
			                </div>
			                <div class="panel-body pt0">
			                    <div class="media-list media-list-contact">
			                        <a href="page-message-rich.html" class="media">
			                            <span class="media-object pull-left">
			                                <img src="image/avatar/avatar1.jpg" class="img-circle" alt="">
			                            </span>
			                            <span class="media-body">
			                                <span class="media-heading"><span class="hasnotification hasnotification-success mr5"></span> Autumn Barker</span>
			                                <span class="media-meta">Sint Maarten</span>
			                            </span>
			                        </a>
			
			                        <a href="page-message-rich.html" class="media">
			                            <span class="media-object pull-left">
			                                <img src="image/avatar/avatar2.jpg" class="img-circle" alt="">
			                            </span>
			                            <span class="media-body">
			                                <span class="media-heading"><span class="hasnotification hasnotification-success mr5"></span> Giselle Horn</span>
			                                <span class="media-meta">Saudi Arabia</span>
			                            </span>
			                        </a>
			
			                        <a href="page-message-rich.html" class="media">
			                            <span class="media-object pull-left">
			                                <img src="image/avatar/avatar.png" class="img-circle" alt="">
			                            </span>
			                            <span class="media-body">
			                                <span class="media-heading"><span class="hasnotification hasnotification-danger mr5"></span> Austin Shields</span>
			                                <span class="media-meta">Ghana</span>
			                            </span>
			                        </a>
			
			                        <a href="page-message-rich.html" class="media">
			                            <span class="media-object pull-left">
			                                <img src="image/avatar/avatar.png" class="img-circle" alt="">
			                            </span>
			                            <span class="media-body">
			                                <span class="media-heading"><span class="hasnotification hasnotification-danger mr5"></span> Caryn Gibson</span>
			                                <span class="media-meta">Rwanda</span>
			                            </span>
			                        </a>
			
			                        <a href="page-message-rich.html" class="media">
			                            <span class="media-object pull-left">
			                                <img src="image/avatar/avatar3.jpg" class="img-circle" alt="">
			                            </span>
			                            <span class="media-body">
			                                <span class="media-heading"><span class="hasnotification hasnotification-success mr5"></span> Nash Evans</span>
			                                <span class="media-meta">Somalia</span>
			                            </span>
			                        </a>
			                    </div>
			                    <p class="nm"><a href="javascript:void(0);" class="semibold">View all</a></p>
			                </div>
			                <!--/ END Friend lists -->
			            </div>
			            <!--/ Left Side / Top side -->
			        </div>
			    </div>
			    <!--/ END Table Layout -->
			</section>
			<!--/ END Template Container -->

            <!-- START To Top Scroller -->
            <a href="#" class="totop animation" data-toggle="waypoints totop" data-marker="#main" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="-50%"><i class="ico-angle-up"></i></a>
            <!--/ END To Top Scroller -->
        </section>
        <!--/ END Template Main -->

        <!-- START Template Sidebar (right) -->
        <aside class="sidebar sidebar-right">
            <!-- START Sidebar Content -->
            <section class="content slimscroll">
                <!-- START Sidebar Profile -->
                <!-- START Panel -->
				<div class="panel">
				    <!-- thumbnail -->
				    <div class="thumbnail">
				        <!-- media -->
				        <div class="media">
				            <!-- meta -->
				            <span class="meta text-center">
				                <h5 class="semibold mb0">Erich Reyes</h5>
				                <p class="nm"><i class="ico-user7 mr5"></i>Administrator</p>
				            </span>
				            <!-- meta -->
				            <!-- indicator -->
				            <div class="indicator"><span class="spinner"></span></div>
				            <!--/ indicator -->
				            <img data-toggle="unveil" src="image/background/400x250/placeholder.jpg" data-src="image/background/400x250/background3.jpg" alt="Cover" width="100%">
				        </div>
				        <!--/ media -->
				    </div>
				    <!--/ thumbnail -->
				    <!-- panel body -->
				    <div class="panel-body" style="margin-top:-55px;z-index:2;">
				        <ul class="list-unstyled">
				            <li class="text-center">
				                <img class="img-circle" src="image/avatar/avatar7.jpg" alt="" width="75px" height="75px">
				                <br>
				                <!-- dropdown -->
				                <div class="btn-group mt10">
				                    <button type="button" class="btn btn-default"><span class="hasnotification hasnotification-success mr5"></span>Online</button>
				                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
				                    <ul class="dropdown-menu" role="menu">
				                        <li><a href="#">Away</a></li>
				                        <li><a href="#">Offline</a></li>
				                        <li><a href="#">Busy</a></li>
				                    </ul>
				                </div>
				                <!--/ dropdown -->
				            </li>
				        </ul>
				    </div>
				    <!--/ panel body -->
				</div>
				<!--/ END Panel -->
                <!--/ END Sidebar Profile -->

                <!-- START Sidebar contact -->
                <div class="media-list media-list-contact">
				    <a href="javascript:void(0);" class="media">
				        <span class="media-object pull-left">
				            <img src="image/avatar/avatar1.jpg" class="img-circle" alt="">
				        </span>
				        <span class="media-body">
				            <span class="media-heading"><span class="hasnotification hasnotification-success mr5"></span> Autumn Barker</span>
				            <span class="media-meta ellipsis">Malaysia</span>
				        </span>
				    </a>
				
				    <a href="javascript:void(0);" class="media">
				        <span class="media-object pull-left">
				            <img src="image/avatar/avatar2.jpg" class="img-circle" alt="">
				        </span>
				        <span class="media-body">
				            <span class="media-heading"><span class="hasnotification hasnotification-success mr5"></span> Giselle Horn</span>
				            <span class="media-meta ellipsis">Bolivia</span>
				        </span>
				    </a>
				
				    <a href="javascript:void(0);" class="media">
				        <span class="media-object pull-left">
				            <img src="image/avatar/avatar.png" class="img-circle" alt="">
				        </span>
				        <span class="media-body">
				            <span class="media-heading"><span class="hasnotification hasnotification-danger mr5"></span> Austin Shields</span>
				            <span class="media-meta ellipsis">Timor-Leste</span>
				        </span>
				    </a>
				
				    <a href="javascript:void(0);" class="media">
				        <span class="media-object pull-left">
				            <img src="image/avatar/avatar.png" class="img-circle" alt="">
				        </span>
				        <span class="media-body">
				            <span class="media-heading"><span class="hasnotification hasnotification-danger mr5"></span> Caryn Gibson</span>
				            <span class="media-meta ellipsis">Libya</span>
				        </span>
				    </a>
				
				    <a href="javascript:void(0);" class="media">
				        <span class="media-object pull-left">
				            <img src="image/avatar/avatar3.jpg" class="img-circle" alt="">
				        </span>
				        <span class="media-body">
				            <span class="media-heading"><span class="hasnotification hasnotification-success mr5"></span> Nash Evans</span>
				            <span class="media-meta ellipsis">Honduras</span>
				        </span>
				    </a>
				
				    <a href="javascript:void(0);" class="media">
				        <span class="media-object pull-left">
				            <img src="image/avatar/avatar4.jpg" class="img-circle" alt="">
				        </span>
				        <span class="media-body">
				            <span class="media-heading"><span class="hasnotification hasnotification-default mr5"></span> Josiah Johnson</span>
				            <span class="media-meta ellipsis">Belgium</span>
				        </span>
				    </a>
				
				    <a href="javascript:void(0);" class="media">
				        <span class="media-object pull-left">
				            <img src="image/avatar/avatar.png" class="img-circle" alt="">
				        </span>
				        <span class="media-body">
				            <span class="media-heading"><span class="hasnotification hasnotification-default mr5"></span> Philip Hewitt</span>
				            <span class="media-meta ellipsis">Bahrain</span>
				        </span>
				    </a>
				
				    <a href="javascript:void(0);" class="media">
				        <span class="media-object pull-left">
				            <img src="image/avatar/avatar5.jpg" class="img-circle" alt="">
				        </span>
				        <span class="media-body">
				            <span class="media-heading"><span class="hasnotification hasnotification-default mr5"></span> Wilma Hunt</span>
				            <span class="media-meta ellipsis">Dominica</span>
				        </span>
				    </a>
				
				    <a href="javascript:void(0);" class="media">
				        <span class="media-object pull-left">
				            <img src="image/avatar/avatar6.jpg" class="img-circle" alt="">
				        </span>
				        <span class="media-body">
				            <span class="media-heading"><span class="hasnotification hasnotification-success mr5"></span> Noah Gill</span>
				            <span class="media-meta ellipsis">Guatemala</span>
				        </span>
				    </a>
				
				    <a href="javascript:void(0);" class="media">
				        <span class="media-object pull-left">
				            <img src="image/avatar/avatar8.jpg" class="img-circle" alt="">
				        </span>
				        <span class="media-body">
				            <span class="media-heading"><span class="hasnotification hasnotification-success mr5"></span> David Fisher</span>
				            <span class="media-meta ellipsis">French Guiana</span>
				        </span>
				    </a>
				
				    <a href="javascript:void(0);" class="media">
				        <span class="media-object pull-left">
				            <img src="image/avatar/avatar9.jpg" class="img-circle" alt="">
				        </span>
				        <span class="media-body">
				            <span class="media-heading"><span class="hasnotification hasnotification-success mr5"></span> Samantha Avery</span>
				            <span class="media-meta ellipsis">Jersey</span>
				        </span>
				    </a>
				
				    <a href="javascript:void(0);" class="media">
				        <span class="media-object pull-left">
				            <img src="image/avatar/avatar.png" class="img-circle" alt="">
				        </span>
				        <span class="media-body">
				            <span class="media-heading"><span class="hasnotification hasnotification-success mr5"></span> Madaline Medina</span>
				            <span class="media-meta ellipsis">Finland</span>
				        </span>
				    </a>
				</div>
                <!--/ END Sidebar contact -->
            </section>
            <!--/ END Sidebar Content -->
        </aside>
        <!--/ END Template Sidebar (right) -->

        <!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->
		<!-- Library script : mandatory -->
		<script src="<?php echo get_template_directory_uri(); ?>/assets/library/jquery/js/jquery.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/assets/library/jquery/js/jquery-ui.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/assets/library/jquery/js/jquery-ui-touch.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/assets/library/jquery/js/jquery-migrate.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/assets/library/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/assets/library/core/js/core.min.js"></script>
		<!--/ Library script -->
		
		<!-- application script -->
		
		<script src="<?php echo get_template_directory_uri(); ?>/assets/plugins/magnific/js/jquery.magnific-popup.min.js"></script>
		
		<script src="<?php echo get_template_directory_uri(); ?>/assets/javascript/app.min.js"></script>
		<!--/ application script -->
		<!--/ END JAVASCRIPT SECTION -->
    </body>

<!-- Mirrored from pampersdry.info/theme/adminre/html/page-profile.html by HTTrack Website Copier/3.x [XR&CO'2013], Fri, 21 Mar 2014 01:45:38 GMT -->
</html>