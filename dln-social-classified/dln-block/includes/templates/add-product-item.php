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
						<div style="margin-bottom: 0px;" class="progress progress-xs progress-striped active">
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
							<label class="control-label">Title <span class="text-danger">*</span></label>
							<input type="text" required="" data-parsley-type="email"
								class="form-control" name="email" data-parsley-id="3808">
							<ul class="parsley-errors-list" id="parsley-id-3808"></ul>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<label class="control-label">Category <span class="text-danger">*</span></label>
							<select name="type" class="form-control" required>
								<option value="">Select</option>
								<option value="1">Ninja shirt</option>
								<option value="2">Pirate shirt</option>
								<option value="3">Bobo shirt</option>
							</select>
						</div>
						<div class="col-sm-6">
							<label class="control-label">Brand <span class="text-danger">*</span></label>
							<select name="type" class="form-control" required>
								<option value="">Select</option>
								<option value="1">Ninja shirt</option>
								<option value="2">Pirate shirt</option>
								<option value="3">Bobo shirt</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<label class="control-label">Size <span class="text-danger">*</span></label>
							<select name="size" class="form-control" required>
								<option value="">Select</option>
								<option value="1">S</option>
								<option value="2">M</option>
								<option value="3">L</option>
								<option value="3">XL</option>
							</select>
						</div>
						<div class="col-sm-6">
							<label class="control-label">Color <span class="text-danger">*</span></label>
							<select name="color" class="form-control" required>
								<option value="">Select</option>
								<option value="1">Red</option>
								<option value="2">Green</option>
								<option value="3">Yellow</option>
								<option value="3">Purple</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label">Description <span
								class="text-danger">*</span></label>
							<textarea rows="3" class="form-control" placeholder="#123"></textarea>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox custom-checkbox">
						<input type="checkbox" name="gift" id="giftcheckbox" value="1"
							data-parsley-mincheck="1" required> <label for="giftcheckbox">&nbsp;&nbsp;Send
							as a gift</label>
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