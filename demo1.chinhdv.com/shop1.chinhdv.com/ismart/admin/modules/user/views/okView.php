<?php
get_header();
// show_array($_POST);
// echo $username;
?>

	<div class="login">
		<div class="container">
			<div class="login_box">
				<h1>THAO TÁC CỦA BẠN ĐÃ THÀNH CÔNG</h1>
				
				<p>Vui lòng click link sau để đăng nhập
					<a href="<?php echo base_url("?mod=user&action=login"); ?>">Đăng nhập</a>
				</p>
			</div>
		</div>
	</div>
	

<?php
get_footer();
?>