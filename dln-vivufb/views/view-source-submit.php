<?php
if ( ! defined( 'WPINC' ) ) { die; }
?>
<div class="row m-t">
	<div class="col-sm-12">
		<!-- .breadcrumb -->
		<ul class="breadcrumb">
			<li><a href="#"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="#"><i class="fa fa-list-ul"></i> Elements</a></li>
			<li class="active">Components</li>
		</ul>
		<!-- / .breadcrumb -->
	</div>

	<div class="col-sm-12">
		<div class="m-b-md"> <h3 class="m-b-none"><?php _e( 'Submit Facebook Link' ) ?></h3> </div>
	
		<section class="panel panel-default">
			<header class="panel-heading font-bold"><?php _e( 'Submit Link', DLN_PRO ) ?></header>
			<div class="panel-body">
				<div class="form-horizontal">
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<?php echo balanceTags( DLN_Controller_Source_Submit::get_field( 'basic', 'source_link' ) ) ?>
							</div>
							<div class="line line-dashed b-b line-lg pull-in"></div>
							
							<div class="form-group">
								<?php echo balanceTags( DLN_Controller_Source_Submit::get_field( 'basic', 'source_title' ) ) ?>
							</div>
							<div class="line line-dashed b-b line-lg pull-in"></div>
							
							<div class="form-group">
								<?php echo balanceTags( DLN_Controller_Source_Submit::get_field( 'basic', 'source_category' ) ) ?>
							</div>
							<div class="line line-dashed b-b line-lg pull-in"></div>
							
							<div class="form-group">
								<?php echo balanceTags( DLN_Controller_Source_Submit::get_field( 'basic', 'source_tag' ) ) ?>
							</div>
							<div class="line line-dashed b-b line-lg pull-in"></div>

							<div class="form-group">
								<div class="col-sm-4 col-sm-offset-2">
									<button type="submit" class="btn btn-default"><?php _e( 'Cancel', DLN_VVF ) ?></button>
									<button type="submit" class="btn btn-primary"><?php _e( 'Submit', DLN_VVF ) ?></button>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<section class="panel no-border bg-primary lt">
								<div class="panel-body">
									<div class="row m-t">
										<div class="col-xs-3 text-right padder-v">
											<a id="dln_card_link" href="#" target="_blank" class="btn btn-primary btn-icon btn-rounded m-t-xl"><i class="i i-link"></i> </a>
										</div>
										<div class="col-xs-6 text-center">
											<div class="inline">
												<div class="thumb-lg avatar">
													<img id="dln_card_avatar" src="#" class="dker">
												</div>
												<div class="h4 m-t m-b-xs font-bold text-lt" id="dln_card_name"></div>
												<small class="text-muted m-b" id="dln_card_category"></small>
											</div>
										</div>
										<div class="col-xs-3 padder-v">
											<a id="dln_card_fb" href="#" target="_blank" class="btn btn-primary btn-icon btn-rounded m-t-xl"> <i class="fa fa-facebook-square text"></i></a>
										</div>
									</div>
									<div class="wrapper">
										<div class="row">
											<small id="dln_card_desc"></small>
										</div>
									</div>
								</div>
								<footer class="panel-footer dk text-center no-border">
									<div class="row pull-out">
										<div class="col-xs-6">
											<div class="padder-v">
												<span class="m-b-xs h3 block text-white" id="dln_card_likes"></span>
												<small class="text-muted"><?php _e( 'Likes', DLN_VVF ) ?></small>
											</div>
										</div>
										<div class="col-xs-6 dker">
											<div class="padder-v">
												<span class="m-b-xs h3 block text-white" id="dln_card_count"></span>
												<small class="text-muted"><?php _e( 'Talking About', DLN_VVF ) ?></small>
											</div>
										</div>
									</div>
								</footer>
							</section>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
