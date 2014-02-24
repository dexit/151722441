<?php do_action( 'bp_before_blog_search_form' ); ?>
<form id="searchform" role="search" method="get" class="searchform" action="<?php echo home_url(); ?>/">
	<input type="text" class="form-control" placeholder="<?php echo __('Search here', 'dln-news-theme') ?>..." value="<?php the_search_query(); ?>" name="s" id="s" />
	<?php do_action( 'bp_blog_search_form' ); ?>
</form>
<?php do_action( 'bp_after_blog_search_form' ); ?>
