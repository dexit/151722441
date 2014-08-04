<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<!-- START Template Main -->
	<section id="main" role="main">
		<!-- START Template Container -->
		<div class="container">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>
			
		</div>
		<!-- START To Top Scroller -->
		<a href="#" class="totop animation" data-toggle="waypoints totop"
			data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="50%"><i
			class="ico-angle-up"></i></a>
		<!--/ END To Top Scroller -->

	</section>
	<!--/ END Template Main -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>