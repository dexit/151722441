<?php
/**
 * Profile Submission Form
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$page_title = '';
$page_description = '';
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo esc_html( $page_title ) ?></h3>
			</div>
			<div class="panel-body">
				<form method="post" id="submit_fashion_form"
					class="profile-manager-form form-horizontal form-bordered"
					enctype="multipart/form-data" data-parsley-validate>

					<!-- Wizard Container 1 -->
					<div class="wizard-title">Customize Order</div>
					<div class="wizard-container">
						<div class="form-group">
							<div class="col-md-12">
								<h5 class="semibold text-primary nm">Customize your shirt order.</h5>
								<p class="text-muted nm">Lorem ipsum dolor sit amet, consectetur
									adipisicing elit, sed do eiusmod tempor incididunt ut labore et
									dolore magna aliqua.</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Shirt type</label>
							<div class="col-sm-5">
								<select class="form-control" name="shirt">
									<option value="">Please choose</option>
									<option value="1">Ninja shirt</option>
									<option value="2">Robot shirt</option>
									<option value="3">Pirate shirt</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Size</label>
							<div class="col-sm-3">
								<select class="form-control" name="size">
									<option value="">Please choose</option>
									<option value="1">Small</option>
									<option value="2">Medium</option>
									<option value="3">Large</option>
									<option value="4">X-Large</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Color</label>
							<div class="col-sm-3">
								<select class="form-control" name="color">
									<option value="">Please choose</option>
									<option value="1">Red</option>
									<option value="2">Purple</option>
									<option value="3">Blue</option>
									<option value="4">Green</option>
								</select>
							</div>
						</div>
					</div>
					<!--/ Wizard Container 1 -->

					<!-- Wizard Container 2 -->
					<div class="wizard-title">Informations</div>
					<div class="wizard-container">
						<div class="form-group">
							<div class="col-md-12">
								<h5 class="semibold text-primary nm">Provide some of your
									details.</h5>
								<p class="text-muted nm">Lorem ipsum dolor sit amet, consectetur
									adipisicing elit, sed do eiusmod tempor incididunt ut labore et
									dolore magna aliqua.</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-4">
								<input type="text" name="first-name" class="form-control"
									placeholder="First Name">
							</div>
							<div class="col-sm-4">
								<input type="text" name="last-name" class="form-control"
									placeholder="Last Name">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Email</label>
							<div class="col-sm-5">
								<input type="text" name="email" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Address</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-12">
										<input type="text" name="street-address"
											class="form-control mb5" placeholder="Street Address">
									</div>
									<div class="col-sm-12">
										<input type="text" name="line2-address"
											class="form-control mb5" placeholder="Address Line 2">
									</div>
									<div class="col-sm-6">
										<input type="text" name="city-address"
											class="form-control mb5" placeholder="City">
									</div>
									<div class="col-sm-6">
										<input type="text" name="state-address"
											class="form-control mb5"
											placeholder="State / Province / Region">
									</div>
									<div class="col-sm-6">
										<input type="text" name="postal-address"
											class="form-control mb5" placeholder="Postal / Zip Code">
									</div>
									<div class="col-sm-6">
										<select class="form-control" name="country-address">
											<option value="xx">Select Country</option>
											<option value="xx">Worldwide</option>
											<option value="af">Afghanistan</option>
											<option value="dz">Algeria</option>
											<option value="ar">Argentina</option>
											<option value="au">Australia</option>
											<option value="bd">Bangladesh</option>
											<option value="br">Brazil</option>
											<option value="cm">Cameroon</option>
											<option value="ca">Canada</option>
											<option value="co">Colombia</option>
											<option value="dk">Denmark</option>
											<option value="eg">Egypt</option>
											<option value="et">Ethiopia</option>
											<option value="fr">France</option>
											<option value="de">Germany</option>
											<option value="gh">Ghana</option>
											<option value="gr">Greece</option>
											<option value="in">India</option>
											<option value="id">Indonesia</option>
											<option value="iq">Iraq</option>
											<option value="ie">Ireland</option>
											<option value="il">Israel</option>
											<option value="it">Italy</option>
											<option value="jp">Japan</option>
											<option value="ke">Kenya</option>
											<option value="mg">Madagascar</option>
											<option value="my">Malaysia</option>
											<option value="mx">Mexico</option>
											<option value="ma">Morocco</option>
											<option value="mz">Mozambique</option>
											<option value="np">Nepal</option>
											<option value="nl">Netherlands</option>
											<option value="nz">New Zealand</option>
											<option value="ng">Nigeria</option>
											<option value="pk">Pakistan</option>
											<option value="pe">Peru</option>
											<option value="ph">Philippines</option>
											<option value="pl">Poland</option>
											<option value="ro">Romania</option>
											<option value="ru">Russia</option>
											<option value="sa">Saudi Arabia</option>
											<option value="sg">Singapore</option>
											<option value="za">South Africa</option>
											<option value="kr">South Korea</option>
											<option value="es">Spain</option>
											<option value="lk">Sri Lanka</option>
											<option value="se">Sweden</option>
											<option value="ch">Switzerland</option>
											<option value="tw">Taiwan</option>
											<option value="tz">Tanzania</option>
											<option value="th">Thailand</option>
											<option value="tr">Turkey</option>
											<option value="ug">Uganda</option>
											<option value="ua">Ukraine</option>
											<option value="gb">United Kingdom</option>
											<option value="us">United States</option>
											<option value="uz">Uzbekistan</option>
											<option value="ve">Venezuela</option>
											<option value="vn">Vietnam</option>
											<option value="ye">Yemen</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--/ Wizard Container 2 -->

					<!-- Wizard Container 3 -->
					<div class="wizard-title">Payment</div>
					<div class="wizard-container">
						<div class="form-group">
							<div class="col-md-12">
								<h5 class="semibold text-primary nm">Proceed to payment</h5>
								<p class="text-muted nm">Lorem ipsum dolor sit amet, consectetur
									adipisicing elit, sed do eiusmod tempor incididunt ut labore et
									dolore magna aliqua.</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Card number</label>
							<div class="col-sm-5">
								<input type="text" name="card-number" class="form-control"
									data-mask="9999-9999-9999-9999">
							</div>
							<div class="col-sm-5">
								<input type="text" name="security-code" class="form-control"
									placeholder="Security code">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Name on card</label>
							<div class="col-sm-5">
								<input type="text" name="card-holder" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Expiration</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<select name="month" class="form-control">
											<option value="">Month</option>
											<option value="1">January</option>
											<option value="2">February</option>
											<option value="3">March</option>
											<option value="4">April</option>
											<option value="5">May</option>
											<option value="6">June</option>
											<option value="7">July</option>
											<option value="8">August</option>
											<option value="9">September</option>
											<option value="10">October</option>
											<option value="11">November</option>
											<option value="12">December</option>
										</select>
									</div>
									<div class="col-sm-4">
										<select name="year" class="form-control">
											<option value="">Year</option>
											<option value="1">2014</option>
											<option value="2">2015</option>
											<option value="3">2016</option>
											<option value="4">2017</option>
											<option value="5">2018</option>
											<option value="6">2019</option>
											<option value="7">2020</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--/ Wizard Container 3 -->

					<div>
						<?php wp_nonce_field( 'submit_fashion_posted' ); ?>
						<input type="hidden" id="fashion_id" name="fashion_id"
								value="<?php echo esc_attr( $fashion_id ) ?>" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- START To Top Scroller -->
<a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="50%"><i class="ico-angle-up"></i></a>
<!--/ END To Top Scroller -->

<script type="text/javascript">
(function ($) {
	$(document).ready(function () {
		 $("#submit_fashion_form").steps({
		        headerTag: ".wizard-title",
		        bodyTag: ".wizard-container",
		        onFinished: function () {
		            // do anything here ;)
		            alert("finished!");
		        }
		    });
	});
})(jQuery);
</script>