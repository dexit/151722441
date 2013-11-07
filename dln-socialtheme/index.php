<?php get_header(); ?>
<?php //get_sidebar(); ?>

<div class="container-fluid fluid menu-left">
	<!-- Sidebar menu & content wrapper -->
	<div id="wrapper">
	
	<!-- Sidebar Menu -->
	<div id="menu" class="hidden-phone hidden-print">

		<!-- Brand -->
		<a href="index.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default&amp;top-sticky=false" class="appbrand">Quick Admin</a>
	
		<!-- Scrollable menu wrapper with Maximum height -->
		<div class="slim-scroll" data-scroll-height="800px">
		
		<!-- Sidebar Profile -->
		<span class="profile center">
			<a href="my_account_advanced.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default&amp;top-sticky=false"><img data-src="holder.js/36x36/white" alt="Avatar" /></a>
		</span>
		<!-- // Sidebar Profile END -->
		
		<!-- Regular Size Menu -->
		<ul>
			<!-- Blank page template menu example -->
			<!-- Menu Regular Item (add class active to LI for an active menu item) -->
			<li class="glyphicons right_arrow"><a href="#"><i></i><span>Menu item</span></a></li>
			<li class="glyphicons right_arrow"><a href="#"><i></i><span>Menu item</span></a></li>
			<li class="glyphicons right_arrow"><a href="#"><i></i><span>Menu item</span></a></li>
			<li class="glyphicons right_arrow"><a href="#"><i></i><span>Menu item</span></a></li>
			<li class="glyphicons right_arrow"><a href="#"><i></i><span>Menu item</span></a></li>
			<!-- // Blank page template menu example END -->		
		</ul>
		<div class="clearfix"></div>
		<!-- // Regular Size Menu END -->
		
		</div>
		<!-- // Scrollable Menu wrapper with Maximum Height END -->
		
	</div>
	<!-- // Sidebar Menu END -->
			
	<!-- Content -->
	<div id="content">
		<!-- Top navbar (note: add class "navbar-hidden" to close the navbar by default) -->
		<div class="navbar main hidden-print">
			<!-- Menu Toggle Button -->
			<button type="button" class="btn btn-navbar">
				<span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
			</button>
			<!-- // Menu Toggle Button END -->
			<ul class="topnav pull-left">
				<li><a href="index.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default&amp;top-sticky=false" class="glyphicons dashboard"><i></i> Dashboard</a></li>
				<li class="dropdown dd-1">
					<a href="" data-toggle="dropdown" class="glyphicons notes"><i></i><?php echo __( 'Pages', DLNSC ) ?></a>
					<ul class="dropdown-menu pull-left">
						<li><a href="#" class="glyphicons history"><i></i><?php echo __( 'Timeline' ) ?></a></li>
					</ul>
				</li>
				<li class="search open">
					<form autocomplete="off" class="dropdown dd-1">
						<input type="text" value="" placeholder="Type for suggestions .." data-toggle="typeahead" />
						<button type="button" class="glyphicons search"><i></i></button>
					</form>
				</li>
			</ul>		
			<!-- Top Menu Right -->
			<ul class="topnav pull-right hidden-phone">
				<!-- Profile / Logout menu -->
				<li class="account dropdown dd-1">
					<a data-toggle="dropdown" href="my_account_advanced.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default&amp;top-sticky=false" class="glyphicons logout lock"><span class="hidden-tablet hidden-phone hidden-desktop-1">mosaicpro</span><i></i></a>
					<ul class="dropdown-menu pull-right">
						<li><a href="my_account_advanced.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default&amp;top-sticky=false" class="glyphicons cogwheel">Settings<i></i></a></li>
						<li><a href="my_account_advanced.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default&amp;top-sticky=false" class="glyphicons camera">My Photos<i></i></a></li>
						<li class="profile">
							<span>
								<span class="heading">Profile <a href="my_account_advanced.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default&amp;top-sticky=false" class="pull-right">edit</a></span>
								<span class="img"></span>
								<span class="details">
									<a href="my_account_advanced.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default&amp;top-sticky=false">Mosaic Pro</a>
									contact@mosaicpro.biz
								</span>
								<span class="clearfix"></span>
							</span>
						</li>
						<li>
							<span>
								<a class="btn btn-default btn-mini pull-right" href="login.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default&amp;top-sticky=false">Sign Out</a>
							</span>
						</li>
					</ul>
				</li>
				<!-- // Profile / Logout menu END -->
			</ul>
			<div class="clearfix"></div>
			<!-- // Top Menu Right END -->
			
		</div>
		<!-- Top navbar END -->
		
		<!-- Container -->
		<div class="container">
			<div class="box-generic">
			    <div class="dln-social-cover">
			    	<img alt="cover photo" src="images/cover/profile/484/1ecf167492047ccb62c8ff72784cdcd4.jpg" class="focusbox-image cover-image" id="484">
			    	<div data-cover-type="cover" data-cover-context="profile" class="dln-social-cover-gradient"></div>
			    </div>
			    <div class="dln-social-content">
			    	<div class="row-fluid">
			    		<div class="span3">
			    			<div class="thumb dln-social-avatar pull-right">
			    				<img alt="Profile" src="images/avatar-2-large.jpg" />
			    			</div>
			    		</div>
			    		<div class="span9">
			    			<div class="row-fluid">
			    				<div class="span12">
			    					<h3 class="dln-social-profile-name">demo1</h3>
			    					<span class="dln-social-rating">
			    						<div class="rating text-faded">
								        	<span class="star"></span>
								        	<span class="star"></span>
								        	<span class="star"></span>
								        	<span class="star active"></span>
								        	<span class="star"></span>
								        </div>
			    					</span>
			    					<div class="dln-social-likes">
			    						<span>3 Likes · 43 views</span>
			    					</div>
			    					
			    				</div>
			    			</div>
			    		</div>
			    	</div>
			    </div>
			</div>
			<div class="dln-social-nav-bar">
				<div class="menubar">
					<ul>
						<li><a href="">Activity</a></li>
						<li class="divider"></li>
						<li><a href="">Group</a></li>
						<li class="divider"></li>
						<li><a href="">Export</a></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- Container END -->
	</div>
	<!-- // Content END -->
</div>
<div class="clearfix"></div>
<!-- // Sidebar menu & content wrapper END -->
	<div id="footer" class="hidden-print">
		<!--  Copyright Line -->
		<div class="copy">&copy; 2012 - 2013 - <a href="http://www.mosaicpro.biz">MosaicPro</a> - All Rights Reserved. <a href="http://themeforest.net/item/quick-admin-template/4940725?ref=mosaicpro" target="_blank">Purchase Quick Admin on ThemeForest</a> - Current version: v1.3.1 / <a target="_blank" href="http://demo.mosaicpro.biz/quickadmin/CHANGELOG">changelog</a></div>
		<!--  End Copyright Line -->
	</div>
	<!-- // Footer END -->
</div>
<!-- // Main Container Fluid END -->

<?php get_footer(); ?>