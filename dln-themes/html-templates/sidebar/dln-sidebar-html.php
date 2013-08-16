<?php 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php 

$notifications = dln_get_current_notification();
$count_other = $count_message = 0;
if ( $notifications )
{
	foreach ( $notifications as $i => $notify )
	{
		if ( $notify->type == 'messages' )
		{
			$count_message++;
		} else {
			$count_other++;
		}
	}
}

?>
<div id="dln-user-tools" class="clearfix">
        
        	<!-- Notifications -->
        	<div id="dln-user-notif" class="dln-dropdown-menu">
            	<a href="#" data-toggle="dropdown" class="dln-dropdown-trigger"><i class="icon-exclamation-sign"></i></a>
                
                <!-- Unread notification count -->
                <span class="dln-dropdown-notif"><?php echo $count_other ?></span>
                
                <!-- Notifications dropdown -->
                <div class="dln-dropdown-box">
                	<div class="dln-dropdown-content">
                        <ul class="dln-notifications">
                        	<?php 
							if ( $notifications )
							{
								foreach ( $notifications as $i => $item )
								{
									if ( $item->type != 'messages' )
									{
										echo '<li class="read">
				                            	<a href="' . $item->href . '">
				                                    <span class="message">
				                                        ' . $item->content . '
				                                    </span>
				                                    <span class="time">
				                                        ' . $item->send_time . '
				                                    </span>
				                                </a>
				                            </li>';
									}
								}
							}
                        	?>
                        </ul>
                        <div class="dln-dropdown-viewall">
	                        <a href="#">View All Notifications</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Messages -->
            <div id="dln-user-message" class="dln-dropdown-menu">
            	<a href="#" data-toggle="dropdown" class="dln-dropdown-trigger"><i class="icon-envelope"></i></a>
                
                <!-- Unred messages count -->
                <span class="dln-dropdown-notif">35</span>
                
                <!-- Messages dropdown -->
                <div class="dln-dropdown-box">
                	<div class="dln-dropdown-content">
                        <ul class="dln-messages">
                        	<li class="read">
                            	<a href="#">
                                    <span class="sender">John Doe</span>
                                    <span class="message">
                                        Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="read">
                            	<a href="#">
                                    <span class="sender">John Doe</span>
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="unread">
                            	<a href="#">
                                    <span class="sender">John Doe</span>
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="unread">
                            	<a href="#">
                                    <span class="sender">John Doe</span>
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="dln-dropdown-viewall">
	                        <a href="#">View All Messages</a>
                        </div>
                    </div>
                </div>
            </div>
			
			<div class="dln-dropdown-menu" id="dln-user-profile">
				<a class="dln-dropdown-trigger" data-toggle="dropdown" href="#">
					<div id="dln-user-photo">
						<img src="<?php echo get_template_directory_uri() ?>/assets/example/profile.jpg" alt="User Photo">
	                </div>
	                <span>Lê Nhất Định</span>
                </a>
                
                <!-- Messages dropdown -->
                <div class="dln-dropdown-box">
                	<div class="dln-dropdown-content">
                        <ul class="dln-profile clearfix">
                            <li>
                                <a href="#"><span><i class="icol-cog"></i> <?php echo __( 'Thiết lập', 'dln_theme' ) ?></span></a>
                            </li>
                            <li>
                                <a href="#"><span><i class="icol-door-in"></i> <?php echo __( 'Đăng xuất', 'dln_theme' ) ?></span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>