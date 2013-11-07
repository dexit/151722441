<?php if($shares): ?>
	<?php foreach ($shares as $share):?>
		<?php if($share['share_type']=='ad'):?>
		<div class="pin hide">
			<div class="share_img" style="width: 200px;height:<?php echo $share['height'];?>px;padding: 10px 10px 0px 10px;">
				<iframe src="<?php echo spUrl('misc','adproxy',array('key'=>$share['key'],'ad_position'=>$share['ad_position']));?>" width="<?php echo $share['width'];?>" height="<?php echo $share['height'];?>" frameborder="0" scrolling="no">
				</iframe>
			</div>
			<div class="share_social c_b">
				<span class="prompt f_l"><?php echo $share['ad_name'];?></span>
			</div>
		</div>
		<?php else :?>
		<div class="pin hide <?php echo $share['share_type'];?>" id="<?php echo $share['share_id'];?>">
		 	<div class="puzzing">
		 		<?php if($share['share_type']=='article'):?>
		 			<div class="article-title">
		 			<div class="article-icon"><div class="article-icon-i">{lang article}</div></div>
		 			<a target="_blank" href="<?php echo host_url(spUrl("detail","index", array("share_id"=> $share['share_id'])));?>" id="<?php echo $share['share_id']?>_image"><?php echo $share['title'];?></a></div>
		 			<div class="article-content">
			 			<div class="shareface"><a target="_blank" href="<?php echo spUrl('pub','index',array('uid'=>$share['user_id']));?>" class="trans07" data-user-id="<?php echo $share['user_id'];?>" data-user-profile="1"><img src="<?php echo useravatar($share['user_id'], 'middle')?>" onerror="javascript:this.src = base_url + '/assets/img/avatar_middle.jpg';" width="30" height="30"/></a> </div>
						<a target="_blank" href="<?php echo spUrl('pub','index',array('uid'=>$share['user_id']));?>" data-user-id="<?php echo $share['user_id'];?>" data-user-profile="1"><?php echo $share['user_nickname'];?>:</a>
						<?php echo sysSubStr(parse_plain_message($share['intro']),1000,true);?>
						
					</div>
		 		<?php else:?>
					<div class="share_img">
						<?php $img_pro = str_to_arr($share['img_pro'], ',');$height=(220/$img_pro['width'])*$img_pro['height'];?>
						<a target="_blank" href="<?php echo host_url(spUrl("detail","index", array("share_id"=> $share['share_id'])));?>" class="image <?php echo $height>800?'long':'';?>" id="<?php echo $share['share_id']?>_image"><img class="s_image" src="<?php echo base_url_r($share['image_path'].'_middle.jpg?'.$hash); ?>" orgin_src="<?php echo base_url($share['image_path'].'_large.jpg');?>" width="220" height="<?php echo $height;?>" border="0"/><?php if($share['share_type']=='video'):?><i class="video_icon" orgin_url="<?php echo $share['reference_url'];?>"></i><?php endif;?><?php echo $height>800?'<span class="stop"></span>':'';?></a><?php if($share['price']):?><div class="goods_price"><?php echo T('money_unit').number_format($share['price'],2);?></div><?php endif;?>
					</div>
					<?php if($share['total_images']>2):?>
					<div class="other_img">
						<?php $images = unserialize($share['images_array']);$i=0;?>
		                <?php foreach ($images as $image):?>
		               		<?php if($i>1) break;?>
		                	<?php if(!$image['cover']):?>
		                	<a target="_blank" class="image <?php echo 'img_'.$i;?>" href="<?php echo spUrl("detail","index", array("share_id"=> $share['share_id']));?>"><img src="<?php echo base_url($image['url'].'_square_like.jpg?'.$hash);?>"></a>
		                	<?php $i++; endif;?>
		                <?php endforeach;?>
					</div>
					<?php endif;?>
					<div class="puzzing-txt">
						<div class="actions">
							<a href="javascript:void(0);" data-action="addLike" data-params="<?php echo $share['share_id'];?>" class="btn btn-puzz pull-left"><i class="icon-heart icon-white"></i>{lang like}</a>
							<a href="javascript:void(0);" data-action="<?php echo $current_user?'addCommentBox':'openLoginDialog';?>" data-params="<?php echo $share['share_id'];?>" class="btn btn-puzz pull-left"><i class="icon-comment icon-white"></i>{lang comment}</a>
							<div class="pull-right">
							<a href="javascript:void(0);"  class="btn btn-puzz pull-right dropdown-toggle" data-toggle="dropdown"><i class="icon-share-alt icon-white"></i>{lang forward}<span class="caret"></span></a>
							<ul class="dropdown-menu no-minwidth">
								<?php $share_target = array('sina','qzone','renren','qq','twitter','facebook');?>
					            <li><a href="javascript:void(0);" data-action="forwarding" data-params="<?php echo $share['share_id'];?>"><i class="icon-repeat icon-white"></i>{lang inside_forward}</a></li>
					            <?php foreach ($share_target as $target):?>
					            <li><a href="javascript:void(0);"  data-action="socialShare" data-params="<?php echo $share['share_id'].','.$target;?>"><i class="pico-<?php echo $target;?>"></i><?php echo T($target);?></a></li>
					            <?php endforeach;?>
					        </ul>
					        </div>
					 	</div>
						<a target="_blank" href="<?php echo host_url(spUrl("detail","index", array("share_id"=> $share['share_id'])));?>" class="image <?php echo $height>800?'long':'';?>" id="<?php echo $share['share_id']?>_image">
						<strong>
						<?php echo $share_intro = sysSubStr($share['title'],35,true);?>
						</strong>
						<span class="txt"><?php echo sysSubStr(parse_plain_message($share['intro']),200,true);?></span>
						<em><?php echo friendlyDate($share['create_time']);?></em>
						</a>
					</div>
				<?php endif;?>
			</div>
			<div class="tool_info clearfix">
				<?php if($share['total_images']>2):?>
				<a rel="tooltip" class="clip" title="{lang see_all} <?php echo ($share['total_images']);?> {lang piece_pic}" href="javascript:void(0);"><?php echo ($share['total_images']);?></a>
				<?php endif;?>
				<ul class="tools pull-right">
					<?php if($current_user['user_type']=='3'||$current_user['user_type']=='2'||$share['user_id']==$current_user['user_id']):?>
					<li class="settings pull-right">
						<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog"></i></a>
						<div class="dropdown-menu no-minwidth">
							<a href="javascript:void(0);" rel="tooltip" title="{lang l_edit}" data-action="<?php echo (($share['poster_id']==$share['user_id'])&&($share['poster_id']==$current_user['user_id']||$is_editer))?'editOShareOpen':'editFShareOpen';?>" data-params="<?php echo $share['share_id'];?>"><i class="icon-edit"></i></a>
							<a href="javascript:void(0);" rel="tooltip" title="{lang l_delete}" data-action="deleteShare" data-params="<?php echo $share['share_id'];?>"><i class="icon-remove"></i></a>
							<?php if($current_user['user_type']=='3'||$current_user['user_type']=='2'||($share['user_id']==$current_user['user_id']&&$current_user['is_star'])):?>
							<a href="javascript:void(0);" rel="tooltip" title="{lang l_star}" data-action="starOpen" data-params="<?php echo $share['share_id'].','.$share['user_id'].','.$share['category_id'].','.$share['image_path'];?>"><i class="icon-star"></i></a>
							<?php endif;?>
							<?php if($current_user['user_type']=='3'||$current_user['user_type']=='2'):?>
							<a href="javascript:void(0);" rel="tooltip" title="{lang l_ban}" data-action="confirmRedirect" data-params="<?php echo spUrl('webuser','banuser',array('uid'=>$share['user_id']));?>,banuser"><i class="icon-user"></i></a>
							<a href="javascript:void(0);" rel="tooltip" title="{lang l_push}" data-action="openPushDialog" data-params="<?php echo $share['share_id'].','.$share['category_id'].','.$share['image_path'];?>"><i class="icon-screenshot"></i></a>
							<a href="javascript:void(0);" rel="tooltip" title="{lang l_digist}"><i class="icon-thumbs-up"></i></a>
							<a href="javascript:void(0);" rel="tooltip" title="{lang l_top}"><i class="icon-arrow-up"></i></a>
							<?php endif;?>
					    </div>
					</li>
					<?php endif;?>
					<li class="comments" rel="tooltip" title="{lang comment}" data-action="<?php echo $current_user?'addCommentBox':'openLoginDialog';?>" data-params="<?php echo $share['share_id'];?>">
						<?php echo $share['total_comments'];?>
					</li>
					<li class="fav" rel="tooltip" title="{lang like}" id="<?php echo $share['share_id']?>_likenum" data-action="addLike" data-params="<?php echo $share['share_id'];?>">
						<em><?php echo $share['total_likes'];?></em>
					</li>
					<li class="views" rel="tooltip" title="{lang view}">
						<?php echo $share['total_clicks'];?>
					</li>
				</ul>
			</div>
			<?php if($share['share_type']!='article'):?>
			<div class="share_people">
				<div class="shareface"><a target="_blank" href="<?php echo spUrl('pub','index',array('uid'=>$share['user_id']));?>" class="trans07" data-user-id="<?php echo $share['user_id'];?>" data-user-profile="1"><img src="<?php echo useravatar($share['user_id'], 'middle')?>" onerror="javascript:this.src = base_url + 'assets/img/avatar_middle.jpg';" width="30" height="30"/></a> </div>
				<div class="shareinfo"> 
					<p><a target="_blank" href="<?php echo spUrl('pub','index',array('uid'=>$share['user_id']));?>" data-user-id="<?php echo $share['user_id'];?>" data-user-profile="1"><?php echo $share['user_nickname'];?>:</a>
						<?php echo sysSubStr(parse_plain_message($share['intro']),55,true);?>
					</p>
				</div>
			</div>
			<?php else:?>
				<div class="share_time">
					<?php echo friendlyDate($share['create_time']);?>
				</div>
			<?php endif;?>
			<div class="share_comments" id="<?php echo $share['share_id'].'_comments'?>">
		 		<?php $comments = unserialize($share['comments']);
		 		$comment_num=$settings['ui_pin']['pin_commentnum'];
		 		$comments=($comments)?array_slice($comments,0,$comment_num):null;?>
		  		<?php foreach ( $comments as $comment): ?>
				<div class="comment">
					<div class="shareface"><a class="trans07" href="<?php echo spUrl('pub','index',array('uid'=>$comment['user_id']));?>" data-user-id="<?php echo $comment['user_id'];?>" data-user-profile="1"><img src="<?php echo useravatar($comment['user_id'], 'middle');?>" class="avatar" width="30" height="30"></a></div>
					<div class="shareinfo"><a href="<?php echo spUrl('pub','index',array('uid'=>$comment['user_id']));?>" data-user-id="<?php echo $comment['user_id'];?>" data-user-profile="1"><?php echo $comment['nickname'];?></a><p><?php echo parse_message(sysSubStr($comment['comment_txt'],50,true));?></p></div>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="share_comments commentdiv hide" id="<?php echo $share['share_id'].'_commentdiv'?>">
		  		<div class="comment">
					<div class="shareface"><img src="<?php echo base_url($current_user['avatar_local'].'_middle.jpg');?>" onerror="javascript:this.src = base_url + 'assets/img/avatar_small.jpg';" width="30" height="30" /></div>
					<div class="shareinfo">
					<textarea id="<?php echo $share['share_id'].'_commentbox'?>" rows="2" class="borderclass" onkeyup="javascript:strLenCalc(this, '<?php echo $share['share_id'];?>checklen', 140);"></textarea>
					<span class="smalltxt"><i id="<?php echo $share['share_id'];?>checklen">140</i>/140</span><button data-action="addComment" data-params="<?php echo $share['share_id'];?>,comment_waterfall_tpl" class="btn pull-right">{lang comment}</button>
					</div>
				</div>
			</div>
		</div>
		<?php endif;?>
	<?php endforeach;?>
<?php endif;?>