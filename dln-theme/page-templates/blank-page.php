<?php
/**
 * Template Name: Blank Page
 */
?>
<!-- START Template Main -->
	<section id="main" role="main">
		<!-- START Template Container -->
		<div class="container-fluid">

		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', 'page' ); ?>
		<?php endwhile; // end of the loop. ?>
		
		<!-- START To Top Scroller -->
		<a href="#" class="totop animation" data-toggle="waypoints totop"
			data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="50%"><i
			class="ico-angle-up"></i></a>
		<!--/ END To Top Scroller -->

	</section>
	<!--/ END Template Main -->
