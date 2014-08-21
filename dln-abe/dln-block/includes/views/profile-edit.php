<?php

if ( ! defined( 'WPINC' ) ) { die; }

?>
<!-- START row -->
<div
	class="row">
	<!-- Left / Top Side -->
	<div class="col-lg-3">
		<!-- tab menu -->
		<ul class="list-group list-group-tabs">
			<li class="list-group-item active"><a href="#profile"
				data-toggle="tab"><i class="ico-user2 mr5"></i> Profile</a></li>
			<li class="list-group-item"><a href="#account" data-toggle="tab"><i
					class="ico-archive2 mr5"></i> Account</a></li>
		</ul>
		<!-- tab menu -->

		<hr>
		<!-- horizontal line -->

		<!-- figure with progress -->
		<ul class="list-table">
			<li style="width: 70px;"><img class="img-circle img-bordered"
				src="../image/avatar/avatar7.jpg" alt="" width="65px">
			</li>
			<li class="text-left">
				<h5 class="semibold ellipsis mt0">Erich Reyes</h5>
				<div style="max-width: 200px;">
					<div class="progress progress-xs mb5">
						<div class="progress-bar progress-bar-warning" style="width: 70%"></div>
					</div>
					<p class="text-muted clearfix nm">
						<span class="pull-left">Profile complete</span> <span
							class="pull-right">70%</span>
					</p>
				</div>
			</li>
		</ul>
		<!--/ figure with progress -->

		<hr>
		<!-- horizontal line -->

		<!-- follower stats -->
		<ul class="nav nav-section nav-justified mt15">
			<li>
				<div class="section">
					<h4 class="nm semibold">12.5k</h4>
					<p class="nm text-muted">Followers</p>
				</div>
			</li>
			<li>
				<div class="section">
					<h4 class="nm semibold">1853</h4>
					<p class="nm text-muted">Following</p>
				</div>
			</li>
			<li>
				<div class="section">
					<h4 class="nm semibold">3451</h4>
					<p class="nm text-muted">Tweets</p>
				</div>
			</li>
		</ul>
		<!--/ follower stats -->
	</div>
	<!--/ Left / Top Side -->

	<!-- Left / Bottom Side -->
	<div class="col-lg-9">
		<!-- START Tab-content -->
		<div class="tab-content">
			<!-- tab-pane: profile -->
			<div class="tab-pane active" id="profile">
				<!-- form profile -->
				<form class="panel form-horizontal form-bordered"
					name="form-profile">
					<div class="panel-body pt0 pb0">
					
						<div class="form-group header bgcolor-default">
							<div class="col-md-12">
								<h4 class="semibold text-primary nm"><?php _e( 'Facebook', DLN_ABE ) ?></h4>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">&nbsp;</label>
							<div class="col-sm-9">
								<div class="btn-group pr5">
									<img class="img-circle img-bordered"
										src="../image/avatar/avatar7.jpg" alt="" width="34px">
								</div>
								<a href="javascript:void(0);" class="btn btn-facebook"><?php _e( 'Login to Facebook', DLN_ABE )?></a>
								<p class="help-block"><?php _e( 'to manage your connection with Facebook.', DLN_ABE ) ?></p>
							</div>
						</div>
						
						<div class="form-group header bgcolor-default">
							<div class="col-md-12">
								<h4 class="semibold text-primary nm"><?php _e( 'Instagram', DLN_ABE ) ?></h4>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">&nbsp;</label>
							<div class="col-sm-9">
								<div class="btn-group pr5">
									<img class="img-circle img-bordered"
										src="../image/avatar/avatar7.jpg" alt="" width="34px">
								</div>
								<a href="javascript:void(0);" class="btn btn-twitter"><?php _e( 'Login to Instagram', DLN_ABE )?></a>
								<p class="help-block"><?php _e( 'to manage your connection with Instagram.', DLN_ABE ) ?></p>
							</div>
						</div>
					
						<div class="form-group header bgcolor-default">
							<div class="col-md-12">
								<h4 class="semibold text-primary mt0 mb5">Profile</h4>
								<p class="text-default nm">This information appears on your
									public profile, search results, and beyond.</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Photo</label>
							<div class="col-sm-9">
								<div class="btn-group pr5">
									<img class="img-circle img-bordered"
										src="../image/avatar/avatar7.jpg" alt="" width="34px">
								</div>
								<div class="btn-group">
									<button type="button" class="btn btn-default">Change photo</button>
									<button type="button" class="btn btn-default dropdown-toggle"
										data-toggle="dropdown">
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="#">Upload photo</a></li>
										<li><a href="#">Remove</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Name</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="name"
									value="Erich Reyes">
								<p class="help-block">Enter your real name.</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Location</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="location">
								<p class="help-block">Where in the world are you?</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Website</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="website"
									value="http://">
								<p class="help-block">Have a homepage or a blog? Put the address
									here.</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Bio</label>
							<div class="col-sm-6">
								<textarea class="form-control" rows="3"
									placeholder="Describe about yourself"></textarea>
								<p class="help-block">About yourself in 160 characters or less.</p>
							</div>
						</div>
						
					</div>
					<div class="panel-footer">
						<button type="reset" class="btn btn-default">Reset</button>
						<button type="submit" class="btn btn-primary">Save change</button>
					</div>
				</form>
				<!--/ form profile -->
			</div>
			<!--/ tab-pane: profile -->

			<!-- tab-pane: account -->
			<div class="tab-pane" id="account">
				<!-- form account -->
				<form class="panel form-horizontal form-bordered"
					name="form-account">
					<div class="panel-body pt0 pb0">
						<div class="form-group header bgcolor-default">
							<div class="col-md-12">
								<h4 class="semibold text-primary mt0 mb5">Account</h4>
								<p class="text-default nm">Change your basic account and
									language settings.</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Username</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="username"
									value="erich.reyes">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Email</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="email">
								<p class="help-block">
									Email will not be publicly displayed. <a
										href="javascript:void(0);">Learn more.</a>
								</p>
							</div>
						</div>
						<div class="form-group header bgcolor-default">
							<div class="col-md-12">
								<h4 class="semibold text-primary mt0 mb5">Password</h4>
								<p class="text-default nm">Change your password or recover your
									current one.</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Current password</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="currentpass">
								<p class="help-block">
									<a href="javascript:void(0);">Forgot password?</a>
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">New password</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="newpass">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Verify password</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="verifypass">
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<button type="reset" class="btn btn-default">Reset</button>
						<button type="submit" class="btn btn-primary">Save change</button>
					</div>
				</form>
				<!--/ form account -->
			</div>
			<!--/ tab-pane: account -->
		</div>
		<!--/ END Tab-content -->
	</div>
	<!--/ Left / Bottom Side -->
</div>
<!--/ END row -->
