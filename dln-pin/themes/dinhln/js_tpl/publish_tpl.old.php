<script type="text/template" id="publish_select_tpl" data-title="<?php echo T('p_select_type');?>" data-width="700">
<p>
	<a class="add_mark tool_btn" href="javascript:void(0);" data-action="openPublishDialog" data-params="0"><?php echo T('website_fetch');?><b></b></a>
	<a class="upload tool_btn" href="javascript:void(0);" data-action="openPublishDialog" data-params="1"><?php echo T('local_upload');?><b></b></a>
	<?php if($permission['other_permission']['allow_video']):?>
	<a class="video tool_btn" href="javascript:void(0);" data-action="openPublishDialog" data-params="2"><?php echo T('video_share');?><b></b></a>
	<?php endif;?>
</p>
</script>
<script type="text/template" id="publish_tpl" data-title="<?php echo T('create_new').T('share');?>"
	data-upload-save-url="<?php echo spUrl('share','item_upload', array('act'=>'save'));?>"
	data-fetch-save-url="<?php echo spUrl('share','item_fetch', array('act'=>'save'));?>"
	data-edit-save-url="<?php echo spUrl('admin','item_list', array('act'=>'edit_save'));?>"
	data-upload-url="<?php echo spUrl('share','item_upload', array('act'=>'upload'));?>" 
	data-fetch-url="<?php echo spUrl('share','item_fetch', array('act'=>'fetch'));?>"
	data-video-save-url="<?php echo spUrl('share','video_fetch', array('act'=>'save'));?>"
	data-video-fetch-url="<?php echo spUrl('share','video_fetch', array('act'=>'fetch'));?>">
    <div class="pin_type mt10" id="item_upload_buttons">
        <div class="left"><?php if($permission['other_permission']['allow_video']):?><a href="javascript:void(0);" id="video_publish" data-action="switchPublish" data-params="2"><?php echo T('video_share');?></a> | <?php endif;?><a href="javascript:void(0);" id="website_publish" data-action="switchPublish" data-params="0" class="selected"><?php echo T('website_fetch');?></a> | <a href="#" id="upload_publish" data-action="switchPublish" data-params="1"><?php echo T('local_upload');?></a></div>
		<div id="website_input" class="website hide">
			<input type="text" name="remote_url" id="remote_url" title="<?php echo T('type_address_fetch');?>"/>
            <button id="fetch_remote_btn" data-action="fetchRemote" data-params="0"><?php echo T('start_fetch');?></button>

			<div id="ajax_fetch_message"></div>
        </div>
        <div id="upload_input" class="upload">
			<div class="qq-uploader">
			<div id="item_upload_btn" class="graybtn" style="position: relative; overflow-x: hidden; overflow-y: hidden; direction: ltr; ">
				<?php echo T('upload_pic');?>
			</div><?php echo T('need_upload_many_times');?>
			<span class="text"></span>
			</div>
		</div>
    </div>
	<div class="publish_form">
			<div class="left">
				<div class="image mt10">
					<a href="javascript:void(0);" class="prev disabled"
						data-action="preImage" id="preImageBtn"><i></i>1</a>
					<div>
						<b id="upload_imgview_div"></b><i class="cover"><?php echo T('cover');?></i>
					</div>
					<a href="javascript:void(0);" class="next disabled"
						data-action="nextImage" id="nextImageBtn">2<i></i> </a>
				</div>
			</div>
			<div class="right" id="category_select_div" data-uid="<?php echo $current_user['user_id'];?>">
				<form id="save_share_form" data-url="" next-url="<?php echo spUrl('pin','index');?>" method="post">
					<input type="hidden" name="cover_filename" id="cover_filename"> 
					<input type="hidden" name="item_id" id="item_id"> 
					<input type="hidden" name="channel" id="channel"> 
					<input type="hidden" name="share_type" id="share_type"> 
					<input type="hidden" name="reference_url" id="reference_url"> 
					<input type="hidden" name="all_files" id="all_files">
					<input type="hidden" name="flv" id="flv">

					<div class="form_line">
						<div class="form_item">
							<input type="text" name="title" id="title" title="<?php echo T('share_title');?>">
						</div>
						<div class="form_item">
							<input type="text" name="price" id="price" title="<?php echo T('share_price');?>">
						</div>
					</div>
					<div class="clear"></div>
					<div class="form_line first_div">
						<div class="form_item first_div">
							<div class="btn_select first_div category_select_list" data-init="0" data-find-album="1">
			                	<input id="category_select_id" name="category_id" type="hidden" class="category_select_id">
								<a href="javascript:void(0);" class="listbtn" data-action="categoryItemPopup" data-params="category_select_div"><span class="label"><?php echo T('category');?>：</span><span class="category_select_title"><?php echo T('loading');?></span><s><b></b></s></a>
			               		<ul>
			                	</ul>
			            	</div>
						</div>
						<div class="form_item second_div">
							<div class="btn_select second_div album_select_list" data-init="0">
			            		<input class="album_select_id" name="album_id" type="hidden">
								<a href="javascript:void(0);" class="listbtn" data-action="albumItemPopup" data-params="category_select_div"><span class="label"><?php echo T('album');?>：</span><span class="album_select_title"><?php echo T('loading');?></span><s><b></b></s></a>
			                	<ul>
			                    	<li class="create_board" data-id="create_board">
			                        	<input type="text" class="album_name" data-id="album_name">
			                        	<button class="album_select_create" type="button" data-action="albumPopCreate" data-params="category_select_div"><?php echo T('create_new').T('album');?></button>
			                    	</li>
			               		</ul>
			            	</div>
						</div>
					</div>
					<div class="clear"></div>
					<div class="form_line">
						<input type="text" name="promotion_url" id="promotion_url" title="<?php echo T('promotion_url');?>" />
					</div>
					<div class="clear"></div>
					<div class="form_textarea third_div">
						<div class="form_textarea_hd">
						<div class="btn-group icon_div third_div" id="smiles_div">
						<a href="javascript:;" class="smile dropdown-toggle" id="smiles" data-toggle="dropdown">Smilies</a>
						<ul class="dropdown-menu smiles" data-init="0">
				        </ul>
				        </div>
						<a href="javascript:;" class="at" onclick="javascript:$('#publish_intro').insertAtCaret('@<?php echo T('friend');?> ',1);">@</a>
						<div class="btn-group" id="tags_div">
							<a href="javascript:;" class="box dropdown-toggle" data-toggle="dropdown"><?php echo T('hot').' '.T('tag');?></a>
							<ul class="dropdown-menu tags_list" data-target-id="publish_intro">
				        	</ul>
				        </div>
						<a href="javascript:;" class="box" style="display:none;" onclick="javascript:$('#publish_intro').insertAtCaret('#话题#',1);">#话题#</a>
						</div>
						<textarea id="publish_intro" rows="2" name="intro"></textarea>
					</div>
					<div class="clear"></div>
					<div id="ajax_share_message" class="error"></div>
					<div class="form_line text_c">
						<button type="submit"><?php echo T('submit');?></button>
					</div>
					<div class="clear"></div>
				</form>
				<div class="clear"></div>
			</div>
			<div class="one_line">
				<div class="image_list mt10">
					<ul id="publish_image_list">
					</ul>
				</div>
			</div>
		</div>
</script>
