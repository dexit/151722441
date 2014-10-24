<?php get_header() ?>

<div class="row">
	<div class="col-md-8">
		<div class="row">
			<div class="post-container">
			
				<?php if ( have_posts() ) : ?>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>
				
				<?php else : ?>
				
					<article id="post-0" class="post no-results not-found">
				
					<?php if ( current_user_can( 'edit_posts' ) ) :
						// Show a different message to a logged-in user who can add posts.
					?>
						<header class="entry-header">
							<h1 class="entry-title"><?php _e( 'No posts to display', 'twentytwelve' ); ?></h1>
						</header>
				
						<div class="entry-content">
							<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'twentytwelve' ), admin_url( 'post-new.php' ) ); ?></p>
						</div><!-- .entry-content -->
				
					<?php else :
						// Show the default message to everyone else.
					?>
						<header class="entry-header">
							<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>
						</header>
				
						<div class="entry-content">
							<p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'twentytwelve' ); ?></p>
							<?php get_search_form(); ?>
						</div><!-- .entry-content -->
					<?php endif; // end current_user_can() check ?>
				
					</article><!-- #post-0 -->
				
				<?php endif; // end have_posts() check ?>
				
				<?php get_footer() ?>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				Collapsible Panel <a class="pull-right" title=""
					data-toggle="tooltip" data-perform="panel-collapse"
					href="javascript:void(0);" data-original-title="Collapse Panel"> <em
					class="fa fa-minus"></em>
				</a>
			</div>
			<div class="dln-filter panel-wrapper collapse in"
				style="height: auto;">
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-6 control-label"><em
								class="fa fa-globe fa-2x dln-fa"></em>Switch</label>
							<div class="col-sm-6">
								<label class="switch"> <input type="checkbox"> <span></span>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label"><em
								class="fa fa-globe fa-2x dln-fa"></em>Switch</label>
							<div class="col-sm-6">
								<label class="switch"> <input type="checkbox"> <span></span>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label"><em
								class="fa fa-globe fa-2x dln-fa"></em>Switch</label>
							<div class="col-sm-6">
								<label class="switch"> <input type="checkbox"> <span></span>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label"><em
								class="fa fa-globe fa-2x dln-fa"></em>Switch</label>
							<div class="col-sm-6">
								<label class="switch"> <input type="checkbox"> <span></span>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label"><em
								class="fa fa-globe fa-2x dln-fa"></em>Switch</label>
							<div class="col-sm-6">
								<label class="switch"> <input type="checkbox"> <span></span>
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">Panel Footer</div>
			</div>

		</div>
	</div>
</div>
