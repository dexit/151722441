<div>
	<div class="pbody" data-title="{lang p_create_avatar}" data-width="600" data-css-class="publish-select">
		<div id="upload_avatar_div" style="height:225px;">
			<div class="avatar_div cls">
				<div id="avatar_img_div" class="image-bg text_c pull-left image-bg" style="margin-left: 70px; width:180px;height:180px;"></div>
				<div id="avatar_large_div" class="image-bg text_c pull-left ml10"><img src="<?php echo base_url_r().$current_user['avatar_local'].'_large.jpg';?>" onerror="javascript:this.src = base_url + 'assets/img/avatar_large.jpg';"/></div>
				<div id="avatar_middle_div" class="image-bg text_c pull-left ml10"><img src="<?php echo base_url_r().$current_user['avatar_local'].'_middle.jpg';?>" onerror="javascript:this.src = base_url + 'assets/img/avatar_middle.jpg';"/></div>
				<div id="avatar_small_div" class="image-bg text_c pull-left ml10"><img src="<?php echo base_url_r().$current_user['avatar_local'].'_small.jpg';?>" onerror="javascript:this.src = base_url + 'assets/img/avatar_small.jpg';"/></div>
			</div>
			<div class="text_c mt10">
	   			<a href="javascript:;" id="avatar_upload_btn" class="btn btn-success">{lang upload_pic}</a>
	   		</div>
			<input type="hidden" id="avatar_upload_file"/>
		</div>
	</div>
	<div class="footer">
		<span id="saveAvatarBtn">
			<button type="submit" data-action="saveAvatar" enable="false" class="btn btn-primary">{lang submit}</button>
		</span>
	</div>
</div>