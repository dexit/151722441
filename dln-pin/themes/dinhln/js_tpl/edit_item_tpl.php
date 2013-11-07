<div>
	<div class="pbody" data-title="{lang edit}{lang share}" data-edit-title="{lang edit} {lang share}" data-width="650" data-css-class="publish">
	{{#data}}
	
	 <form id="edit_share_form" method="post">
	        	<input type="hidden" name="cover_filename" id="cover_filename">
				<input type="hidden" name="all_files" id="all_files">
				<input type="hidden" name="share_id" value="{{share.share_id}}"/>
				<input type="hidden" id="share_type" name="share_type" value="{{share.share_type}}"/>
				
		        <div class="tab-content" id="item_detail_div" data-uid="{{share.user_id}}">
			    	<div class="well form-inline image-area" id="image-area">
			    		<div class="cover-image">
				    		<a href="javascript:void(0);" class="prev disabled" data-action="preImage" id="preImageBtn"><i></i> </a>
						    <div class="thumbnail">
						    	<div class="img-thumb" id="upload_imgview_div"><img src="<?php echo base_url()?>{{share.image_path}}_middle.jpg?{{share.random}}"/></div>
						    	<i class="cover">{lang cover}</i>
						    </div>
						    <a href="javascript:void(0);" class="next disabled" data-action="nextImage" id="nextImageBtn"><i></i> </a>
						</div>
						<div class="imagethumb">
				    		<ul class="thumbnails" id="publish_image_list">
				    			{{#share.images}}
									<li data-action="publishPinItem" data-id="{{id}}" data-url="{{url}}" class="span2 selected {{#cover}}cover{{/cover}}">
										<div class="thumbnail">
											<div class="img-thumb">
												<img src="<?php echo base_url();?>{{url}}_large.jpg?{{share.random}}"/><i></i>
											</div>
											<input type="text" name="desc" class="desc" value="{{desc}}" placeholder="{lang type_some}"/>
										</div>
									</li>
								{{/share.images}}
						   	</ul>
					   	</div>
					</div>
		        	<div class="well form-inline">
			    		<div>
				    		<div class="input-prepend">
					    		<span class="add-on">{lang share_title}</span><input type="text" name="title" class="span3" id="title" value="{{share.title}}" placeholder="{lang share_title}"/>
			            	</div>
					    	<div class="input-prepend first-div category_select_list ml10" data-init="0" data-find-album="1">
					    		<input id="category_select_id" name="category_id" type="hidden" class="category_select_id">
					    		<span class="add-on">{lang category}</span><a href="javascript:void(0);" class="btn" data-action="categoryItemPopup" data-params="item_detail_div"><span class="category_select_title">{lang loading}</span> <span class="caret ml10"></span></a>
					            <ul class="btn-select">
					            </ul>
				           	</div>
					    	<div class="input-prepend second-div album_select_list ml10" data-init="0" data-album-id="{{share.album_id}}" data-album-name="{{share.album_title}}">
					    		<input class="album_select_id" name="album_id" type="hidden">
					    		<span class="add-on">{lang album}</span><a href="javascript:void(0);" class="btn" data-action="albumItemPopup" data-params="item_detail_div"><span class="album_select_title">{lang loading}</span> <span class="caret ml10"></span></a>
					            <ul class="btn-select">
					            	<li class="create_board" data-id="create_board">
					                	<input type="text" class="album_name span2" data-id="album_name">
					                    <button class="album_select_create btn btn-puzz" data-action="albumPopCreate" data-params="item_detail_div,{{share.user_id}}">{lang create_new}</button>
					               	</li>
					        	</ul>
				            </div>
		            	</div>
		            	<div class="tag-input">
		            		<div class="input-prepend pull-left">
						    	<span class="add-on">{lang tag}</span><input type="text" name="tags" class="span3" id="tags-input" placeholder="{lang tags}" value="{{share.keywords}}"/>
				            </div>
				            <div class="input-prepend pull-left ml10">
		            			<span class="add-on">$</span><input type="text" name="price" class="input-small" id="price" placeholder="{lang share_price}" value="{{share.price}}"/>
				            </div>
				            <div class="tags pull-left">
				            	<ul class="tags_list" data-target-id="tags-input"></ul>
				            </div>
		            	</div>
			    	</div>
    				<!--{subtemplate editor/edit_editor}-->
    				<div class="mt10 mr20">
    					<div id="ajax_share_message" class="pull-left"></div>
    					<button type="submit" class="btn btn-primary pull-right">{lang submit}</button>
    				</div>
	        	</div>
	        </form>
	{{/data}}
	</div>
</div>