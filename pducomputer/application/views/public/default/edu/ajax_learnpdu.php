<div class="learnpdu">
	<div class="container">
<?php if($auth_useredu && $oneItem->type>0){ ?>
	<button class="learnpdu_toggle"></button>
	<div class="row clearfix">
		<div class="col-md-3 learnpdu_left">
			<div class="learnpdu_list">
				<table class="table table-bordered video_pdusoft">
					<thead>
						<tr class="learnpdu_head">
							<th colspan="2" class="bg_gra1">Danh Sách Bài Học</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($listdrive as $k => $v): ?>
							<!-- nếu là folder -->
							<?php if(!empty($v->child)): ?>
								<tr>
									<td colspan="2" class="collapsible">
										<h3 class="collapsible-item--title"><?php echo $v->name; ?></h3>
										<div class="collapsible-item--content">
											<table class="table table-bordered">
												<tbody>
													<?php foreach($v->child as $k2 => $v2): ?>
														<tr>
															<?php if(@$v2->mimeType != "application/vnd.google-apps.folder"){?>
																<td colspan="2" class="load_video_pdusoft" data-type="<?php echo $typevd; ?>" data-video="<?php echo $v2->id; ?>"><h3><a href="#" title="<?php echo $v2->name; ?>" ><?php echo $v2->name; ?></a></h3></td>
															<?php }else{ ?>
																<td colspan="2"><h3><?php echo $v2->name; ?></h3></td>
															<?php }; ?>
														</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
										</div>
									</td>
								</tr>
							<?php else: ?>
									<tr>
										<td colspan="2" class="load_video_pdusoft" data-type="<?php echo $typevd; ?>" data-video="<?php echo $v->id; ?>"><h3><a href="#" title="<?php echo $v->name; ?>" ><?php echo $v->name; ?></a></h3></td>
									</tr>
							<?php endif; ?>
								<!-- nếu là folder -->
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				
			</div>

			<div class="col-md-9 learnpdu_right">
				<div class="box_learn section-video">
					<div class="iframe_video">
					<?php if($typevd == "yt"){?>
						<iframe class="embed-responsive-item video-iframe" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" allowfullscreen=""></iframe>
					<?php }else{ ?>
						<iframe class="embed-responsive-item video-iframe" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" allowfullscreen=""></iframe>
						<span id="boxchevd">
							<img src="<?php echo $this->templates_assets.'images/logovideo.jpg'; ?>" alt="Hello baby" />
						</span>
					<?php }; ?>
						<div id="tenbaihoc">
							<h2 class="text_gra1"></h2>
							<div class="dasboard_head_action">
				                <div class="box_action">
				                    <button class="show_child"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
				                    <ul class="show_content clearfix boxmenu_item">
				<li id="download_btn"><a href="#" target="_blank"><i class="fa fa-download" aria-hidden="true"></i>Download</a></li>
                <li class="share-facebook"><a href="https://www.facebook.com/sharer.php?u=<?php echo get_url_edu($oneItem); ?>" onclick="window.open(this.href, 'windowName', 'width=550, height=650, left=24, top=24, scrollbars, resizable'); return false;" rel='nofollow' title="Click to share on Facebook"><i class="fa fa-share" aria-hidden="true"></i>Share FB</a></li>
                <li id="report_btn"><a href="#"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Báo Lỗi</a></li>
				                    </ul>
				                </div>
				            </div>
						</div>
						<form id="note_edu" >
							<h3 class="collapsible-item--title text_gra1">Ghi chú khóa học</h3>
							<div class="collapsible-item--content" style="display: none;">
								<input type="hidden" name="edu_id" value="<?php echo $oneItem->id; ?>">
								<input type="hidden" name="title" value="<?php echo $oneItem->title; ?>">
								<input type="hidden" name="slug" value="<?php echo $oneItem->slug; ?>">
								<textarea name="content" class="form-control summernote">
									<?php echo !empty($note->content)?$note->content:""; ?>
								</textarea>
								<button class="btn btnSaveNote" >Lưu lại</button>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="text-center"><button id="come_backedu" title="quay lại"><i class="fa fa-arrow-left" aria-hidden="true"></i></button></div>

<?php }else{ ?>
		<strong>Khóa học này cập nhật chưa đủ bài giảng, Vui lòng <a href="<?php echo base_url("lien-he.html"); ?>">liên hệ</a> admin để cập nhật cho đủ.</strong>
		<button id="come_backedu" title="quay lại"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>

<?php }; ?>
<style>
	div#fixed-social-network {
		display: none;
	}
	.learnpdu {
		padding: 68px 0;
		position: relative;
	}
	.learnpdu_list {
		height: 686px;
		overflow-y: auto;
	}
	.learnpdu_list::-webkit-scrollbar {
		width: 5px;
		height: 8px;
	}

	.learnpdu_list::-webkit-scrollbar-thumb {
		background: #16A085;
		-webkit-box-shadow: inset 0 0 6px rgb(0 0 0 / 50%);
	}
	.learnpdu_list::-webkit-scrollbar-track {
		-webkit-box-shadow: inset 0 0 4px rgb(0 0 0 / 30%);
		background: #fff;
	}
	

	button.learnpdu_toggle {
		font-size: 40px;
		color: #55acee;
		font-weight: bold;
		position: fixed;
		top: 10px;
		left: 15px;
		z-index: 2;
		cursor: pointer;
	}
	button.learnpdu_toggle::before {
		content: "\f00d";
		display: inline-block;
		font-family: FontAwesome;
		-webkit-font-smoothing: antialiased;
	}
	button.learnpdu_toggle.closep::before{
		content: "\f0c9";
	}
	button.learnpdu_toggle:hover {
		color: #1f9dc9;
	}

	.learnpdu_left,.learnpdu_right{
		-webkit-transition: all ease 0.6s;
		transition: all ease 0.6s;
	}
	.learnpdu_left.closep {
		width: 0;
		height: 0;
		padding: 0;
	}
	tr.learnpdu_head th {
		font-size: 18px;
	}
	.box_learn {
		    margin-top: 30px;
		}
	button#come_backedu {
    color: #55acee;
    font-size: 2em;
    transition: all ease 0.6s;
    padding: 15px;
}

button#come_backedu:hover {
    transform: scale(2);
}
	@media (max-width: 991px) {
		.learnpdu_left {
			position: fixed;
			width: 340px;
			z-index: 1;
			background: #fff;
		}
		.learnpdu_list {
    height: 415px;
    overflow-y: auto;
}

	}
</style>

	</div>
</div>