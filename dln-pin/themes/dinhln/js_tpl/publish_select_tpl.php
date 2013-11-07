<div>
	<div class="pbody" data-title="{lang p_select_type}" data-width="700" data-css-class="publish-select">
			<ol>
				<li data-action="openPublishDialog" data-params="website_fetch">
					<img alt="{lang website_fetch}" class="fig" src="<?php echo base_url("assets/img/publish-fetch.png");?>">
					<h3>{lang website_fetch}</h3>
					<p>{lang website_fetch_tip}</p>
				</li>
				<li data-action="openPublishDialog" data-params="local_upload">
					<img alt="{lang local_upload}" class="fig" src="<?php echo base_url("assets/img/publish-upload.png");?>">
					<h3>{lang local_upload}</h3>
					<p>{lang local_upload_tip}</p>
				</li>
				<?php if($permission['other_permission']['allow_video']):?>
				<li data-action="openPublishDialog" data-params="video_share">
					<img alt="{lang video_share}" class="fig" src="<?php echo base_url("assets/img/publish-video.png");?>">
					<h3>{lang video_share}</h3>
					<p>{lang video_share_tip}</p>
				</li>
				<?php endif;?>
				<li data-action="openPublishDialog" data-params="article_share">
					<img alt="{lang article_share}" class="fig" src="<?php echo base_url("assets/img/publish-text.png");?>">
					<h3>{lang article_share}</h3>
					<p>{lang article_share_tip}</p>
				</li>
				<li class="alt">
					<p><strong>{lang pls_note}</strong> {lang pls_note_info}</p>
				</li>
			</ol>
	</div>
</div>