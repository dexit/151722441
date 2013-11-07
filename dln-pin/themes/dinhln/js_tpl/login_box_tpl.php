<div>
	<div class="pbody" data-title="{lang login_tip}" data-width="600" data-css-class="">
		<div class="span5 ml0">
			<?php if($settings['ucenter_setting']['ucenter_open']&&$lang=='zh_cn'):?>
			<ul id="loginTab" class="nav nav-tabs">
		       <li class="active" style="margin-left: 60px;"><a href="#ptx_login" data-toggle="tab">{lang pin_user}</a></li>
				<li><a href="#bbs_login" data-toggle="tab">{lang bbs_user}</a></li>
		    </ul>
			<?php endif;?>
			<div id="loginTabContent" class="tab-content">
				<div class="tab-pane fade active in" id="ptx_login">
				<form id="login_form" method="post" class="form-horizontal">
					<fieldset>
						<div class="control-group">
				            <label class="control-label" for="email">{lang user_email}</label>
				            <div class="controls">
				                <input class="span3" id="email" type="text" name="email">
				            </div>
				        </div>
						<div class="control-group">
				            <label class="control-label" for="password">{lang user_password}</label>
				            <div class="controls">
				               	<input class="span3" id="password" type="password" name="password">
				            </div>
				        </div>
				        
				        <?php if($settings['vcode_setting']['login']):?>
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
				            <label class="control-label" for="is_remember"></label>
				            <div class="controls">
				               	<label class="checkbox">
					                <input id="is_remember" name="is_remember" type="checkbox" value="1" checked="checked">
					                {lang autologin_next}
					            </label>
				            </div>
				        </div>
				        <div class="control-group">
				        	<label class="control-label"></label>
				            <div class="controls">
				            <button type="submit" class="btn btn-success ajax_btn">{lang login}</button>
				            <a href="<?php echo spUrl('webuser','forget_password')?>">{lang forget_password}</a>
				            </div>
				        </div>
					</fieldset>
				</form>
				</div>
				<?php if($settings['ucenter_setting']['ucenter_open']&&$lang=='zh_cn'):?>
				<div class="tab-pane fade" id="bbs_login">
				<form id="bbs_login_form" method="post" class="form-horizontal">
					<fieldset>
						<div class="control-group">
				            <label class="control-label" for="bbs_username">{lang bbs_username}</label>
				            <div class="controls">
				                <input class="span3" id="bbs_username" type="text" name="bbs_username">
				            </div>
				        </div>
						<div class="control-group">
				            <label class="control-label" for="bbs_password">{lang user_password}</label>
				            <div class="controls">
				               	<input class="span3" id="bbs_password" type="password" name="bbs_password">
				            </div>
				        </div>
				        <div class="control-group">
				        	<label class="control-label"></label>
				            <div class="controls">
				            <button type="submit" class="btn btn-success ajax_btn">{lang login}</button>
				            </div>
				        </div>
					</fieldset>
				</form>
				</div>
				<?php endif;?>
			</div>
		</div>
		<div class="span2 ml0">
			<ul class="unstyled">
				<li><strong>{lang other_login}</strong> {lang or} <strong><a href="javascript:void(0);" data-action="openRegisterDialog">{lang register}</a></strong></li>
				<?php foreach ($vendors as $vendor):$lowerkey = strtolower($vendor);?>
				<?php if($settings['api_setting'][$vendor]['OPEN']):?>
				<li><a href="<?php echo spUrl('social','go',array('vendor'=>$vendor));?>"><i class="loginico-<?php echo $lowerkey;?>"></i></a></li>
				<?php endif;?>
				<?php endforeach;?>
			</ul>
		</div>
	</div>
</div>