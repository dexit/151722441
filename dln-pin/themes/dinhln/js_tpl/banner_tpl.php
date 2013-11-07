<div>
	<div class="pbody" data-title="{lang set_your_banner}" data-width="600" data-css-class="publish-select">
		<div id="upload_banner_div" style="height:180px;">
			<div class="banner_div">
				<div id="banner_img_div" class="image-bg text_c"><img src="<?php echo base_url_r().$current_user['avatar_local'].'_banner.jpg';?>" onerror="javascript:this.src = base_url + 'assets/img/default_banner.jpg';" style="max-height:133px;"/></div>
			</div>
			<div class="text_c mt10">
	   			<a href="javascript:;" id="banner_upload_btn" class="btn btn-success">{lang upload_pic}</a>
	   		</div>
			<input type="hidden" id="banner_upload_file"/>
			<input type="hidden" id="banner_groupid"/>
			<input type="hidden" id="banner_topicid"/>
			<input type="hidden" id="banner_type"/>
		</div>
	</div>
	<div class="footer">
		<span id="saveBannerBtn">
			<button type="submit" data-action="saveBanner" enable="false" class="btn btn-primary">{lang submit}</button>
		</span>
	</div>
</div>