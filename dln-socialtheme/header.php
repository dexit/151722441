<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7]> <html xmlns="http://www.w3.org/1999/xhtml" class="ie lt-ie9 lt-ie8 lt-ie7 fluid sidebar" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html xmlns="http://www.w3.org/1999/xhtml" class="ie lt-ie9 lt-ie8 fluid sticky-top sidebar" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html xmlns="http://www.w3.org/1999/xhtml" class="ie lt-ie9 fluid sticky-top sidebar" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]> <html xmlns="http://www.w3.org/1999/xhtml" class="ie gt-ie8 fluid sticky-top sidebar" <?php language_attributes(); ?>> <![endif]-->
<!--[if !IE]><!--><html xmlns="http://www.w3.org/1999/xhtml" class="fluid sticky-top sidebar" <?php language_attributes(); ?>><!-- <![endif]-->
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
		<?php if ( current_theme_supports( 'bp-default-responsive' ) ) : ?><meta name="viewport" content="width=device-width, initial-scale=1.0" /><?php endif; ?>
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
		<title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		
		<?php bp_head(); ?>
		<?php wp_head(); ?>
		<!--[if IE 7]><link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/assets/fonts/font-awesome/css/font-awesome-ie7.min.css"><![endif]-->

	</head>
	<body <?php body_class() ?>>
		<?php do_action( 'bp_before_header' ) ?>
		