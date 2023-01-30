<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>login</title>
	<link rel="stylesheet" href="public/style.css">
	<link rel="stylesheet" href="public/reset.css">
</head>
<body>
	


	<div class="login">
		<div class="container">
			<div class="login_box">
				<h1>trang login</h1>
				<form action="" method="post">
					<label>username</label>
					<input type="text" name="username" value="<?php echo set_cookie('user_login'); ?>">
					<?php form_error("username"); ?>

					<label>password</label>
					<input type="text" name="password">
					<?php form_error("password"); ?>

					<label>ghi nhớ đăng nhập</label>
					<input type="checkbox" name="remember_me" <?php if(isset($_COOKIE["is_login"])) { ?> checked
                	<?php } ?> /><br>

					<input type="submit" name="btn_login" value="đăng nhập">
					<?php form_error("account"); ?>
				</form>
			
			</div>
		</div>
	</div>
	
</body>
</html>
