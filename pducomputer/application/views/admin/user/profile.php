<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="user-profile">
	<div class="profile-header-background">
		<img src="<?php echo $this->templates_assets.'images/city.jpg' ?>" alt="Profile Header Background">
	</div>
	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-4">
			<div class="profile-info-left">
				<div class="text-center">
					<img src="<?php echo $this->templates_assets.'images'?>/avatar1.png" alt="Avatar" class="avatar img-circle">
					<h2><?php echo $this->session->userdata['username'] ?></h2>
				</div>
				<div class="section">
					<h3>Giới thiệu</h3>
					<p>Đẹp zai</p>
				</div>
				<div class="section">
					<style>
						.form-control[disabled]{
							background: #fff;
						}
					</style>
					<?php echo form_open('',['id'=>'profile_user']) ?>
						<h3>Thông tin cá nhân</h3>
						<label>Tài khoản</label>
						<div class="form-group">
							<input name="username" placeholder="Tài khoản" class="form-control" disabled="" type="text" value="<?php echo $profile->username ?>" />
						</div>
						<label>Họ và tên</label>
						<div class="form-group">
							<input name="fullname" placeholder="Họ và tên" class="form-control" type="text" value="<?php echo $profile->fullname ?>" />
						</div>
						<label>Số điện thoại</label>
						<div class="form-group">
							<input name="phone" placeholder="Số điện thoại" class="form-control number" type="text" value="<?php echo $profile->phone ?>" />
						</div>
						<label>Mật khẩu</label>
						<div class="form-group">
							<input name="password" placeholder="Mật khẩu mới" class="form-control" type="password" />
						</div>
	                	<button class="btn btn-primary btnSaveProfile">Thay đổi</button>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-7">
			<div class="profile-info-right">
				<ul class="nav nav-pills nav-pills-custom-minimal custom-minimal-bottom">
					<li class="active"><a href="#activities" data-toggle="tab">Hoạt động gần đây</a></li>
				</ul>
				<div class="tab-content">
					<!-- Hoạt động gần đây -->
					<div class="tab-pane fade in active show" id="activities">

						<div class="media activity-item">
							<div class="media-body">
								<p class="activity-title"> Update video id <strong><a href="">1123</a></strong> <small class="text-muted">- 2m ago</small></p>
								<small class="text-muted">Today 08:30 am - 02.05.2014</small>
							</div>
						</div>

					</div>
					<!-- end Hoạt động gần đây -->
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	let url_ajax_load_group = '',
		url_ajax_update_profile = '<?php echo site_admin_url('user/ajax_update_profile') ?>';
</script>