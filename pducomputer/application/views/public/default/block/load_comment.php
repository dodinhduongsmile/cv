<?php if(!empty($list_comment)){ foreach($list_comment as $v){ 
	?>
<!-- pducmt_item -->
	<li class="pducmt_item" data-idcmt="<?php echo $v->id; ?>">
		<div class="feedback_" data-idcmt="<?php echo $v->id; ?>">
			<div class="feedbacker">
				<img src="<?php echo !empty($v->avatar) ? TEMPLATES_ASSETS.$v->avatar :base_url("public/images/user.png"); ?>" alt="">
			</div>
			<div class="fbContent">
				<span><a href="#profile"><?php echo !empty($v->fullname)?$v->fullname:"No Name" ; symUserpdu($v->lever);?></a></span>
				<time><?php echo date("d/m/Y - H:i", strtotime($v->updated_time)); ?> </time>
				<ul class="fbpdu_star">
					<?php
					for ($i=1; $i <= 5; $i++) {
						if($i <= $v->count_star){
							echo '<li><span class="fa fa-star"></span></li>';
						}else{
							echo '<li><span class="fa fa-star-o"></span></li>';
						}
					}
					?>
				</ul>
				<p class="fbpdu_content"><?php echo $v->content; ?></p>
				<?php if(isset($v->file_attach)){
				?>
				<div class="attach_file">
					<a href="<?php echo TEMPLATES_ASSETS.$v->file_attach; ?>" target="_blank"><img src="<?php echo TEMPLATES_ASSETS.getPathThumb($v->file_attach); ?>" alt="<?php echo $v->content; ?>"></a>
				</div>
				<?php }; ?>
				<ul class="fbpdu_action">
					<li class="fb_action_reply"><a href="" data-user="<?php echo !empty($v->fullname)?$v->fullname:"No Name" ; ?>" data-userid="<?php echo $v->user_id; ?>"><i class="fa fa-reply" aria-hidden="true"></i> trả lời</a></li>
					<li class="fb_action_like"><a href=""><span><?php echo $v->count_like; ?></span><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> like</a></li>
					<li class="fb_action_repot"><a href=""><span><?php echo $v->report; ?></span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Báo cáo vi phạm</a></li>

				<?php if($v->user_id == @$_SESSION['user_id']){ ?>
					<li class="fb_action_edit"><a href=""><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Sửa</a></li>
					<li class="fb_action_delete"><a href=""><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a></li>
				<?php }; ?>
				</ul>
				<!-- check xem thằng $v->id này có con hay không, load sub comment -->
				<?php if($v->total_child > 0){ ?>
				<div class="fbpdu_more2">
					<a href="#"><i class="fa fa-share"></i> <?php echo $v->total_child; ?> phản hồi</a>
				</div>
				<?php }; ?>
			</div>
		</div>
		<?php if($v->total_child > 0){ ?>
		<div class="feedback_rep">
			<!-- có sub comment thì load vào đây -->

			<div class="fbpdu_more"><a href="#" id="fbpdu_more" data-parent="<?php echo $v->id; ?>" data-offset="0">Xem thêm phản hồi <i class="fa fa-caret-down"></i></a></div>
		</div>
		<?php }; ?>
		<!-- comment -->
		<div class="pducmt_addcmt hide_">
			<div class="pducmt_wr--ct">
				<textarea name=""></textarea>
				<button class="btn submit_cmt hide_" data-idcmt="0" data-idedit="0">gửi</button>
			</div>
		</div>
	</li>
<?php }}; ?>