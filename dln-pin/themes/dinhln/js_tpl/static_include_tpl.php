<script type="text/template" id="comment_waterfall_tpl" reload="true">
 {{#data}} 
<div class="comment hide">
	<div class="shareface"><a class="trans07" href="javascript: void(0);" data-user-id="{{user_id}}" data-user-profile="1"><img src="{{user_avatar}}" onerror="javascript:this.src = base_url + '/assets/img/avatar_small.jpg';" width="30" height="30"></a></div>
	<div class="shareinfo"><a class="trans07" href="javascript: void(0);" data-user-id="{{user_id}}" data-user-profile="1">{{nickname}}</a><p>{{{comment_txt}}}</p></div>
</div>
 {{/data}} 
</script>
<script type="text/template" id="comment_detail_tpl" reload="false">
 {{#data}} 
	<li id="comment_{{comment_id}}" class="response hide">
		<h5>
			<a href="javascript:void(0);" data-user-id="{{user_id}}" data-user-profile="1" rel="contact"><img class="avatar photo-32" src="{{user_avatar}}"> {{nickname}}</a>
		</h5>
		<div class="comment-body">
			<p>{{{comment_txt}}}</p>
		</div>
		<p class="comment-meta">
			<a href="#comment_{{comment_id}}" class="posted">{{post_time_friend}}</a>
			<?php if($current_user['user_type']>1):?>
			<span class="sep">|</span>
			<a href="javascript:void(0);" class="others" data-action="delComment" data-params="{{share_id}},{{comment_id}}">{lang delete}</a>
			<a href="javascript:;" onclick="javascript:$.oFEditor('r_editor').insertAt('{{nickname}}');return false;">{lang reply}</a>
			<?php endif;?>
		</p>
	</li>
 {{/data}} 
</script>
<script id="user_profile_tpl" type="text/template">
	<b class="arrow_t"><i class="arrow_inner_t"></i></b>
    {{#success}}
	{{#data}}
    <div class="info">
        <a href="{{user.home}}" target="_blank"><img src="{{user.avatar}}" class="avatar photo-middle" onerror="javascript:this.src=base_url+'assets/img/avatar_large.jpg';" width="50" height="50" /></a>
        <p><b><a href="{{user.home}}" target="_blank">{{user.nickname}} {{user.group_title}}</a></b><a href="javascript:;" data-action="sendMessageOpen" data-params="{{user.nickname}}"><img src="<?php echo base_url();?>assets/img/message.png"></a></p>
		<p><a href="{{user.home}}" target="_blank">{{user.credits.name}}:{{user.credits.value}}</a><a href="{{user.home}}" target="_blank">{{user.ext_credits_1.name}}:{{user.ext_credits_1.value}}</a><a href="{{user.home}}" target="_blank">{{user.ext_credits_2.name}}:{{user.ext_credits_2.value}}</a><a href="{{user.home}}" target="_blank">{{user.ext_credits_3.name}}:{{user.ext_credits_3.value}}</a></p>
        <p class="meta"><a href="{{user.home}}" target="_blank">{lang follow}{{user.total_follows}}</a><em class="dot">●</em><a href="{{user.home}}" target="_blank">{{user.total_followers}}{lang fans}</a><em class="dot">●</em><a href="{{user.home}}" target="_blank">{{user.total_albums}}{lang album}</a><em class="dot">●</em><a href="{{user.home}}" target="_blank">{{user.total_shares}}{lang share}</a></p>
    </div>
    <div class="mark_list">
    {{#shares}}
    <a href="{{link}}" target="_blank">{{#image_path}}<img src="<?php echo base_url_r();?>{{image_path}}_square.jpg" title="{{title}}"/>{{/image_path}}{{^image_path}}<span class="label label-info">{lang article}</span>{{/image_path}}</a>
    {{/shares}}
    </div>
    <div class="operate">
        {{{relation}}}
    </div>
	{{/data}}
    {{/success}}
    {{^success}}
    <p class="message">{{{message}}}</p>
    {{/success}}

    <b class="arrow_b"><i class="arrow_inner_b"></i></b>
</script>