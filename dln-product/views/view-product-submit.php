<?php
?>
<section class="row m-b-md">
	<div class="col-sm-6">
		<h3 class="m-b-xs text-black">Dashboard</h3>
		<small>Welcome back, John Smith, <i
			class="fa fa-map-marker fa-lg text-primary"></i> New York City
		</small>
	</div>
	<div class="col-sm-6 text-right text-left-xs m-t-md">
		<div class="btn-group">
			<a data-toggle="dropdown"
				class="btn btn-rounded btn-default b-2x dropdown-toggle">Widgets <span
				class="caret"></span>
			</a>
			<ul class="dropdown-menu text-left pull-right">
				<li><a href="#">Notification</a></li>
				<li><a href="#">Messages</a></li>
				<li><a href="#">Analysis</a></li>
				<li class="divider"></li>
				<li><a href="#">More settings</a></li>
			</ul>
		</div>
		<a class="btn btn-icon b-2x btn-default btn-rounded hover" href="#"><i
			class="i i-bars3 hover-rotate"></i> </a> <a
			data-toggle="class:nav-xs, show"
			class="btn btn-icon b-2x btn-info btn-rounded" href="#nav, #sidebar"><i
			class="fa fa-bars"></i> </a>
	</div>
</section>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<section class="panel panel-default">
				<header class="panel-heading font-bold"><?php _e( 'Add Product', DLN_PRO ) ?></header>
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php _e( 'Product Images', DLN_PRO ) ?>
							</label>
							<div class="col-sm-10">
								<div class="dropfile visible-lg">
									
								</div>
							</div>
						</div>
						
						<div class="line line-dashed b-b line-lg pull-in"></div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php _e( 'Product Title', DLN_PRO ) ?>
							</label>
							<div class="col-sm-10">
								<input type="text" id="dln_product_title" name="dln_product_title" class="form-control" placeholder="<?php _e( 'Product Title', DLN_PRO ) ?>" value="" />
							</div>
						</div>
						
						<div class="line line-dashed b-b line-lg pull-in"></div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php _e( 'Product Price', DLN_PRO ) ?>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-md-6">
										<div class="input-group">
											<input type="text" id="dln_product_price" name="dln_product_price" class="form-control" placeholder="<?php _e( 'Price', DLN_PRO ) ?>" value="" />
											<span class="input-group-addon"><?php _e( '000 đ', DLN_PRO ) ?></span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<input type="text" id="dln_product_price_sale" name="dln_product_price_sale" class="form-control" placeholder="<?php _e( 'Price Sale', DLN_PRO ) ?>" value="" />
											<span class="input-group-addon"><?php _e( '000 đ', DLN_PRO ) ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="line line-dashed b-b line-lg pull-in"></div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php _e( 'Product Attribute', DLN_PRO ) ?>
							</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-md-6">
										<input type="text" id="dln_product_category" name="dln_product_category" class="form-control" placeholder="<?php _e( 'Category', DLN_PRO ) ?>" value="" />
									</div>
									<div class="col-md-6">
										<input type="text" id="dln_product_tag" name="dln_product_tag" class="form-control" placeholder="<?php _e( 'Tags', DLN_PRO ) ?>" value="" />
									</div>
								</div>
							</div>
						</div>
						
						<div class="line line-dashed b-b line-lg pull-in"></div>
						
					</div>
				</div>
			</section>
		</div>
	</div>
</div>

