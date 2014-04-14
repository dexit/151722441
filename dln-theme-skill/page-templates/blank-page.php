<?php
/**
 * Template Name: Blank Page
 */
?>
<?php while ( have_posts() ) : the_post(); ?>
	<?php get_template_part( 'content', 'page' ); ?>
<?php endwhile; // end of the loop. ?>