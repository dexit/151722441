<div>
	<div class="pbody" data-title="{lang type_info_apply}" data-width="500" data-css-class="publish-select">
		<div class="ml20" id="apply_sdiv">
			<div id="apply_form" method="post" class="form-horizontal">
				<fieldset>
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
			            <label class="control-label" for="apply_reason">{lang apply_reason}</label>
			            <div class="controls">
			            	<textarea id="apply_reason" name="apply_reason" rows="5" class="span3 apply_reason"></textarea>
		              		<p class="help-block">{lang tip_type_apply}</p>
			            </div>
			        </div>
			        <div class="control-group">
			        	<label class="control-label"></label>
			            <div class="controls">
			            	<button type="submit" class="btn btn-success ajax_btn" data-action="applySave" data-params="apply_sdiv">{lang submit}</button>
		              		<p class="help-block error"></p>
			            </div>
			        </div>
			     </fieldset>
			</div>
	    </div>
	</div>
</div>