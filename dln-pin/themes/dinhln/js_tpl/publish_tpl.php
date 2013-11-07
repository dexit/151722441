<div>
	<div class="pbody" data-title="{lang create_new}{lang share}" data-width="800" data-css-class="publish">
		<div class="tabbable tabs-left">
	        <ul class="nav nav-tabs" id="publishTab">
	          <li>
	          	<a href="#website_fetch" data-toggle="tab" class="website_fetch" data-action="switchPublish" data-params="website_fetch"><img alt="{lang website_fetch}" class="fig" src="<?php echo base_url("assets/img/publish-fetch.png");?>">{lang website_fetch}</a>
	          </li>
	          <li><a href="#local_upload" data-toggle="tab" class="local_upload" data-action="switchPublish" data-params="local_upload"><img alt="{lang local_upload}" class="fig" src="<?php echo base_url("assets/img/publish-upload.png");?>">{lang local_upload}</a></li>
	          <?php if($permission['other_permission']['allow_video']):?>
	          <li><a href="#website_fetch" data-toggle="tab" class="video_share" data-action="switchPublish" data-params="video_share"><img alt="{lang video_share}" class="fig" src="<?php echo base_url("assets/img/publish-video.png");?>">{lang video_share}</a></li>
			  <?php endif;?>
	          <li><a href="#article_share" data-toggle="tab" class="article_share" data-action="switchPublish" data-params="article_share"><img alt="{lang article_share}" class="fig" src="<?php echo base_url("assets/img/publish-text.png");?>">{lang article_share}</a></li>
	        </ul>
	        <form id="save_share_form" data-url="" next-url="<?php echo spUrl('pin','index');?>" method="post">
	        	<input type="hidden" name="cover_filename" id="cover_filename">
				<input type="hidden" name="item_id" id="item_id">
				<input type="hidden" name="channel" id="channel">
				<input type="hidden" name="share_type" id="share_type">
				<input type="hidden" name="reference_url" id="reference_url">
				<input type="hidden" name="all_files" id="all_files">
				<input type="hidden" name="flv" id="flv">
				<input type="hidden" name="groupid" id="groupid">
				<input type="hidden" name="topicid" id="topicid">
		        <div class="tab-content" id="category_select_div">
			        <div class="well form-inline tab-pane" id="website_fetch">
				    	<div class="input-prepend tab-pane">
					    	<span class="add-on"><i class="icon-globe"></i></span><input type="text" name="remote_url" class="input-medium" id="remote_url" placeholder="{lang type_address_fetch}"/>
			            	<button id="fetch_remote_btn" class="btn" data-action="fetchRemote" data-params="0">{lang start_fetch}</button>
			            </div>
				    	<div class="input-prepend ml10">
			            	<span id="ajax_fetch_message"></span>
			            </div>
			    	</div>
			    	<div class="well form-inline tab-pane" id="local_upload">
				    	<div class="input-prepend tab-pane">
				    		<span id="spanButtonPlaceholder"></span>
			            	<button id="item_upload_btn" class="btn btn-success">{lang upload_pic}</button>
			            </div>
				    	<div class="input-prepend ml10">
			            	<span id="ajax_upload_message"></span>
			            </div>
			    	</div>
			    	<div id="article_share"></div>
			    	<div class="well form-inline image-area" id="image-area">
			    		<div class="cover-image">
				    		<a href="javascript:void(0);" class="prev disabled" data-action="preImage" id="preImageBtn"><i></i> </a>
						    <div class="thumbnail">
						    	<div class="img-thumb" id="upload_imgview_div">{lang no_img_share}</div>
						    	<i class="cover">{lang cover}</i>
						    </div>
						    <a href="javascript:void(0);" class="next disabled" data-action="nextImage" id="nextImageBtn"><i></i> </a>
						</div>
						<div class="imagethumb">
				    		<ul class="thumbnails" id="publish_image_list">
							    <li class="span2" id="no_image">
							       <div class="thumbnail">
							          <div class="img-thumb">{lang no_img_share}</div>
							          <input type="text" name="remote_url" class="desc" placeholder="{lang type_address_fetch}"/>
							       </div>
							    </li>
						   	</ul>
					   	</div>
					</div>
		       		<input type="hidden" name="promotion_url" id="promotion_url"/>
		        	<div class="well form-inline">
			    		<div>
				    		<div class="input-prepend">
					    		<span class="add-on">{lang share_title}</span><input type="text" name="title" class="span3" id="title" placeholder="{lang share_title}"/>
			            	</div>
					    	<div class="input-prepend first-div category_select_list ml10" data-init="0" data-find-album="1">
					    		<input id="category_select_id" name="category_id" type="hidden" class="category_select_id">
					    		<span class="add-on">{lang category}</span><a href="javascript:void(0);" class="btn" data-action="categoryItemPopup" data-params="category_select_div"><span class="category_select_title">{lang loading}</span> <span class="caret ml10"></span></a>
					            <ul class="btn-select">
					            </ul>
				           	</div>
					    	<div class="input-prepend second-div album_select_list ml10" data-init="0">
					    		<input class="album_select_id" name="album_id" type="hidden">
					    		<span class="add-on">{lang album}</span><a href="javascript:void(0);" class="btn" data-action="albumItemPopup" data-params="category_select_div"><span class="album_select_title">{lang loading}</span> <span class="caret ml10"></span></a>
					            <ul class="btn-select">
					            	<li class="create_board" data-id="create_board">
					                	<input type="text" class="album_name span2" data-id="album_name">
					                    <button class="album_select_create btn btn-puzz" data-action="albumPopCreate" data-params="category_select_div">{lang create_new}</button>
					               	</li>
					        	</ul>
				            </div>
		            	</div>
		            	<div class="tag-input clearfix">
		            		<div class="input-prepend pull-left">
						    	<span class="add-on">{lang tag}</span><input type="text" name="tags" class="span3" id="tags-input" placeholder="{lang tags}"/>
				            </div>
				            <div class="input-prepend pull-left ml10 clearfix">
		            			<span class="add-on">$</span><input type="text" name="price" class="input-small" id="price" placeholder="{lang share_price}"/>
				            </div>
		            	</div>
				        <div class="tags clearfix">
				           <ul class="tags_list" data-target-id="tags-input"></ul>
				        </div>
			    	</div>
    				<!--{subtemplate editor/editor}-->
    				<div class="buttons">
    					<div id="ajax_share_message" class="pull-left"></div>
    					<button type="submit" id="editorsubmit" class="btn btn-primary pull-right">{lang submit}</button>
    				</div>
	        	</div>
	        </form>
	    </div>
	</div>
</div>