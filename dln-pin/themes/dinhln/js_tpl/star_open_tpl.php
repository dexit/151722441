<div>
	<div class="pbody" data-title="{lang set_staruser_cover}" data-width="750" data-css-class="publish-select">
	{{#data}}
		<div class="home-staruser">
			<div class="span3 text_c ml10">
				<img src="{{image_path}}" style="max-height:200px;margin-top: 20px">
			</div>
			<div class="span6 star-with-pic clearfix mb10 mr10">
				<div class="star-info">
					<dl class="cls">
						<dt class="pull-left">
							<a href="{{home}}" class="user-headimage"><img src="{{avatar}}" class="avatar photo-middle"></a>
						</dt>
						<dd>
							<p class="name"><strong><a href="{{home}}" target="_blank">{{nickname}}</a></strong></p>
							<p class="auth">{{user_title}}</p>
							<p class="desc">{lang user_description}：{{bio}}</p>
							<p class="love"><em class="num">{{total_likes}}</em>{lang like}</p>
						</dd>
					</dl>
				</div>
				<ul class="nav nav-pills mb10">
				  <li id="link_star_1" class="active"><a href="javascript:void(0);" data-action="switchPushStyle" data-params="star_1">{lang style_1}</a></li>
				  <li id="link_star_2"><a href="javascript:void(0);" data-action="switchPushStyle" data-params="star_2">{lang style_2}</a></li>
				  <li id="link_star_3"><a href="javascript:void(0);" data-action="switchPushStyle" data-params="star_3">{lang style_3}</a></li>
				</ul>
				<div class="gallery" id="push_star_1">
					<div class="staruser-pic-151-180"><a href="javascript:void(0);" data-action="openCrop" class="pos1" data-params="1,151:180">{{#star_cover.s1_image_path}}<img src="<?php echo base_url_r()?>{{star_cover.s1_image_path}}_star.jpg?{{rand}}" onerror="this.src='<?php echo base_url()?>assets/img/pin_button.png';"/>{{/star_cover.s1_image_path}}{{^star_cover.s1_image_path}}<img src="<?php echo base_url()?>assets/img/pin_button.png" style="margin-top: 60px;">{{/star_cover.s1_image_path}}</a></div>
					<div class="staruser-pic-151-180"><a href="javascript:void(0);" data-action="openCrop" class="pos2" data-params="2,151:180">{{#star_cover.s2_image_path}}<img src="<?php echo base_url_r()?>{{star_cover.s2_image_path}}_star.jpg?{{rand}}" onerror="this.src='<?php echo base_url()?>assets/img/pin_button.png';"/>{{/star_cover.s2_image_path}}{{^star_cover.s2_image_path}}<img src="<?php echo base_url()?>assets/img/pin_button.png" style="margin-top: 60px;">{{/star_cover.s2_image_path}}</a></div>
					<div class="staruser-pic-151-180"><a href="javascript:void(0);" data-action="openCrop" class="pos3" data-params="3,151:180">{{#star_cover.s3_image_path}}<img src="<?php echo base_url_r()?>{{star_cover.s3_image_path}}_star.jpg?{{rand}}" onerror="this.src='<?php echo base_url()?>assets/img/pin_button.png';"/>{{/star_cover.s3_image_path}}{{^star_cover.s3_image_path}}<img src="<?php echo base_url()?>assets/img/pin_button.png" style="margin-top: 60px;">{{/star_cover.s3_image_path}}</a></div>
				</div>
				<div class="gallery hide" id="push_star_2">
					<div class="staruser-pic-304-180"><a href="javascript:void(0);" data-action="openCrop" class="pos1" data-params="1,304:180">{{#star_cover.s1_image_path}}<img src="<?php echo base_url_r()?>{{star_cover.s1_image_path}}_star.jpg?{{rand}}" onerror="this.src='<?php echo base_url()?>assets/img/pin_button.png';"/>{{/star_cover.s1_image_path}}{{^star_cover.s1_image_path}}<img src="<?php echo base_url()?>assets/img/pin_button.png" style="margin-top: 60px;">{{/star_cover.s1_image_path}}</a></div>
					<div class="staruser-pic-151-180"><a href="javascript:void(0);" data-action="openCrop" class="pos2" data-params="2,151:180">{{#star_cover.s2_image_path}}<img src="<?php echo base_url_r()?>{{star_cover.s2_image_path}}_star.jpg?{{rand}}" onerror="this.src='<?php echo base_url()?>assets/img/pin_button.png';"/>{{/star_cover.s2_image_path}}{{^star_cover.s2_image_path}}<img src="<?php echo base_url()?>assets/img/pin_button.png" style="margin-top: 60px;">{{/star_cover.s2_image_path}}</a></div>
				</div>
				<div class="gallery hide" id="push_star_3">
					<div class="staruser-pic-151-180"><a href="javascript:void(0);" data-action="openCrop" class="pos1" data-params="1,151:180">{{#star_cover.s1_image_path}}<img src="<?php echo base_url_r()?>{{star_cover.s1_image_path}}_star.jpg?{{rand}}" onerror="this.src='<?php echo base_url()?>assets/img/pin_button.png';"/>{{/star_cover.s1_image_path}}{{^star_cover.s1_image_path}}<img src="<?php echo base_url()?>assets/img/pin_button.png" style="margin-top: 60px;">{{/star_cover.s1_image_path}}</a></div>
					<div class="staruser-pic-304-180"><a href="javascript:void(0);" data-action="openCrop" class="pos2" data-params="2,304:180">{{#star_cover.s2_image_path}}<img src="<?php echo base_url_r()?>{{star_cover.s2_image_path}}_star.jpg?{{rand}}" onerror="this.src='<?php echo base_url()?>assets/img/pin_button.png';"/>{{/star_cover.s2_image_path}}{{^star_cover.s2_image_path}}<img src="<?php echo base_url()?>assets/img/pin_button.png" style="margin-top: 60px;">{{/star_cover.s2_image_path}}</a></div>
				</div>
			</div>
			<div class="buttons">
    			<div id="ajax_share_message" class="pull-left"></div>
    			<button type="submit" data-action="closePushDialog" class="btn btn-primary pull-right mr20 mb10">{lang submit}</button>
    		</div>
		</div>
	{{/data}}
	</div>
</div>