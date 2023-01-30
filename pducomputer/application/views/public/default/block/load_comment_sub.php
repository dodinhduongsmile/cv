<?php if(!empty($list_comment)){ foreach($list_comment as $v){ 
	?>
<div class="feedback_ feedback_sub" data-idcmt="<?php echo $v->id; ?>">
	<div class="feedbacker">
		<img src="<?php echo !empty($v->avatar) ? TEMPLATES_ASSETS.$v->avatar :base_url("public/images/user.png"); ?>" alt="">
	</div>
	<div class="fbContent">
		<span><a href="#profile"><?php echo !empty($v->fullname)?$v->fullname:"No Name" ; symUserpdu($v->lever);?></a></span>
		<time><?php echo date("d/m/Y - H:i", strtotime($v->updated_time)); ?> </time>
		<p class="fbpdu_content"><?php echo $v->content; ?></p>
		<ul class="fbpdu_action">
			<li class="fb_action_reply"><a href="" data-user="<?php echo !empty($v->fullname)?$v->fullname:"No Name" ; ?>" data-userid="<?php echo $v->user_id; ?>"><i class="fa fa-reply" aria-hidden="true"></i> trả lời</a></li>
			<li class="fb_action_like"><a href=""><span><?php echo $v->count_like; ?></span><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> like</a></li>
			<li class="fb_action_repot"><a href=""><span><?php echo $v->report; ?></span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Báo cáo vi phạm</a></li>

		<?php if($v->user_id == @$_SESSION['user_id']){ ?>
			<li class="fb_action_edit"><a href=""><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Sửa</a></li>
			<li class="fb_action_delete"><a href=""><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a></li>
		<?php }; ?>
		</ul>
	</div>
</div>
<?php }}; ?>