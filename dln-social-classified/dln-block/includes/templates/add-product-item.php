<?php
?>

<div class="panel panel-default overflow-hidden">

	<div class="panel-heading">
		<h5 class="panel-title">Basic example</h5>
	</div>

	<div class="panel-body">
		<div class="row">
			<div class="col-md-6">
				<legend><?php _e( 'Item Photos', DLN_CLF ) ?></legend>

				<div class="form-group">
					<div class="img-grid">
						<ul class="list-unstyled row">
							<li class="col-xs-8">
								<div class="thumbnail">
									<div style="height: 310px;" class="media">
										<!-- indicator -->
										<div class="indicator">
											<span class="spinner"></span>
										</div>
										<!--/ indicator -->
										<!-- toolbar overlay -->

										<!--/ toolbar overlay -->
										<img alt="Photo"
											data-src="http://pampersdry.info/theme/adminre/html/image/background/background8.jpg"
											src="http://pampersdry.info/theme/adminre/html/image/background/background8.jpg"
											data-toggle="unveil" class="unveiled">
									</div>
								</div>
							</li>
							<li class="col-xs-4">
								<ul class="list-unstyled row">
									<li class="col-xs-12">
										<!-- thumbnail -->
										<div class="thumbnail">
											<!-- media -->
											<div style="height: 100px;" class="media">
												<!-- indicator -->
												<div class="indicator">
													<span class="spinner"></span>
												</div>
												<!--/ indicator -->
												<!-- toolbar overlay -->
												<div class="overlay">
													<div class="toolbar">
														<a title="love this collection" class="btn btn-danger"
															href="javascript:void(0);"><i class="ico-heart6"></i></a>
													</div>
												</div>
												<!--/ toolbar overlay -->
												<img alt="Photo"
													data-src="http://pampersdry.info/theme/adminre/html/image/background/background8.jpg"
													src="http://pampersdry.info/theme/adminre/html/image/background/background8.jpg"
													data-toggle="unveil" class="unveiled">
											</div>
											<!--/ media -->
										</div> <!--/ thumbnail -->
									</li>
								</ul>

								<ul class="list-unstyled row">
									<li class="col-xs-12">
										<!-- thumbnail -->
										<div class="thumbnail">
											<!-- media -->
											<div style="height: 100px;" class="media">
												<!-- indicator -->
												<div class="indicator">
													<span class="spinner"></span>
												</div>
												<!--/ indicator -->
												<!-- toolbar overlay -->
												<div class="overlay">
													<div class="toolbar">
														<a title="love this collection" class="btn btn-danger"
															href="javascript:void(0);"><i class="ico-heart6"></i></a>
													</div>
												</div>
												<!--/ toolbar overlay -->
												<img alt="Photo"
													data-src="http://pampersdry.info/theme/adminre/html/image/background/background8.jpg"
													src="http://pampersdry.info/theme/adminre/html/image/background/background8.jpg"
													data-toggle="unveil" class="unveiled">
											</div>
											<!--/ media -->
										</div> <!--/ thumbnail -->
									</li>
								</ul>

								<ul class="list-unstyled row">
									<li class="col-xs-12">
										<!-- thumbnail -->
										<div class="thumbnail">
											<!-- media -->
											<div style="height: 100px;" class="media">
												<!-- indicator -->
												<div class="indicator">
													<span class="spinner"></span>
												</div>
												<!--/ indicator -->
												<!-- toolbar overlay -->
												<div class="overlay">
													<div class="toolbar">
														<a title="love this collection" class="btn btn-danger"
															href="javascript:void(0);"><i class="ico-heart6"></i></a>
													</div>
												</div>
												<!--/ toolbar overlay -->
												<img alt="Photo"
													data-src="http://pampersdry.info/theme/adminre/html/image/background/background8.jpg"
													src="http://pampersdry.info/theme/adminre/html/image/background/background8.jpg"
													data-toggle="unveil" class="unveiled">
											</div>
											<!--/ media -->
										</div> <!--/ thumbnail -->
									</li>
								</ul>

							</li>
						</ul>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<div class="input-group">
								<input type="text" readonly="" class="form-control input-sm"> <span
									class="input-group-btn">
									<div class="btn btn-primary btn-file btn-sm">
										<span class="icon iconmoon-file-3"></span> Upload <input
											type="file">
									</div>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div style="margin-bottom: 0px;"
							class="progress progress-xs progress-striped active">
							<div class="progress-bar progress-bar-infor" style="width: 60%">
								<span class="sr-only">60% Complete (warning)</span>
							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="col-md-6">
				<legend><?php _e( 'Item Settings', DLN_CLF ) ?></legend>

				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<?php echo balanceTags( DLN_Block_Product_Item::get_field( 'basic', 'product_title' ) ) ?>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<?php echo balanceTags( DLN_Block_Product_Item::get_field( 'basic', 'product_category' ) ) ?>
						</div>
						<div class="col-sm-6">
							<?php echo balanceTags( DLN_Block_Product_Item::get_field( 'basic', 'product_price' ) ) ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<?php echo balanceTags( DLN_Block_Product_Item::get_field( 'basic', 'product_desc' ) ) ?>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<div class="checkbox custom-checkbox">
								<?php echo balanceTags( DLN_Block_Product_Item::get_field( 'basic', 'product_swap' ) ) ?>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="checkbox custom-checkbox">
								<?php echo balanceTags( DLN_Block_Product_Item::get_field( 'basic', 'product_gift' ) ) ?>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>

	<div class="panel-footer">
		<div class="checkbox custom-checkbox pull-left">
			<input type="checkbox" name="gift" id="giftcheckbox" value="1"
				data-parsley-mincheck="1" required> <label for="giftcheckbox">&nbsp;&nbsp;Send
				as a gift</label>
		</div>
		<button class="btn btn-primary pull-right" type="submit">Proceed</button>
	</div>
</div>