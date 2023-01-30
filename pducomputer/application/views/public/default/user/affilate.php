
<div class="link_aff">
	<h2>Link giới thiệu</h2>
	<p>Link giới thiệu thành viên: <a href="<?php echo base_url("ref/").$this->session->userdata('username').'_'.$this->session->userdata('user_id'); ?>"><?php echo base_url("ref/").$this->session->userdata('username').'_'.$this->session->userdata('user_id'); ?></a> </p>
	<p>Bạn hãy copy link trên và mang đi chia sẻ tới mọi người. Khi có 1 người đăng ký tài khoản theo link của bạn thì bạn sẽ được thưởng 10 đồng coin</p>
</div>
<div class="tree_aff">
	<h2>Cây thành viên</h2>
	<p>Tổng user giới thiệu: <b><?php if(!empty($user_parent['count'])){echo $user_parent['count'];} ?></b></p>
	<div class="list-tree jstree-default" id="show-tree">
		<ul>
			<li class="jstree-open jstree-last">
				<i class="jstree-icon jstree-ocl"></i>
				<a class="jstree-anchor  jstree-clicked" href="#">
				<i class="jstree-icon jstree-themeicon"></i><?php echo $this->session->userdata('email'); ?>
				</a>
				<?php 
				if(!empty($user_parent['row'])){
					foreach($user_parent['row'] as $v){
				?>
			  <ul class="jstree-children">
			    <li class="jstree-node jstree-open jstree-last">
			    	<i class="jstree-icon jstree-ocl"></i>
					<a class="jstree-anchor" href="#">
					<i class="jstree-icon jstree-themeicon"></i><?php echo $v->username.'_'.$v->id; ?>
					</a>
			    	
			    	<ul class="jstree-children">
			    		<?php if(!empty($v->sub)){foreach($v->sub as $v2){ ?>
			    		<li class="jstree-node jstree-leaf jstree-last">
			    			<i class="jstree-icon jstree-ocl"></i>
							<a class="jstree-anchor jstree-disabled" href="#">
							<i class="jstree-icon jstree-themeicon"></i><?php echo $v2->username.'_'.$v2->id; ?>
							</a>
			    			</li>
			    		<?php }}; ?>
			    	</ul>
			    </li>
			  </ul>
			<?php }}; ?>
			</li>
		</ul>
	</div>
</div>
<script>
	jQuery(document).ready(function($) {
		$(".jstree-anchor").click(function(event) {
			event.preventDefault();
			$(".jstree-anchor").removeClass('jstree-clicked');
			$(this).addClass('jstree-clicked');
		});
		$(".jstree-ocl").click(function(event) {
			$(this).siblings('.jstree-children').slideToggle();
			$(this).parent("li").toggleClass('jstree-closed');
			$(this).parent("li").toggleClass('jstree-open');

		});
	});
</script>
