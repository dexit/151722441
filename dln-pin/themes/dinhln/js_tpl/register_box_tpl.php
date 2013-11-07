<div>
	<div class="pbody" data-title="{lang welcome_to_pintuxiu}" data-width="600" data-css-class="">
		<div class="span5 ml0">
		    <form id="register_form" class="form-horizontal" method="post">
		    	<fieldset>
					<div class="control-group">
			            <label class="control-label" for="email">{lang user_email}</label>
			            <div class="controls">
			                <input class="span3" id="email" type="text" name="email">
			                <p class="help-block">eg：example@example.com。</p>
			            </div>
			        </div>
					<div class="control-group">
			            <label class="control-label" for="nickname">{lang user_nickname}</label>
			            <div class="controls">
			                <input class="span3" id="nickname" type="text" name="nickname">
			                <p class="help-block">{lang nick_not_valid}</p>
			            </div>
			        </div>
					<div class="control-group">
			            <label class="control-label" for="password">{lang user_password}</label>
			            <div class="controls">
			               	<input class="span3" id="password" type="password" name="password">
			            </div>
			        </div>
					<div class="control-group">
			            <label class="control-label" for="passconf">{lang re_user_password}</label>
			            <div class="controls">
			               	<input class="span3" id="passconf" type="password" name="passconf">
		              		<p class="help-block">{lang re_user_password}</p>
			            </div>
			        </div>
			        <?php if($settings['vcode_setting']['register']):?>
					<div class="control-group">
			            <label class="control-label" for="verifycode">{lang verifycode}</label>
			            <div class="controls">
			               	<input class="span1" id="verifycode" type="text" name="verifycode">
			               	<img alt="verifycode" src="<?php echo spUrl('misc','vcode');?>" height="40"/>
		              		<a href="javascript:void(0);" data-action="vcodeRefresh">{lang verifycode_refresh}</a>
			            </div>
			        </div>
			        <?php endif;?>
					<div class="control-group">
			            <label class="control-label" for="terms"></label>
			            <div class="controls">
			               	<label class="checkbox">
				                <input id="terms" name="terms" type="checkbox" value="1" checked="checked">
				                 {lang i_agree} <a href="<?php echo spUrl('faq','agreement');?>" target="_blank">{lang user_treatment} </a>
				            </label>
			            </div>
			        </div>
			        <div class="control-group">
			        	<label class="control-label"></label>
			            <div class="controls">
			            <button type="submit" class="btn btn-success">{lang register}</button>
			        	<span id="ajax_message" class="error"></span>
			            </div>
			        </div>
			    </fieldset>
		    </form>
	    </div>
		<div class="span2 ml0">
			<ul class="unstyled">
				<li><strong>{lang already_register}？<a href="javascript:void(0);" data-action="openLoginDialog">{lang direct_login}</a></strong></li>
	        	<?php foreach ($vendors as $vendor):$lowerkey = strtolower($vendor);?>
				<?php if($settings['api_setting'][$vendor]['OPEN']):?>
				<li><a href="<?php echo spUrl('social','go',array('vendor'=>$vendor));?>"><i class="loginico-<?php echo $lowerkey;?>"></i></a></li>
				<?php endif;?>
				<?php endforeach;?>
			</ul>
		</div>
	</div>
</div>