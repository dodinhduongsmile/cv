<section class="register">
	<div class="container">
		<div class="register_content">
			<div class="re_title">
				<h4> <?php echo $title; ?></h4>
				<div class="registration">
					<p> <?php if($type == 1){
						echo "Vui lòng đi tới <a href='".base_url("user/login")."'>Đăng nhập</a>";
					}else{
						echo "Vui lòng đi tới <a href='".base_url()."'>Trang chủ</a>";
					} ?>
						
					</p>
				</div>
			</div>
			<div class="nofication">
				
				<?php if($type == 1){
				?>
				<li class="lino" style="background: #d1d5d8;">
					<p><?php echo $nofication; ?> </p>
					Vui lòng <a href="<?php echo base_url("user/login") ?>"/>Đăng nhập</a><br />
				<a href="#" title="Nhấn vào đây để tải lại trang">Tải lại trang<a>
				</li>
				<?php
				}else{
				?>
				<li class="lino" style="background: #e5b4b4;">
					<p><?php echo $nofication; ?> </p>
					Bạn sẽ chuyển sang trang <a href="<?php echo base_url() ?>"/>Trang chủ</a> sau <span id="time">10</span> giây nữa<br />
				<a href="/" title="Nhấn vào đây để tải lại trang">Tải lại trang<a>
				</li>
				<?php
				} ?>
				
			</div>
		</div>
	</div>
	<script type="text/javascript"> 
	    var jgt = 10;
	    document.getElementById('time').innerHTML = jgt;
	    function stime(){
	    	document.getElementById('time').innerHTML = jgt;
	    	jgt = jgt - 1;
	        if(jgt == 0){clearInterval(timing); location.href = base_url+'user/login';}
	    }
	    var timing = setInterval("stime();",1000);
	</script>
	<style>
		li.lino {
    padding: 50px 10px;
    
    font-size: 16px;
}
li.lino p {
    padding: 7px 0;
    font-size: 20px;
    font-weight: 700;
}
	</style>
</section>