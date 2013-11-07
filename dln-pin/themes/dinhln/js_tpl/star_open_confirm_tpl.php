<div>
	<div class="pbody" data-title="{lang confirm_add_staruser}" data-width="600" data-css-class="publish-select">
 		<div class="span2">
			<span class="span2 ml0"><img src="{{avatar}}" class="avatar photo-large ml20"/></span>
			<span class="span2 ml0 mt10">{lang user_nickname}: <strong><a href="{{home}}">{{nickname}}</a></strong></span>
			<span class="span2 ml0 mt10">{lang user_description}: {{#bio}}{{.}}{{/bio}}{{^bio}}{lang user_no_description}{{/bio}}</span>
		</div>
		<div class="span5" id="star_open_confirm_sdiv">
			<div id="star_open_confirm_form" method="post" class="form-horizontal">
				<fieldset>
				<input name="user_id" type="hidden" class="user_id" value="{{user_id}}"/>
					<div class="control-group">
			            <label class="control-label" for="apply_cid">{lang category}</label>
			            <div class="controls">
			            	<select class="span3 apply_cid" id="apply_cid" name="apply_cid">
			            		<?php foreach ($medals_staruser as $medal):?>
			            		<option value="<?php echo $medal['medal_id'];?>"><?php echo $medal['name'];?></option>
			            		<?php endforeach;?>
			            	</select>
			            </div>
			        </div>
					<div class="control-group">
			            <label class="control-label" for="apply_reason">{lang recommend_reason}</label>
			            <div class="controls">
			            	<textarea id="apply_reason" name="apply_reason" rows="5" class="span3 apply_reason"></textarea>
		              		<p class="help-block">{lang tip_recommend_reason}</p>
			            </div>
			        </div>
			        <div class="control-group">
			        	<label class="control-label"></label>
			            <div class="controls">
			            	<button type="submit" class="btn btn-success ajax_btn" data-action="starSave" data-params="star_open_confirm_form">{lang submit}</button>
		              		<p class="help-block error"></p>
			            </div>
			        </div>
			     </fieldset>
			</div>
				
	    </div>
	</div>
</div>