<div>
	<div class="pbody" data-title="{lang forward}" data-edit-title="{lang edit} {lang forward}" data-width="520" data-css-class="publish">
	{{#data}}
		<div class="clearfix">
			<div class="span2 ml0">
	        	<div class="cover-image">
					<div class="thumbnail">
						<div class="img-thumb"><img src="<?php echo base_url()?>{{share.image_path}}_middle.jpg"></div>
						<i class="cover">{lang cover}</i>
					</div>
				</div>
			</div>
			<div class="span4" id="forwarding_div" data-uid="{{share.user_id}}">
					<div class="well form-inline">
	       				<div class="input-prepend">
					    	<span class="add-on">{lang share_title}</span><input type="text" name="title" value="{{share.title}}" class="span3" id="title" placeholder="{lang share_title}" disabled/>
			            </div>
	            	</div>
	            	
	            	<div class="well form-inline">
			    		<div>
				    		
					    	<div class="input-prepend first-div category_select_list ml10" data-init="0" data-find-album="1">
					    		<input id="category_select_id" name="category_id" type="hidden" class="category_select_id">
					    		<span class="add-on">{lang category}</span><a href="javascript:void(0);" class="btn" data-action="categoryItemPopup" data-params="forwarding_div"><span class="category_select_title">{lang loading}</span> <span class="caret ml10"></span></a>
					            <ul class="btn-select">
					            </ul>
				           	</div>
					    	<div class="input-prepend second-div album_select_list ml10" data-init="0">
					    		<input class="album_select_id" name="album_id" type="hidden">
					    		<span class="add-on">{lang album}</span><a href="javascript:void(0);" class="btn" data-action="albumItemPopup" data-params="forwarding_div"><span class="album_select_title">{lang loading}</span> <span class="caret ml10"></span></a>
					            <ul class="btn-select">
					            	<li class="create_board" data-id="create_board">
					                	<input type="text" class="album_name span2" data-id="album_name">
					                    <button class="album_select_create btn btn-puzz" data-action="albumPopCreate" data-params="forwarding_div">{lang create_new}</button>
					               	</li>
					        	</ul>
				            </div>
		            	</div>
			    	</div>
			</div>
		</div>
		<div class="mt10 mr20 text_c">
    		<button type="submit" id="editorsubmit" data-action="forwardingSave" class="btn btn-primary">{lang submit}</button>
    		<div id="ajax_share_message" class="error"></div>
    	</div>
	{{/data}}
	</div>
</div>